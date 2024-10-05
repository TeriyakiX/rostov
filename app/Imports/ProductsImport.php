<?php

namespace App\Imports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductsImport implements ToCollection
{
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $id = $row[0];

            if($id == '#') { // row is heading - pass it
                continue;
            }

            $toSave = [
                'title' => $row[1],
                'slug' => $row[2],
                'vendor_code' => $row[3],
                'is_novelty' => $row[4],
                'is_promo' => $row[5],
                'description' => $row[6],
                'list_width_full' => $row[7],
                'list_width_useful' => $row[8],
                'min_square_meters' => $row[9],
                'custom_length_from' => $row[10],
                'custom_length_to' => $row[11],
                'length_list' => $row[12],
                'colors_list' => $row[13],
                'thickness' => $row[14],
                'show_calculator' => $row[15],
                'price' => $row[16],
                'promo_price' => $row[17],
                'sort' => $row[18],
            ];

            $product = Product::find($id);

            if($product) {
                $product->update($toSave);
            } else {
                Product::query()->create($toSave);
            }
        }
    }
}
