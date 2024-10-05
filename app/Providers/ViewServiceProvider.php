<?php

namespace App\Providers;

use App\Models\PostCategory;
use App\Models\ProductCategory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        // cart
        view()->share('cart', app()->make('cart'));

        // auth user
        View::composer('admin.dashboard.index', function ($view) {
            $view->with(['user' => auth()->user()]);
        });

        // sidebar links
        View::composer('admin.layouts._sidebar', function ($view) {
            $config=[];
            if(\Auth::user()->hasRole('admin')){
                $config=config('admin.entities');
            }elseif (\Auth::user()->hasRole('manager')){
                $config=config('manager.entities');
            }
            $view->with(['entities' => $config]);
        });

        // header
        View::composer('layouts._header', function ($view) {
            $headerCategories = ProductCategory::whereNull('parent_id')->orderBy('sort', 'asc')->get();
            $headerSubCategories = ProductCategory::whereNotNull('parent_id')->orderBy('sort', 'asc')->get();

            $headerPostCategories = PostCategory::query()
                ->active()
                ->showInHeader()
                ->with(['posts' => function ($q) {
                    $q->active()->showInHeader()->orderByDesc('sort');
                }])->get();
            $parentCategories = $headerSubCategories;
            $view->with([
                'headerCategories' => $headerCategories,
                'parentCategories' => $parentCategories,
                'headerPostCategories' => $headerPostCategories
            ]);
        });

        // footer
        View::composer('layouts._footer', function ($view) {
            $footerPostCategories = PostCategory::query()
                ->active()
                ->showInFooter()
                ->with(['posts' => function ($q) {
                    $q->active()->showInFooter();
                }])->get();
            $view->with([
                'footerPostCategories' => $footerPostCategories
            ]);
        });
    }
}
