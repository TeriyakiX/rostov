<?php


use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

if (!function_exists('option_key')) {
    /**
     * Translate option key to human lang
     * @param string $key
     * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed|string|null
     */
    function option_key(string $key)
    {

        if($key == 'totalPrice') {
            return 'Сумма';
        }

        if($key == 'quantity') {
            return 'Количество';
        }

        if($key == 'price') {
            return 'Цена';
        }

        if($key == 'width') {
            return 'Ширина';
        }

        if($key == 'length') {
            return 'Длинна';
        }
        if($key == 'startprice') {
            return 'Цена';
        }
        if($key == 'startpricepromo') {
            return 'Акционная цена';
        }
        if($key == 'square') {
            return 'Квадрат';
        }
        if($key == 'color') {
            return 'Цвет';
        }
        if($key == 'attribute_prices') {
            return 'Цена атрибутов';
        }
        if($key == 'attribute') {
            return 'Атрибуты';
        }
        $attributeItem = \App\Models\AttributeItem::query()->where('slug', $key)->first();
        if($attributeItem) {
            return $attributeItem->title;
        }

        return $key;
    }
}

if (!function_exists('readmore_text')) {
    /**
     * Readmore text
     * @param $text
     * @return string
     */
    function readmore_text($string)
    {
        $string = strip_tags($string);
        if (strlen($string) > 500) {

            // truncate string
            $stringCut = substr($string, 0, 500);
            $endPoint = strrpos($stringCut, ' ');

            //if the string doesn't contain any space then it will cut without word basis.
            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
        }
        return $string;
    }
}


if (!function_exists('options_to_string')) {
    /**
     * Transform options array to string
     * @param string $options
     * @return string
     */
    function options_to_string($options)
    {
        $optionsArray = json_decode($options);

        $return = '';

        foreach ($optionsArray as $optionCode => $optionValue) {
            $return .= option_key($optionCode) . ': ' . $optionValue . ', ';
        }

        $return = trim($return, ', ');

        return $return;
    }
}

if (!function_exists('show_categories_count_rus')) {
    /**
     * Transform count to string of categories
     * @param integer $count
     * @return string
     */
    function show_categories_count_rus(int $count)
    {
        // Показать $count категорий/категорию/категории
        $rus = 'категорий';
        if($count == 1) {
            $rus = 'категорию';
        }
        if($count == 2 || $count == 3 || $count == 4) {
            $rus = 'категории';
        }
        if($count >= 5) {
            $rus = 'категорий';
        }

        return $rus;
    }
}

if (!function_exists('product_id_in_list')) {
    /**
     * Find product id in session list
     * @param $productId
     * @param $listName
     * @return string
     */
    function product_id_in_list($productId, $listName)
    {
        $sessionName = \App\Services\ProductService::SESSION_PRODUCTS . '.' . $listName;
        $list = session()->get($sessionName, []);
        return in_array($productId, $list);
    }
}

if (!function_exists('phone_format')) {
	function phone_format($phone)
	{
		$phone = trim($phone);

		$res = preg_replace(
			array(
				'/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{3})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
				'/[\+]?([7|8])[-|\s]?(\d{3})[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
				'/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
				'/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
				'/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{3})/',
				'/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{3})[-|\s]?(\d{3})/',
			),
			array(
				'7$2$3$4$5',
				'7$2$3$4$5',
				'7$2$3$4$5',
				'7$2$3$4$5',
				'7$2$3$4',
				'7$2$3$4',
			),
			$phone
		);

		return $res;
	}
}

