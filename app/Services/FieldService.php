<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\TagsCategories;
use Illuminate\Support\Facades\DB;

class FieldService
{
    /**
     * FieldService constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * @param $config
     * @param $editFields
     * @param null $item
     * @return mixed
     */
    public function index($config, $editFields, $item = null, $entity = null)
    {

        $return = '';

		//print_r($item); die();

        foreach ($editFields as $fieldName => $fieldData) {

            switch ($fieldData['type']) {

                case 'text':
                    $return .= $this->text($fieldName, $fieldData, $item);
                    break;
                case 'text_large':
                    $return .= $this->textLarge($fieldName, $fieldData, $item);
                    break;
                case 'text_disabled':
                    $return .= $this->textDisabled($fieldName, $fieldData, $item);
                    break;

                case 'editor':
                    $return .= $this->editor($fieldName, $fieldData, $item);
                    break;

                case 'checkbox':
                    $return .= $this->checkbox($fieldName, $fieldData, $item);
                    break;
                case 'dateTime':

                    $return .= $this->endPromoDate($fieldName, $fieldData, $item);
                    $return .= $this->endNovetlyDate($fieldName, $fieldData, $item);
                    break;
                case 'belongsTo':
                    $return .= $this->belongsTo($fieldName, $fieldData, false, $item);
                    break;

                case 'parentCategories':
                    $return .= $this->belongsTo($fieldName, $fieldData, true, $item);
                    break;

                case 'belongsToMany':
                    $return .= $this->belongsToMany($fieldName, $fieldData, $item);
                    break;

                case 'categories':
                    $return .= $this->categories($fieldName, $fieldData, $item);
                    break;

                case 'photo':
                    $return .= $this->photo($fieldName, $fieldData, $item);
                    break;

                case 'photos':
                    $return .= $this->photos($fieldName, $fieldData, $item);
                    break;

                case 'attributes':
                    $return .= $this->attributes($fieldName, $fieldData, $item);
                    break;

                case 'product_type':
                    $return .= $this->productType($fieldName, $fieldData, $item);
                    break;
                case 'unit_type':
                    $return .= $this->unitType($fieldName, $fieldData, $item);
                    break;
                case 'multiselect':
                    $return .= $this->multiselect($fieldName, $fieldData, $item);
                    break;
                case 'multiselectSimilar':
                    $return.=$this->multiselectSimilar($fieldName, $fieldData, $item);
                    break;
                case 'tags_with_search':
                    $return .= $this->tagsSearch($fieldName, $fieldData, $item, $entity);
                case 'positions':
                    $return .= $this->positions($fieldName, $fieldData, $item);
                    break;
                case 'tags':
                    $return .= $this->tags($fieldName, $fieldData, $item, $entity);
                    break;
                case 'files':
                    $return .= $this->files($fieldName, $fieldData, $item);
                    break;


            }

        }

        return $return;
    }

    /**
     * @param $fieldName
     * @param $fieldData
     * @param null $item
     * @return string
     */
    public function text($fieldName, $fieldData, $item = null)
    {
        return view('admin.fields._text')
            ->with(compact('fieldName', 'fieldData', 'item'))
            ->render();
    }

    /**
     * @param $fieldName
     * @param $fieldData
     * @param null $item
     * @return string
     */
    public function textLarge($fieldName, $fieldData, $item = null)
    {
        return view('admin.fields._text_large')
            ->with(compact('fieldName', 'fieldData', 'item'))
            ->render();
    }

    /**
     * @param $fieldName
     * @param $fieldData
     * @param null $item
     * @return string
     */
    public function textDisabled($fieldName, $fieldData, $item = null)
    {
        return view('admin.fields._text_disabled')
            ->with(compact('fieldName', 'fieldData', 'item'))
            ->render();
    }

    /**
     * @param $fieldName
     * @param $fieldData
     * @param null $item
     * @return string
     */
    public function editor($fieldName, $fieldData, $item = null)
    {
        return view('admin.fields._editor')
            ->with(compact('fieldName', 'fieldData', 'item'))
            ->render();
    }

    /**
     * @param $fieldName
     * @param $fieldData
     * @param null $item
     * @return string
     */
    public function checkbox($fieldName, $fieldData, $item = null)
    {
        return view('admin.fields._checkbox')
            ->with(compact('fieldName', 'fieldData', 'item'))
            ->render();
    }

    /**
     * @param $fieldName
     * @param $fieldData
     * @param null $item
     * @return string
     */
    public function endPromoDate($fieldName, $fieldData, $item = null)
    {
        return view('admin.fields._end_promo_date')
            ->with(compact('fieldName', 'fieldData', 'item'))
            ->render();
    }
    /**
     * @param $fieldName
     * @param $fieldData
     * @param null $item
     * @return string
     */
    public function endNovetlyDate($fieldName, $fieldData, $item = null)
    {
        return view('admin.fields._end_novelty_date')
            ->with(compact('fieldName', 'fieldData', 'item'))
            ->render();
    }
    /**
     * @param $fieldName
     * @param $fieldData
     * @param false $notSelf
     * @param null $item
     * @return string
     */
    public function belongsTo($fieldName, $fieldData, $notSelf = false, $item = null)
    {
        $optionsModel = $fieldData['model'];
		//print_r($fieldData['model']);
        if ($notSelf && $item) {
            $optionsItems = $optionsModel::where('id', '!=', $item->id) // not self
            ->orderBy('title', 'asc')
                ->get();
			/* $optionsItems = $optionsModel::query();
			print_r($optionsItems); die(); */
			//$category_ids = $category->getDescendants($category);



        } else {
            $optionsItems = $optionsModel::query() // all
            ->orderBy('title', 'asc')
                ->get();
        }
        return view('admin.fields._select')
            ->with(compact('fieldName', 'fieldData', 'item', 'optionsItems'))
            ->render();
    }

    /**
     * @param $fieldName
     * @param $fieldData
     * @param null $item
     * @return string
     */
    public function belongsToMany($fieldName, $fieldData, $item = null)
    {
        $optionsModel = $fieldData['model'];
        $optionsItems = $optionsModel::orderBy('title', 'asc')
            ->get();
        return view('admin.fields._multiselect')
            ->with(compact('fieldName', 'fieldData', 'item', 'optionsItems'))
            ->render();
    }

    /**
     * @param $fieldName
     * @param $fieldData
     * @param $entity
     * @param null $item
     * @return string
     */
    public function tagsSearch($fieldName, $fieldData, $item = null, $entity): string
    {

        $rootTags = TagsCategories::query()
            ->where('slug', $entity)
            ->with('tags')
            ->orderBy('title', 'asc')
            ->get();

        return view('admin.fields._tags_with_search')
            ->with(compact('fieldName', 'fieldData', 'item', 'rootTags'))
            ->render();
    }

    /**
     * @param $fieldName
     * @param $fieldData
     * @param $entity
     * @param null $item
     * @return string
     */
    public function tags($fieldName, $fieldData, $item = null, $entity)
    {
        $rootTags = TagsCategories::query()
            ->where('slug', $entity)
            ->with('tags')
            ->orderBy('title', 'asc')
            ->get();
        return view('admin.fields._tags')
            ->with(compact('fieldName', 'fieldData', 'item', 'rootTags', 'entity'))
            ->render();
    }

    /**
     * @param $fieldName
     * @param $fieldData
     * @param null $item
     * @return string
     */
    public function categories($fieldName, $fieldData, $item = null)
    {
        $rootCategories = ProductCategory::query()
            ->with('subcategories')
            ->whereNull('parent_id')
            ->orderBy('title', 'asc')
            ->get();
		 $rootSubCategories = ProductCategory::whereNotNull('parent_id')->orderBy('sort', 'desc')->get();

        return view('admin.fields._categories')
            ->with(compact('fieldName', 'fieldData', 'item', 'rootCategories', 'rootSubCategories'))
            ->render();
    }

    /**
     * @param $fieldName
     * @param $fieldData
     * @param null $item
     * @return string
     */
    public function photo($fieldName, $fieldData, $item = null)
    {
        $photoPath = null;
        if ($item) {
            $photoPath = $item->$fieldName;
        }
        return view('admin.fields._photo')
            ->with(compact('fieldName', 'fieldData', 'item', 'photoPath'))
            ->render();
    }

    /**
     * @param $fieldName
     * @param $fieldData
     * @param null $item
     * @return string
     */
    public function photos($fieldName, $fieldData, $item = null)
    {
        $photos = null;
        if ($item) {
            $photos = $item->photos()->get();
        }
        return view('admin.fields._photos')
            ->with(compact('fieldName', 'fieldData', 'item', 'photos'))
            ->render();
    }

    /**
     * @param $fieldName
     * @param $fieldData
     * @param null $item
     * @return string
     */
    public function productType($fieldName, $fieldData, $item = null)
    {
        return view('admin.fields._product_type')
            ->with(compact('fieldName', 'fieldData', 'item'))
            ->render();
    }

    /**
     * @param $fieldName
     * @param $fieldData
     * @param null $item
     * @return string
     */
    public function unitType($fieldName, $fieldData, $item = null)
    {
        return view('admin.fields._unit_type')->with(compact('fieldName', 'fieldData', 'item'));
    }

    /**
     * @param $fieldName
     * @param $fieldData
     * @param null $item
     * @return string
     */
    public function multiselect($fieldName, $fieldData, $item = null)
    {
        return view('admin.fields._multiselect_with_search')
            ->with(compact('fieldName', 'fieldData', 'item'))
            ->render();
    }
    /**
     * @param $fieldName
     * @param $fieldData
     * @param null $item
     * @return string
     */
    public function multiselectSimilar($fieldName, $fieldData, $item = null)
    {
        return view('admin.fields._multiselectSimilar')
            ->with(compact('fieldName', 'fieldData', 'item'))
            ->render();
    }
    /**
     * @param $fieldName
     * @param $fieldData
     * @param null $item
     * @return string
     */
    public function files($fieldName, $fieldData, $item = null)
    {
        $files = null;
        if ($item) {
            $files = $item->files()->get();
        }
        return view('admin.fields._files')
            ->with(compact('fieldName', 'fieldData', 'item', 'files'))
            ->render();
    }

    /**
     * @param $fieldName
     * @param $fieldData
     * @param null $item
     * @return string
     */
    public function positions($fieldName, $fieldData, $item = null)
    {
        $positions = null;
        if ($item) {
            $positions = $item->products;
        }
        return view('admin.fields._positions')
            ->with(compact('fieldName', 'fieldData', 'item', 'positions'))
            ->render();
    }

    /**
     * @param $fieldName
     * @param $fieldData
     * @param null $item
     * @return string
     */
    public function attributes($fieldName, $fieldData, $item = null)
    {
        $x = new Product();
        if ($item !== null) {
            $itemAttributes = $item->attributeItems()->with(['attribute', 'option'])->get();
        } else {
            $itemAttributes = [];
        }

        $attributesArray = [];
        foreach ($itemAttributes as $item) {
            $option = $item->option;
            $attributesArray[$item->attribute_item_id]['attribute'] = $item->attribute;
            $attributesArray[$item->attribute_item_id]['options'][$option->id] = $option->id;
            $attributesArray[$item->attribute_item_id]['prices'][$option->id] = $item->price;

            $allOptions = $item->attribute->optionItems;
            $attributesArray[$item->attribute_item_id]['allOptions'] = $allOptions;
        }
//        dd($attributesArray);

        $attributeItems = \App\Models\AttributeItem::query()
            ->orderBy('title', 'asc')
            ->get();
        return view('admin.fields._attributes')
            ->with(compact(
                'fieldName', 'fieldData', 'item',
                'attributesArray',
                'attributeItems'))
            ->render();
    }

}
