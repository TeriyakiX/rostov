<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return Product[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function collection()
    {
        return Product::all();
    }

    /**
     * @param mixed $row
     * @return array
     */
    public function map($row): array{
        return [
            $row->id,
            $row->title,
            $row->slug,
            $row->vendor_code,
            $row->is_novelty ? "1" : "0",
            $row->is_promo ? "1" : "0",
            $row->description,
            $row->list_width_full,
            $row->list_width_useful,
            $row->min_square_meters,
            $row->custom_length_from,
            $row->custom_length_to,
            $row->length_list,
            $row->colors_list,
            $row->thickness,
            $row->show_calculator ? "1" : "0",
            $row->price,
            $row->promo_price,
            $row->sort,
        ];
    }

    /**
     * @return string[]
     */
    public function headings(): array
    {
        return [
            '#',
            'Название',
            'Код для ссылки',
            'Артикул',
            'Новинка?',
            'Промо?',
            'Описание',
            'Ширина листа полная',
            'Ширина листа полезная',
            'Минимальное количество м2',
            'Длина на заказ от',
            'Длина на заказ до',
            'Список длин',
            'Список цветов',
            'Толщина',
            'Показать калькулятор м3',
            'Цена',
            'Акционная цена',
            '№ для сортировки'
        ];
    }
}
