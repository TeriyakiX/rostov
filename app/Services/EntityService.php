<?php

namespace App\Services;

use App\Models\AkciiSlider;
use App\Models\Brand;
use App\Models\Calculator;
use App\Models\File;
use App\Models\IndexSlider;
use App\Models\Photo;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\RelatedProducts;
use App\Models\SimilarProducts;
use App\Models\Tags;
use App\Models\TagsCategories;
use App\Models\UsefulChapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class EntityService
{
    /**
     * EntityService constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param $model
     * @param $request
     * @return mixed
     */
    public function getItems($model, $request)
    {

        $models_sort = [
            Product::class,
            ProductCategory::class,
            IndexSlider::class,
            AkciiSlider::class,
            Calculator::class,
            UsefulChapter::class,
        ];
        Log::debug($request->all());
        return $model::query()

            ->when($request->get('search'), function ($q) use ($model, $request) {
                if ($model == Product::class) {
                    $q->where('title', 'LIKE', '%' . $request->get('search') . '%');
                }
            })
            ->when($request->all(), function ($q) use ($model, $request,$models_sort) {
                if (in_array($model,$models_sort) && $request->get('orderBy') == 'created_at') {

                    $request['orderBy'] = 'id';
                    $request['sortedBy'] = 'asc';

                    $q->sort($request->all());
                }
                else
                    $q->sort($request->all());

            }, function ($q) use ($request) {

                    $q->sort($request->all());

            })
            ->when($request->all(), function ($q) use ($model, $request,$models_sort) {
                if ($request->get('limit')  == -1) {
                    return $q->paginate($q->count());
                }
                else
                    return $q->paginate($request->get('limit', 10));

            }, function ($q) use ($request) {

                    return $q->paginate($request->get('limit', 10));

            })

        ;
    }

    /**
     * @param $model
     * @return array
     */
    public function getViewColumns($model)
    {
        $columnsArray = $model::ADMIN_VIEW;
        $return = [];
        foreach ($columnsArray as $fieldName => $data) {
            $return[] = [
                'label' => $data['title'],
                'field' => $fieldName,
            ];
        }
        $return[] = [
            'label'    => 'Действие',
            'field'    => 'actions',
            'sortable' => false,
        ];

        return $return;
    }

    /**
     * @param $fields
     * @return array
     */
    public function getValidationRules($fields)
    {
        $validationRules = [];
        foreach ($fields as $fieldName => $fieldData) {
            if (isset($fieldData['validation'])) {
                $validationRules[$fieldName] = $fieldData['validation'];
            }
        }

        return $validationRules;
    }

    /**
     * @param $model
     * @param $request
     * @return mixed
     */
    public function create($model, Request $request)
    {
        $data = $request->all();
        // if ( ! isset($data['sort'])) {
        //     $data['sort'] = 0;
        // }


        $fields = $model::ADMIN_EDIT;

        $item = $model::create($request->except('photos'));

        return $this->updateItem($item, $fields, $request, $data);
    }

    /**
     * @param $item
     * @param $request
     * @return mixed
     */
    public function update($item, Request $request)
    {

        $data = $request->all();

        $model = get_class($item);
        $fields = $model::ADMIN_EDIT;

        return $this->updateItem($item, $fields, $request, $data);
    }

    /**
     * @param $item
     * @param $fields
     * @param $request
     * @param $data
     * @return mixed
     */
    public function updateItem($item, $fields, $request, $data)
    {
        $model = get_class($item);
        foreach ($fields as $fieldName => $fieldData) {

            switch ($fieldData) {
                case $fieldData['type'] == 'photo':
                    if ($request->hasFile($fieldName)) {
                        $data[$fieldName] = $this->loadPhoto($request, $fieldName, $fieldData, $item);
                    }
                    break;
                case $fieldData['type'] == 'photos':
                    $this->loadPhotos($request, $fieldName, $fieldData, $item, $data);
                    unset($data['photos']);
                    break;

                case $fieldData['type'] == 'files':
                    if($model == Brand::class){
                        unset($data['photos']);
                    }
                    $this->loadFiles($request, $fieldName, $fieldData, $item, $data);
                    break;

                case $fieldData['type'] == 'tags':
                case $fieldData['type'] == 'belongsToMany' || $fieldData['type'] == 'categories':
                    if (isset($data[$fieldName])) {

                        $item->{$fieldName}()->sync($data[$fieldName]);
                    }
                    break;
                case $fieldData['type'] == 'attributes':
                    $this->saveAttributes($request, $fieldName, $fieldData, $item, $data);
                    break;
                case $fieldData['type'] == 'multiselectSimilar':
                case $fieldData['type'] == 'multiselect':

                    if (isset($data[$fieldName])) {
                        $item->{$fieldData['relation']}()->sync($data[$fieldName]);
                    } else {
                        $item->{$fieldData['relation']}()->sync([]); // detach anything
                    }
                    break;
            }
        }

        if (isset($request->similarSort)) {
            $similarSort = $request->similarSort;
            foreach ($similarSort as $key => $value) {

                $similarProductsCount = SimilarProducts::where('similar_product_id', $key)
                    ->where('product_id', $item->id)->count()
                ;
                if ($similarProductsCount > 0) {
                    SimilarProducts::where('similar_product_id', $key)->where('product_id', $item->id)
                        ->update(['simSort' => $value[0]])
                    ;

                }
            }
        }
        if (isset($request->relSort)) {
            $relSort = $request->relSort;
            foreach ($relSort as $key => $value) {

                $similarProductsCount = RelatedProducts::where('related_product_id', $key)
                    ->where('product_id', $item->id)->count()
                ;
                if ($similarProductsCount > 0) {
                    RelatedProducts::where('related_product_id', $key)->where('product_id', $item->id)
                        ->update(['relSort' => $value[0]])
                    ;

                }
            }
        }

        return $item->update($data);

    }

    /**
     * @param $request
     * @param $fieldName
     * @param $fieldData
     * @param $item
     * @param $data
     */
    public function saveAttributes($request, $fieldName, $fieldData, $item, $data)
    {
        $attributes = $data['attributes'];
        $item->attributeItems()->delete(); // flush before save
        foreach ($attributes as $index => $attributeId) {
            if ($index === 0) {
                continue;
            }
            $options = $data['options'][$attributeId] ?? [];
            foreach ($options as $optionId) {
                if ( ! $optionId) {
                    continue;
                }
                $price = $data['prices'][$attributeId][$optionId] ?? 0;
                $item->attributeItems()->create([
                    'attribute_item_id' => $attributeId,
                    'option_item_id'    => $optionId,
                    'price'             => $price,
                ]);
            }
        }
    }

    /**
     * @param Request $request
     * @param         $fieldName
     * @param         $fieldData
     * @param         $item
     * @return bool
     */
    public function loadPhoto(Request $request, $fieldName, $fieldData, $item)
    {

        if ( ! $request->hasFile($fieldName)) {
            return;
        }

        if (isset($item->$fieldName) && $item->$fieldName !== '' && file_exists(public_path('upload_images' . $item->$fieldName))) {
            unlink(public_path('upload_images/' . $item->$fieldName));
        }

        $photo = $request->file($fieldName);
        $path = $fieldData['prefix'] ?? '/';
        $tmpFileName = date('mdYHis') . uniqid();
        $extension = $photo->extension();

        $tmpFile = Storage::disk('images')
            ->putFileAs($path, $photo, $tmpFileName . '.' . $extension)
        ;
        if ($path !== '/') {
            $newFilePath = $path . '/';
        } else {
            $newFilePath = '/';
        }
        $fullFilePath = public_path('upload_images') . $newFilePath . $tmpFileName . '.' . $extension;

        $stamp = imagecreatefrompng(public_path('img/watermark.png'));
        $alpha = 90;//Уровень прозрачности

      ImageColorAllocateAlpha($stamp, 0, 0, 0, $alpha);

        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                $im = imagecreatefromjpeg($fullFilePath);
                break;
            case 'png':
                $im = imagecreatefrompng($fullFilePath);
                break;
            default:
                $im = imagecreatefromjpeg($fullFilePath);
        }
        Storage::disk('images')->delete($tmpFile);

        $marge_right = 10;
        $marge_bottom = 10;
        $sx = imagesx($stamp);
        $sy = imagesy($stamp);
        imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0,
            imagesx($stamp),
            imagesy($stamp));
        switch ($extension) {
            case 'jpeg':
            case 'jpg':
                imagejpeg($im, $fullFilePath);
                break;
            case 'png':
                imagepng($im, $fullFilePath);
                break;
            default:
                imagejpeg($im, $fullFilePath);
        }

        return $tmpFile;


    }

    /**
     * @param Request $request
     * @param         $fieldName
     * @param         $fieldData
     * @param         $item
     * @param         $data
     * @return void
     */
    public function loadPhotos(Request $request, $fieldName, $fieldData, $item, $data)
    {
        $photos = $data[$fieldName] ?? null;
        if ( ! $photos) {
            return;
        }

        foreach ($photos as $photo) {
            if ( ! $photo->isFile()) {
                continue;
            }

            $path = $fieldData['prefix'] ?? '/';
            $tmpFileName = date('mdYHis') . uniqid();
            $extension = $photo->extension();

            $tmpFile = Storage::disk('images')
                ->putFileAs($path, $photo, $tmpFileName . '.' . $extension)
            ;
            if ($path !== '/') {
                $newFilePath = $path . '/';
            } else {
                $newFilePath = '/';
            }
            $fullFilePath = public_path('upload_images') . $newFilePath . $tmpFileName . '.' . $extension;

            $stamp = imagecreatefrompng(public_path('img/watermark.png'));
            $alpha = 30;//Уровень прозрачности
            ImageColorAllocateAlpha($stamp, 0, 0, 0, $alpha);

            switch ($extension) {
                case 'jpeg':
                case 'jpg':
                    $im = imagecreatefromjpeg($fullFilePath);
                    break;
                case 'png':
                    $im = imagecreatefrompng($fullFilePath);
                    break;
                default:
                    $im = imagecreatefromjpeg($fullFilePath);
            }
            Storage::disk('images')->delete($tmpFile);

            $marge_right = 10;
            $marge_bottom = 10;
            $sx = imagesx($stamp);
            $sy = imagesy($stamp);
            imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0,
                imagesx($stamp),
                imagesy($stamp));
            switch ($extension) {
                case 'jpeg':
                case 'jpg':
                    imagejpeg($im, $fullFilePath);
                    break;
                case 'png':
                    imagepng($im, $fullFilePath);
                    break;
                default:
                    imagejpeg($im, $fullFilePath);
            }

            Photo::query()->create([
                'path'           => $tmpFile,
                'photoable_id'   => $item->id,
                'photoable_type' => get_class($item),
            ]);
        }
    }

    /**
     * @param Request $request
     * @param         $fieldName
     * @param         $fieldData
     * @param         $item
     * @param         $data
     */
    public function loadFiles(Request $request, $fieldName, $fieldData, $item, $data)
    {
        $files = $data[$fieldName] ?? null;
        if ( ! $files) {
            return;
        }

        $request->validate([
            $fieldName . '.*' => 'nullable|file|mimes:jpeg,pdf',
        ]);

        foreach ($files as $file) {
            if ( ! $file->isFile()) {
                continue;
            }

            $path = $fieldData['prefix'] ?? '/';
            $filename = rand(11111, 99999) . '_' . $file->getClientOriginalName();

            $filePath = Storage::disk('files')
                ->putFileAs(
                    $path,
                    $file,
                    $filename)
            ;
            $extension = $file->extension();
            if ($extension === 'jpeg' || $extension === 'jpg') {
                if ($path !== '/') {
                    $newFilePath = $path . '/';
                } else {
                    $newFilePath = '/';
                }
                $fullFilePath = public_path('upload_files') . $newFilePath . $filePath;

                $stamp = imagecreatefrompng(public_path('img/watermark.png'));
                $alpha = 30;//Уровень прозрачности
                ImageColorAllocateAlpha($stamp, 0, 0, 0, $alpha);

                switch ($extension) {
                    case 'jpeg':
                    case 'jpg':
                        $im = imagecreatefromjpeg($fullFilePath);
                        break;
                    case 'png':
                        $im = imagecreatefrompng($fullFilePath);
                        break;
                    default:
                        $im = imagecreatefromjpeg($fullFilePath);
                }
                Storage::disk('images')->delete($filePath);

                $marge_right = 10;
                $marge_bottom = 10;
                $sx = imagesx($stamp);
                $sy = imagesy($stamp);
                imagecopy($im, $stamp, imagesx($im) - $sx - $marge_right, imagesy($im) - $sy - $marge_bottom, 0, 0,
                    imagesx($stamp),
                    imagesy($stamp));
                imagejpeg($im, $fullFilePath);
            }

            File::query()->create([
                'filepath'      => $filePath,
                'title'         => $file->getClientOriginalName(),
                'fileable_id'   => $item->id,
                'fileable_type' => get_class($item),
            ]);
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function deletePhoto($id)
    {
        /** @var Photo $photo */
        $photo = Photo::find($id);

        if (file_exists(public_path('upload_images/' . $photo->path))) {
            unlink(public_path('upload_images/' . $photo->path));
        }

        $photo->delete();

        return true;
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteFile($id)
    {
        /** @var File $photo */
        $file = File::find($id);

        if (file_exists(public_path('upload_files/' . $file->filepath))) {
            unlink(public_path('upload_files/' . $file->filepath));
        }

        $file->delete();

        return true;
    }

    /**
     * @param $attributeItem
     * @return string
     */
    public function getAttributeOptions($attributeItem)
    {
        $options = $attributeItem->optionItems()->orderBy('option_items.title', 'asc')->get();

        return view('admin.fields._attribute_option', compact('options', 'attributeItem'))->render();
    }

    /**
     * @param $productId
     * @return array
     */
    public function multiselectItems($productId, $type)
    {


        $items = Product::query()
            ->where('id', '!=', $productId)
            ->with('categories')
            ->orderBy('title', 'asc')
            ->get()
        ;

        $product = Product::find($productId);
        $relatedProducts = [];
        if ($product) {
            switch ($type) {
                case 'similar':
                    $relatedProducts = $product->similarProducts()->pluck('id')->toArray();
                    break;
                case 'related':
                    $relatedProducts = $product->relatedProducts()->pluck('id')->toArray();
                    break;
            }
        }

        $return = [];

        /**
         *     {
         *        disabled: false,
         *        groupId: 2,
         *        groupName: "Group fff",
         *        id: 1,
         *        name: "Paul Gary Johnson",
         *        selected: false
         *     }
         */

        foreach ($items as $item) {
            /** @var ProductCategory $category */
            $category = $item->categories->first();
            $return[] = [
                'disabled'  => false,
                'groupId'   => $category ? $category->id : 0,
                'groupName' => $category ? $category->title : '-',
                'id'        => $item->id,
                'name'      => $item->title,
                'selected'  => in_array($item->id, $relatedProducts),
            ];
        }

        return $return;

    }

    /**
     * @param $entity
     * @return array
     */
    public function multiselectTags($entity)
    {
        $rootTags = TagsCategories::query()
            ->where('slug', $entity)
            ->with('tags')
            ->orderBy('title', 'asc')
            ->get()
        ;
        $return = [];
        /**
         *     {
         *        disabled: false,
         *        groupId: 2,
         *        groupName: "Group fff",
         *        id: 1,
         *        name: "Paul Gary Johnson",
         *        selected: false
         *     }
         */

        foreach ($rootTags as $index => $itemTag) {
            foreach ($itemTag->tags as $tag) {
                $return[] = [
                    'disabled' => false,
                    'id'       => $tag->id,
                    'name'     => $tag->title,

                ];
            }
        }

        return $return;
    }
}

