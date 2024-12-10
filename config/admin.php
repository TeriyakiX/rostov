<?php

return [
    'entities' => [

        'orders' => [
            'title' => 'Заказы',
            'model' => \App\Models\Order::class
        ],

		'statuses' => [
            'title' => 'Статусы заказов',
            'model' => \App\Models\OrderStatus::class
        ],

        // Product items
        'attributes' => [
            'title' => 'Атрибуты',
            'model' => \App\Models\AttributeItem::class
        ],
        'types of attributes' => [
            'title' => 'Типы атрибутов',
            'model' => \App\Models\TypesAttribute::class
        ],
        'options' => [
            'title' => 'Опции атрибутов',
            'model' => \App\Models\OptionItem::class
        ],
        'brands' => [
            'title' => 'Бренды',
            'model' => \App\Models\Brand::class
        ],
        'product_categories' => [
            'title' => 'Категории продуктов',
            'model' => \App\Models\ProductCategory::class
        ],
        'products' => [
            'title' => 'Продукты',
            'model' => \App\Models\Product::class
        ],
        'coatings' => [
            'title' => 'Покрытия',
            'model' => \App\Models\Coatings::class
        ],

        // Main page items
        'index_sliders' => [
            'title' => 'Слайдер главной страницы',
            'model' => \App\Models\IndexSlider::class
        ],

        // Blog
        'posts' => [
            'title' => 'Статьи',
            'model' => \App\Models\Post::class
        ],
        'post_categories' => [
            'title' => 'Категории статей',
            'model' => \App\Models\PostCategory::class
        ],
        //Calculators
        'calculators'=>[
            'title'=>'Калькуляторы',
            'model'=>\App\Models\Calculator::class
        ],
        // Projects
       'projects' => [
            'title' => 'Фотогалерея',
            'model' => \App\Models\Project::class
        ],
        //
        'tags'=>[
            'title'=>'Теги',
            'model'=> \App\Models\Tags::class
        ],
        'production' => [
            'title' => 'Производство',
            'model' => \App\Models\ProductionCategories::class
        ],
        // manager contacts
        'managers'=>[
            'title'=>'Контакты менеджера',
            'model'=>\App\Models\ManagerContacts::class],

        'feedbacks' => [
            'title' => 'Обратная связь',
            'model' => \App\Models\Feedback::class
        ],

        'our_services' => [
            'title' => 'Наши сервисы',
            'model' => \App\Models\OurService::class
        ],
        'turnkey_solutions' => [
            'title' => 'Готовые решения',
            'model' => \App\Models\TurnkeySolutions::class
        ],
		'video' => [
            'title' => 'Видео',
            'model' => \App\Models\VideoYoutube::class
        ],
        'download_files_type' => [
            'title' => 'Типы документов',
            'model' => \App\Models\DocumentType::class
        ],
        'download_files' => [
            'title' => 'Документы',
            'model' => \App\Models\File::class
        ],
        'useful_chapter'=>[
            'title'=>'Разделы полезное',
            'model'=>\App\Models\UsefulChapter::class
        ],
        'units_of_products'=>[
            'title'=>'Справочник единиц измерения для товаров',
            'model'=>\App\Models\UnitsOfProducts::class
        ],
        'builder_guide'=>[
            'title'=>'Справочник строителя',
            'model'=>\App\Models\BuilderGuide::class
        ],
        'akcii_slider'=>[
            'title'=>'Слайдер страницы акции',
            'model'=>\App\Models\AkciiSlider::class
        ],
        'office_hours'=>[
            'title'=>'Режим работы офиса',
            'model'=>\App\Models\OfficeHour::class
        ]

    ]
];
