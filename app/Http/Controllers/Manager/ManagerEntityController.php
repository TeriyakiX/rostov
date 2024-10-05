<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Resources\EntityCollection;
use App\Models\AttributeItem;
use App\Models\Order;
use App\Models\ProductCategory;
use App\Models\UsefulChapter;
use App\Services\EntityService;
use App\Services\FieldService;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ManagerEntityController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param \Illuminate\Http\Request $request
     * @param $entity
     * @param EntityService $entityService
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request, $entity, EntityService $entityService)
    {
        $config = config('manager.entities.' . $entity);
        if ($request->ajax()) {
            // get table data
            $model = $config['model'];

            $items = $entityService->getItems($model, $request);
            $columns = $entityService->getViewColumns($model);
            return [
                'items' => EntityCollection::make($items)->setEntity($entity),
                'columns' => $columns,
                'meta' => ['total' => $items->total()]
            ];
        }

        return view('admin.entity.index')->with(compact('entity', 'config'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $entity
     * @param $id
     * @param FieldService $fieldService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, $entity, $id, FieldService $fieldService)
    {
        $config = config('admin.entities.' . $entity);
        $model = $config['model'];
        $item = $model::findOrFail($id);

        $fieldsHtml = $fieldService->index($config, $model::ADMIN_EDIT, $item, $entity);

        return view('admin.entity.update')->with(compact('entity', 'id', 'item', 'config', 'fieldsHtml'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $entity
     * @param $id
     * @param EntityService $entityService
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $entity, $id, EntityService $entityService)
    {

//        dd($request->all());
        $input = $request->file();
        $imageName = time().'.'.$input['photos'][0]->getClientOriginalExtension();
        $input['photos'][0]->move(public_path('/upload_files'), $imageName);
//        logger($request->all());


        $config = config('admin.entities.' . $entity);
        $model = $config['model'];

        $editFields = $model::ADMIN_EDIT;
        $validationRules = $entityService->getValidationRules($editFields);
        $this->validate($request, $validationRules);
        $item = $model::findOrFail($id);

        if ($model === 'App\Models\Post') {

            $usefulChapterCount = UsefulChapter::where('slug', $item->slug)->count();
            if ($usefulChapterCount > 0) {
                $usefulChapter = UsefulChapter::where('slug', $item->slug)->first();

                $editFieldsPosts = \App\Models\Post::ADMIN_EDIT;
                $validationRulesPosts = $entityService->getValidationRules($editFieldsPosts);
                $this->validate($request, $validationRulesPosts);
                $entityService->update($usefulChapter, $request);

            } elseif (isset($request->show_in_header) && $request->show_in_header == 1 && isset($request->categories) && in_array(2, $request->categories)) {
                $chapterRequest = $request;
                $editFieldsPosts = \App\Models\Post::ADMIN_EDIT;
                $validationRulesPosts = $entityService->getValidationRules($editFieldsPosts);
                $this->validate($chapterRequest, $validationRulesPosts);

                $entityService->create('App\Models\UsefulChapter', $chapterRequest);
            }
        }
        $entityService->update($item, $request);
        $order = Order::query()->find($id);

        $data = $request->file();
        Mail::send('posts.email', $data, function ($message) use ($data, $order, $imageName) {
            $message->to($order->email)->subject('Уведомление о заказе!')
                ->attach(public_path('upload_files/'.$imageName));
        });
        return back();
    }

    /**
     * @param $entity
     * @param FieldService $fieldService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create($entity, FieldService $fieldService)
    {

        $config = config('admin.entities.' . $entity);

        $model = $config['model'];

        $fieldsHtml = $fieldService->index($config, $model::ADMIN_EDIT, null, $entity);

        return view('admin.entity.create')->with(compact('entity', 'config', 'fieldsHtml'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $entity
     * @param EntityService $entityService
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, $entity, EntityService $entityService)
    {

        $config = config('admin.entities.' . $entity);
        $model = $config['model'];

        if ($model === 'App\Models\Post' && $request->show_in_header == 1 && isset($request->categories) && in_array(2, $request->categories)) {
            $chapterRequest = $request;
            $editFieldsPosts = \App\Models\Post::ADMIN_EDIT;
            $validationRulesPosts = $entityService->getValidationRules($editFieldsPosts);
            $this->validate($chapterRequest, $validationRulesPosts);

            $entityService->create('App\Models\UsefulChapter', $chapterRequest);

        }

        $editFields = $model::ADMIN_EDIT;
        $validationRules = $entityService->getValidationRules($editFields);

        $entityService->create($model, $request);


        return redirect()->route('admin.entity.index', ['entity' => $entity]);
    }

    /**
     * @param Request $request
     * @param $entity
     * @param $id
     * @param EntityService $entityService
     * @return \Illuminate\Http\RedirectResponse
     */
    public
    function delete(Request $request, $entity, $id, EntityService $entityService)
    {


        $config = config('admin.entities.' . $entity);
        $model = $config['model'];
        $item = $model::find($id);
        if ($model === 'App\Models\Post') {

            $itemPostCount = \App\Models\UsefulChapter::where('slug', $item->slug)->count();
            if ($itemPostCount > 0) {
                $itemPost = \App\Models\UsefulChapter::where('slug', $item->slug)->first();
                $itemPost->delete();
            }

        }
        $item->delete();
        return back();
    }

    /**
     * @param Request $request
     * @param $id
     * @param EntityService $entityService
     * @return bool
     */
    public
    function photoDelete(Request $request, $id, EntityService $entityService)
    {
        return $entityService->deletePhoto($id);
    }

    /**
     * @param Request $request
     * @param $id
     * @param EntityService $entityService
     * @return bool
     */
    public
    function fileDelete(Request $request, $id, EntityService $entityService)
    {
        return $entityService->deleteFile($id);
    }

    /**
     * @param Request $request
     * @return
     */
    public
    function photoUpload(Request $request)
    {
        // delete old photo
        if (file_exists(public_path('upload_images/' . $request->file('file')))) {
            unlink(public_path('upload_images/' . $request->file('file')));
        }

        $photo = $request->file('file');
        $path = '/';
        $name = date('mdYHis') . uniqid();
        $extension = $photo->extension();

        return '/upload_images/' . Storage::disk('images')
                ->putFileAs($path, $photo, $name . '.' . $extension);
    }

    /**
     * @param Request $request
     */
    public
    function deleteSummernotePhoto(Request $request)
    {
        $fullPath = $request->get('filename');
        $fullPathArray = explode('/', $fullPath);
        $fileName = end($fullPathArray);
        File::delete(public_path('/upload_images/' . $fileName));
    }

    /**
     * @param Request $request
     * @param $code
     * @param EntityService $entityService
     * @return string
     */
    public
    function getAttributeOptions(Request $request, $id, EntityService $entityService)
    {
        $attributeItem = AttributeItem::query()->findOrFail($id);
        return $entityService->getAttributeOptions($attributeItem);
    }

    /**
     * @param Request $request
     * @param EntityService $entityService
     * @return
     */
    public
    function multiselectItems(Request $request, EntityService $entityService)
    {
        return $entityService->multiselectItems($request->get('productId'),$request->get('type'));
    }

    /**
     * @param Request $request
     * @param EntityService $entityService
     * @return
     */
    public
    function multiselectTags(Request $request, EntityService $entityService)
    {
        return $entityService->multiselectTags($request->get('entity'));
    }

    public
    function checkAllProducts(Request $request)
    {

        $product_id = ProductCategory::select('id')->where('title', $request->categoryName)->first();
        $query = DB::table('product_product_category')
            ->where('product_category_id', '=', $product_id->id)
            ->get();
        return response()->json($query);
    }

}

