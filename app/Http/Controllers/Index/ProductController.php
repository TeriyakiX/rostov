<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Models\AttributeItem;
use App\Models\Brand;
use App\Models\BrandTags;
use App\Models\Coatings;
use App\Models\CompareCoatings;
use App\Models\OptionItem;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class ProductController extends Controller
{
    /**
     * @param $category
     * @param $product
     * @param ProductService $productService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($category, $product, ProductService $productService)
    {

        $category = ProductCategory::query()
            ->whereSlug($category)
            ->firstOrFail();


        $product = Product::query()
            ->statusActive()
            ->whereHas('categories', function ($qCategories) use ($category) {
                $qCategories->where('product_categories.id', $category->id);
            })
            ->whereSlug($product)
            ->with([
                'photos',
                'attributeItems',
                'attributeItems.attribute',
                'attributeItems.option',
                'relatedProducts' => function ($q) {
                    $q->orderBy('relSort', 'DESC');
                },
                'similarProducts' => function ($q) {
                    $q->orderBy('simSort', 'DESC');
                }
            ])
            ->firstOrFail();

        $category_ = [];
        foreach ($product->categories as $category) {
            $category_[$category->id] = $category->parent_id ? $category->parent_id : 0;
        }

        for ($i = 0; $i < count($category_); $i++)
            foreach ($category_ as $value)
                    if ($value && $cat = ProductCategory::where('id',$value)->first())
                    $category_[$cat->id] = null;


        foreach ($category_ as $key => $value)
            if ($value)
                $category = ProductCategory::where('id',$key)->first();



        $sliderProducts = Product::query()
            ->statusActive()
            ->with(['categories'])
            ->orderBy('sort', 'desc')
            ->get();
        $viewedIds = $productService->addToSession($product->id, 'viewed', false)['ids'];

        $profile_type = explode(" ", $product['profile_type']);
        $manufacturer = explode(" ", $product['manufacturer']);
        $thickness = explode(" ", $product['thickness']);
//        dd($manufacturer);

        $viewedProducts = Product::query()
            ->whereIn('id', $viewedIds)
            ->where('id', '!=', $product->id)
            ->statusActive()
            ->with([
                'photos',
                'attributeItems',
                'attributeItems.attribute',
                'attributeItems.option',
                'relatedProducts'
            ])
            ->orderByRaw('FIELD(id, "' . implode(',', $viewedIds) . '")')
            ->get();

        // ATTRIBUTES - OPTIONS
        $itemAttributes = $product->attributeItems;
        $productAttributes = [];
        foreach ($itemAttributes as $attribute) {
            $product_attribute = ProductAttribute::where('product_id',$product->id)->where('option_item_id',$attribute->option->id)->first();
            if($product_attribute)
                $attribute->option->price = $product_attribute->price;




            $productAttributes[$attribute->attribute_item_id]['model'] = $attribute->attribute;
            $productAttributes[$attribute->attribute_item_id]['options'][] = $attribute->option;
        }



        $photos = $product->photos;
        $firstPhoto = null;
        $threePhotos = [];
        $otherPhotos = [];
        foreach ($photos as $index => $photo) {
            if ($index == 0) {
                $firstPhoto = $photo;
            } elseif ($index > 0 && $index <= 3) {
                $threePhotos[] = $photo;
            } else {
                $otherPhotos[] = $photo;
            }
        }


        return view('products.show')->with(compact(
            'product', 'category', 'manufacturer', 'thickness',
            'profile_type', 'sliderProducts', 'productAttributes',
            'photos', 'firstPhoto', 'threePhotos',
            'otherPhotos', 'viewedProducts'));
    }

    public function coatingShow($slug)
    {
        $coating = Coatings::query()
            ->whereSlug($slug)
            ->firstOrFail();

        $photos = $coating->photos;
        $firstPhoto = null;
        $threePhotos = [];
        $otherPhotos = [];
        foreach ($photos as $index => $photo) {
            if ($index == 0) {
                $firstPhoto = $photo;
            } else {
                $otherPhotos[] = $photo;
            }
        }

        $products = Product::where('coatings_id', $coating->id)->paginate(8);

        return view('coatings.show')->with(compact(
            'coating', 'products', 'photos', 'firstPhoto', 'otherPhotos'));
    }

    public function deleteCompareCoating(Request $request)
    {
        $array = Session::get('coating_id');
        foreach ($array as $key => $el) {
            if ($el == $request['product_id']) {
                unset($array[$key]);
            }
        }
        Session::put('coating_id', $array);
        return true;
    }

    /**
     * @param Request $request
     * @param $category
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function category(Request $request, $category)
    {

        $selected_tags = [];
        $selected_brands = [];
        if($request->get('tags'))
            foreach (explode(',',$request->get('tags')) as $tag){
                $selected_tags[] = $tag;
                $brand = BrandTags::where('tag_id',$tag)->get();
                if($brand)
                    foreach ($brand as $value)
                    $selected_brands[$value->brand_id] = $value->brand_id ;
            }



        $category = ProductCategory::query()
            ->whereSlug($category)
            ->firstOrFail();

        $filters = $request->except(ProductAttribute::EXCEPT_PARAMS);
        $orderBy = $request->only('orderBy');
        $isPromo = $request->only('isPromo');
        $isNovelty = $request->only('isNovelty');

        $attributesIds = [];
        $optionsIds = [];
        foreach ($filters as $key => $filter){
            if($filter == null)
                unset($filters[$key]);
        }

        foreach ($filters as $attributeCode => $optionValue) {
            $attributeItem = AttributeItem::query()->where('slug', $attributeCode)->first();
            if ($attributeItem) {
                $attributesIds[] = $attributeItem->id;
            }
            $optionItem = OptionItem::query()->where('slug', $optionValue)->first();
            if ($optionItem) {
                $optionsIds[] = $optionItem->id;
            }
        }


        $products = $category
            ->products()
            ->statusActive()
            ->when($filters, function ($q) use ($attributesIds, $optionsIds) {
                $q->whereHas('attributeItems', function ($qAttributes) use ($attributesIds, $optionsIds) {
                    $qAttributes->whereIn('attribute_item_id', $attributesIds)
                        ->whereIn('option_item_id', $optionsIds);
                });
            })
            ->when($selected_brands, function ($q) use ($selected_brands) {
              return $q->whereIn('products.brand_id',$selected_brands);
            })
            ->when($isPromo, function ($isPromoQ) use ($isPromo) {
                return $isPromoQ->where('products.is_promo', $isPromo);
            })
            ->when($isNovelty, function ($isNoveltyQ) use ($isNovelty) {
                return $isNoveltyQ->where('products.is_novelty', $isNovelty);
            })
            ->when($orderBy, function ($query) use ($orderBy) {
                 $orderBy = array_shift($orderBy);
                if ($orderBy == 'priceAsc') {
                    return $query->orderBy('products.price', 'asc');
                }
                if ($orderBy == 'priceDesc') {
                    return $query->orderBy('products.price', 'desc');
                }

                if ($orderBy == 'title') {
                    return $query->orderBy('products.title', 'asc');
                }
                return $query->orderBy($orderBy);
            })
            ->when(!$orderBy, function ($query) {
                $query->orderBy('products.sort', 'asc');
            })

//            ->orderBy('products.sort', 'asc')
            ->paginate(config('paginate.category-products'));


        if ($request->ajax()) {
            $productsView = '';
            foreach ($products as $product) {
                $productsView .= view('products._category_item', [
                    'product' => $product,
                    'category' => $category
                ])->render();
            }
            return [
                'items' => $productsView,
                'hasMore' => $products->hasMorePages()
            ];
        }

        $attributes = ProductAttribute::query()
            ->select([
                '*',
                'attribute_items.title as attribute_title',
                'product_attributes.id as attribute_id',
                'attribute_items.slug as attribute_code',
                'option_items.title as option_title',
                'option_items.slug as option_code',
            ])
            ->leftJoin('option_items', 'option_item_id', '=', 'option_items.id')
            ->leftJoin('attribute_items', 'attribute_item_id', '=', 'attribute_items.id')

            ->whereHas('product', function ($q) use ($category) {
                return $q
                    ->whereHas('categories', function ($categoriesQ) use ($category) {
                        return $categoriesQ->where('product_categories.id', $category->id);
                    })->statusActive();
            })
            ->get();

        $brands = [];
       foreach ($category->products as $product){
           if($product->brand)
                $brands[$product->brand->id] = $product->brand;
       }
       $tags = [];
        foreach ($brands as $brand){
            if($brand->tags)
            foreach ($brand->tags as $tag) {
                $tags[$tag->id] = $tag;
            }
        }




        $attributesArray = [];
        foreach ($attributes as $item) {
            $attributesArray[$item->attribute_code]['attribute'] = [
                'attribute_title' => $item->attribute_title,
                'attribute_code' => $item->attribute_code
            ];
            $attributesArray[$item->attribute_code]['options'][$item->option_code] = [
                'option_title' => $item->option_title,
                'option_code' => $item->option_code,
            ];
        }

        return view('products.category')->with(compact('category', 'products', 'attributesArray','tags','selected_tags'));
    }

    /**
     * @param Request $request
     * @param $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function categoryList(Request $request, $category)
    {
        $category = ProductCategory::query()
            ->whereSlug($category)
            ->orderBy('sort', 'desc')
            ->firstOrFail();


        $category->load(['subcategories', 'subcategories.subcategories']);

        $sliderProducts = Product::query()
            ->statusActive()
            ->limit(5)
            ->with(['categories'])
            ->orderBy('sort', 'desc')
            ->get();

        return view('products.categoryList')->with(compact('category', 'sliderProducts'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function search(Request $request)
    {
        $query = $request->get('query');
//        if ($request->file_filter) {
//            dd($request->file_filter);
//        }
        $products = Product::query()
            ->statusActive()
            ->orderBy('sort', 'desc')
            ->where('title', 'LIKE', '%' . $query . '%')
            ->get();

        return view('products.search')->with(compact('products', 'query'));
    }

    /**
     * @param Request $request
     * @param ProductService $productService
     * @return array
     */
    public function addToFavorites(Request $request, ProductService $productService)
    {
        $productId = $request->get('product_id');

        $alreadyAdded = $productService->addToSession($productId, 'favorites')['alreadyAdded'];
        $countInSession = $productService->getSession('favorites');
        if ($alreadyAdded) {
            return ['message'=>'Товар успешно удален из избранного!', 'count' => count($countInSession)];
        } else {
            return ['message'=>'Товар успешно добавлен в избранное!', 'count' => count($countInSession)];
        }
    }

    /**
     * @param Request $request
     * @param ProductService $productService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function favorites(Request $request, ProductService $productService)
    {
        $favoritesIds = $productService->getSession('favorites');

        // Добавляем кавычки вокруг значений
        $favoritesIdsList = implode(',', $favoritesIds);
        $favoritesIdsList = "'" . str_replace(",", "','", $favoritesIdsList) . "'";

        $products = Product::query()
            ->statusActive()
            ->whereIn('id', $favoritesIds)
            ->when(!empty($favoritesIds), function ($q) use ($favoritesIdsList) {
                return $q->orderByRaw('FIELD(id, ' . $favoritesIdsList . ')');
            })
            ->get();

        $title = 'Избранные товары';
        return view('products.grid')->with(compact('products', 'title'));
    }

    /**
     * @param Request $request
     * @param ProductService $productService
     * @return array
     */
    public function addToCompare(Request $request, ProductService $productService)
    {
        if ($request->coatings !== null) {
            $coating_id = $request->get('product_id');
            if ($request->active === null) {
                if (Session::get('coating_id') != null) {
                    $array = Session::get('coating_id');
                    $sessionStr = implode(",", $array);
                    $sessionStr = $sessionStr . ',' . $coating_id;
                } else {
                    $sessionStr = $coating_id;
                }
                $sessionStr = explode(',', $sessionStr);
                Session::put('coating_id', $sessionStr);
                $countInSession = $productService->getSession('compare');
                return ['message' => 'Товар успешно добавлен в сравнения!', 'count' => count($countInSession)];
            } else {
                $array = Session::get('coating_id');
                foreach ($array as $key => $el) {
                    if ($el == $coating_id) {
                        unset($array[$key]);
                    }
                }
                Session::put('coating_id', $array);
                $countInSession = $productService->getSession('compare');
                return ['message' => 'Товар успешно удален из сравнения!', 'count' => count($countInSession)];
            }
        } else {
            $productId = $request->get('product_id');
            $alreadyAdded = $productService->addToSession($productId, 'compare')['alreadyAdded'];
            $countInSession = $productService->getSession('compare');
            if ($alreadyAdded) {
                return ['message' => 'Товар успешно удален из сравнения!', 'count' => count($countInSession)];
            } else {
                return ['message' => 'Товар успешно добавлен в сравнения!', 'count' => count($countInSession)];
            }
        }
    }

    /**
     * @param ProductService $productService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function compareFlush(ProductService $productService)
    {
        $productService->flushSessionPart('compare');

        return redirect()->route('index.products.compare');
    }

    private function same($arr)
    {
        return $arr === array_filter($arr, function ($element) use ($arr) {
                return ($element === $arr[0]);
            });
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function compare(Request $request, ProductService $productService)
    {
        $compareCoatings = [];
        $compareIds = $productService->getSession('compare');
        $categories = ProductCategory::query()
            ->whereHas('products', function ($q) use ($compareIds) {
                return $q
                    ->statusActive()
                    ->whereIn('id', $compareIds);
            })->withCount(['products' => function ($productsQ) use ($compareIds) {
                return $productsQ
                    ->statusActive()
                    ->whereIn('id', $compareIds);
            }])
            ->with(['products' => function ($productsQ) use ($compareIds) {
                return $productsQ
                    ->statusActive()
                    ->whereIn('id', $compareIds)
                    ->orderByDesc('sort');
            }])
            ->get();

        foreach ($categories as $category) {
            $attributes_ = [];
            $is_list = false;
            $products_compare = [];
            foreach ($category->products as &$product) {

                if ($product['list_width_full'] || $product['list_width_useful'] || $product['custom_length_to'])
                    $is_list = true;
                foreach ($product->attributesArray() as $attribute)
                    if (count($attribute['options']) == 1) {
                        $attributes_[$attribute['model']->id] = $attribute['model']->title;
                    }


            }

            $category->is_list = $is_list;
            $category->hideCategory = false;
            $category->hidePrice = false;
            $category->hideList1 = false;
            $category->hideList2 = false;
            $category->hideList3 = false;
            foreach ($category->products as &$product) {

                $product_attibutes = [];
                foreach ($attributes_ as $key => $attribute_) {
                    $is_attribute = false;
                    foreach ($product->attributesArray() as $attribute)
                        if ($attribute['model']->id == $key)
                            $is_attribute = $attribute;
                    $product_attibutes[$key] = $is_attribute ? $is_attribute : null;
                    $products_compare['attributes'][$key][$product->id] = null;
                    if ($is_attribute) {
                        foreach ($is_attribute['options'] as $option)
                            $products_compare['attributes'][$key][$product->id] .= $option['title'];
                    }


                }

                $product->attributes = $product_attibutes;

                $products_compare['price'][$product->price] = $product->price;
                $products_compare['width1'][$product->list_width_full] = $product->list_width_full;
                $products_compare['width2'][$product->list_width_useful] = $product->list_width_useful;
                $products_compare['width3'][$product->custom_length_to] = $product->custom_length_to;

            }

            if ($request->get('difference') == 'true') {
                if (isset($products_compare['attributes']))
                    foreach ($products_compare['attributes'] as $attribute_id => $products) {

                        $pass = false;

                        $last = array_shift($products);
                        foreach ($products as $item) {
                            if ($item != $last) $pass = true;
                            $last = $item;
                        }

                        if (!$pass)
                            unset($attributes_[$attribute_id]);


                    }

                if (count($products_compare['price']) < 2) {
                    $category->hidePrice = true;
                };
                if (count($products_compare['width1']) < 2) {
                    $category->hideList1 = true;
                }
                if (count($products_compare['width2']) < 2) {
                    $category->hideList2 = true;
                }
                if (count($products_compare['width3']) < 2) {
                    $category->hideList3 = true;
                }

                $category->hideCategory = true;

            }
            $category->attributes = $attributes_;
        }


        if (Session::get('coating_id') == null) {
            $compareCoatings = 0;
        } else {
            $compareCoatings = Session::get('coating_id');
        }

        $tab = isset($request['tab']) ? $request['tab'] : 0;

        return view('products.compare')->with(compact('categories', 'compareCoatings', 'tab'));
    }

    /**
     * @param Request $request
     * @param ProductService $productService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function viewed(Request $request, ProductService $productService)
    {
        $viewedIds = $productService->getSession('viewed');
        $viewedIdsList = implode(',', $viewedIds);
        $products = Product::query()
            ->statusActive()
            ->whereIn('id', $viewedIds)
            ->when(!empty($viewedIds), function ($q) use ($viewedIdsList) {
                return $q->orderByRaw('FIELD(id,' . $viewedIdsList . ')');
            })
            ->get();
        $title = 'Просмотренные товары';
        return view('products.grid')->with(compact('products', 'title'));
    }
}
