<?php

namespace App\Actions;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Index\PostController;
use App\Models\AkciiSlider;
use App\Models\Brand;
use App\Models\BuilderGuide;
use App\Models\Calculator;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\ProductionCategories;
use App\Models\TagsCategories;
use App\Models\TurnkeySolutions;
use App\Models\VideoYoutube;
use App\Models\UsefulChapter;
use Illuminate\Http\Request;

class PostAction extends Controller
{

    public function handle(string $slug, Request $request)
    {
		//print_r($slug);
        $post = Post::query()
            ->whereSlug($slug)
            ->firstOrFail();


        switch ($post['id']) {
            case (36)://Акции
            {
                $slider = AkciiSlider::select('photo_desktop', 'url')->orderBy('sort', 'ASC')->get();
                return view('posts.show')->with(compact('post', 'slider'));

            }
            case (37)://статьи
            {
                $postCategory = PostCategory::query()->where('slug', $slug)->first();
                $tagsModel = TagsCategories::query()
                    ->where('entity', $slug)
                    ->with('statiTags')
                    ->orderBy('title', 'asc')
                    ->first();
                $tags = $tagsModel->statiTags;

                if (isset($request->tagId)) {
                    $currentTagId = $request->tagId;
                    $postsCount = $postCategory
                        ->posts()
                        ->active()
                        ->where('stati_tags.tag_id', $currentTagId)
                        ->join('stati_tags', 'stati_tags.post_id', 'posts.id')
                        ->count();

                    if ($postsCount > 0) {
                        $posts = $postCategory
                            ->posts()
                            ->active()
                            ->where('stati_tags.tag_id', $currentTagId)
                            ->join('stati_tags', 'stati_tags.post_id', 'posts.id')
                            ->paginate(12)->withQueryString();

                        return view('posts.show')->with(compact('post', 'posts', 'tags', 'currentTagId'));
                    } else {
                        $posts = $postCategory
                            ->posts()
                            ->active()
                            ->where('stati_tags.tag_id', -1)
                            ->join('stati_tags', 'stati_tags.post_id', 'posts.id')
                            ->paginate(1)->withQueryString();
                        return view('posts.show')->with(compact('post', 'posts', 'tags', 'currentTagId'));
                    }
                }
                $posts = $postCategory
                    ->posts()
                    ->active()
                    ->paginate(12);
                return view('posts.custom._stati')->with(compact('posts', 'tags'));
            }
            case (49):
            {//Калькуляторы
                $calculators = Calculator::active()->orderBy('sort', 'Desc')->get();
                return view('posts.custom._kalkulyatory')->with(compact('post', 'calculators'));
            }
            case (56):
            {//Производтсво
                $productions = ProductionCategories::query()->active()->get();
                return view('posts.show')->with(compact('post', 'productions'));
            }
            case (55):
            {
                return (new \App\Http\Controllers\Index\PostController)->filter($slug, $request);
            }
            case (39)://бренды
            {
                $tagsModel = TagsCategories::query()
                    ->where('entity', $slug)
                    ->with('brandTags')
                    ->orderBy('title', 'asc')
                    ->first();
                $tags = $tagsModel->brandTags;

                if (isset($request->tagId)) {
                    $currentTagId = $request->tagId;
                    $brands = Brand::where('brand_tags.tag_id', $currentTagId)
                        ->join('brand_tags', 'brand_id', 'brands.id')->paginate(12)->withQueryString();
                    return view('posts.show')->with(compact('post', 'brands', 'tags', 'currentTagId'));
                }
                $brands = Brand::paginate(12);
                return view('posts.show')->with(compact('post', 'brands', 'tags'));
            }
            case (46):
            {

                $tagsModel = TagsCategories::query()
                    ->where('entity', $slug)
                    ->with('solutionTags')
                    ->orderBy('title', 'asc')
                    ->first();

                $tags = $tagsModel->solutionTags;

                if (isset($request->tagId)) {
                    $currentTagId = $request->tagId;
                    $solutions = TurnkeySolutions::where('solution_tags.tag_id', $currentTagId)
                        ->join('solution_tags', 'solution_id', 'turnkey_solutions.id')->paginate(12)->withQueryString();
                    return view('posts.show')->with(compact('post', 'currentTagId', 'solutions', 'tags'));
                }
                $solutions = TurnkeySolutions::paginate(12);
                return view('posts.show')->with(compact('post', 'solutions', 'tags'));

            }
			case(35):
            {
                $VideoYoutube = VideoYoutube::paginate(8);
				//print_r($VideoYoutube);die();
                return view('posts.show')->with(compact('post', 'VideoYoutube'));
            }
            //poleznoe
            case(92):
            {
                $usefulChapters = UsefulChapter::select('id', 'slug', 'title',)->active()->orderBy('sort', 'desc')->get()->toArray();
                return view('posts.show')->with(compact('post', 'usefulChapters'));
            }

            case(48):
                return view('posts.contacts')->with(compact('post'));
                break;
            case (96):
            {//cправочник строителя
               if (!isset($request->search)){
                   $words = BuilderGuide::query()->active()
                       ->orderByRaw('lower(title) ASC')->get()
                       ->groupBy(function ($item) {
                           return mb_substr(mb_strtolower($item->title), 0, 1);
                       });
               }else{
                   $words = BuilderGuide::query()->active()->where('title','like',"%{$request->search}%")
                       ->orderByRaw('lower(title) ASC')->get()
                       ->groupBy(function ($item) {
                           return mb_substr(mb_strtolower($item->title), 0, 1);
                       });

               }


                return view('posts.show')->with(compact('post', 'words'));
            }
            default://остальные
            {
                return view('posts.show')->with(compact('post'));
            }

        }
    }
}
