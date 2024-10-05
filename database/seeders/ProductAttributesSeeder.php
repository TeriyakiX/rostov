<?php

namespace Database\Seeders;

use App\Models\AttributeItem;
use App\Models\OptionItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductAttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // COLOR LIBRARY

        /** @var AttributeItem $productAttribute */
        $attributeItemColor = AttributeItem::query()
            ->create([
                'slug' => 'color',
                'title' => 'Цвет'
            ]);

        /** @var OptionItem $optionItemColorWhite */
        $optionItemColorWhite = OptionItem::query()
            ->create([
                'slug' => 'white',
                'title' => 'Белый'
            ]);

        /** @var OptionItem $optionItemColorBlack */
        $optionItemColorBlack = OptionItem::query()
            ->create([
                'slug' => 'black',
                'title' => 'Черный'
            ]);

        $attributeItemColor->optionItems()
            ->sync([
                $optionItemColorWhite->id,
                $optionItemColorBlack->id
            ]);

        // GET PRODUCT
        $product = Product::query()->first();

        // ASSIGN COLOR TO PRODUCT

//        $product->attributeItems()
//            ->create([
//                'for_cart' => true,
//                'price' => 0,
//                'attribute_item_id' => $attributeItemColor->id,
//                'option_item_id' => $optionItemColorWhite->id
//            ]);
//
//        $product->attributeItems()
//            ->create([
//                'for_cart' => true,
//                'price' => 0,
//                'attribute_item_id' => $attributeItemColor->id,
//                'option_item_id' => $optionItemColorBlack->id
//            ]);
    }
}
