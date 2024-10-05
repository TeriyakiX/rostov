<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Services\Shop\Contracts\Order as OrderContract;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property string|null $phone_number
 * @property string|null $address
 * @property string|null $delivery_type_id
 * @property string|null $payment_type_id
 * @property string|null $customer_comment
 * @property string|null $manager_comment
 * @property int|null $status
 * @property string|null $total_price
 * @property int|null $is_fiz
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order sort(array $sortArray)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDeliveryTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereIsFiz($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereManagerComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUserId($value)
 * @mixin \Eloquent
 */
class Order extends Model implements OrderContract
{
    use HasFactory, CanSort;

    public const STATUS_AWAITING_PAYMENT = 1;

    public const STATUS_AWAITING_DELIVERED = 2;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'address',
        'total_price',
        'delivery_type_id',
        'payment_type_id',
        'customer_comment',
        'is_fiz',
        'user_id',
        'manager_comment',
		'status'
    ];

    /**
     * @var string[]
     */
    public const ADMIN_VIEW = [
        'id' => [
            'type' => 'plain',
            'title' => 'ID'
        ],
        'name' => [
            'type' => 'plain',
            'title' => 'ФИО'
        ],
        'phone_number' => [
            'type' => 'plain',
            'title' => 'Телефон'
        ],
		/* 'status' => [
            'type' => 'plain',
            'title' => 'Статус'
        ], */
        'total_price' => [
            'type' => 'plain',
            'title' => 'Сумма'
        ]
    ];

    /**
     * @var string[]
     */
    public const ADMIN_EDIT = [
		'status' => [
            'type' => 'belongsTo',
            'title' => 'Статус',
			'model' => OrderStatus::class
        ],
        'send_sms' => [
            'type' => 'checkbox',
            'title' => 'Отправить СМС о статусе заказа'
        ],
		'send_wa' => [
            'type' => 'checkbox',
            'title' => 'Отправить WA о статусе заказа'
        ],
		'send_invoice' => [
            'type' => 'checkbox',
            'title' => 'Отправить счет на почту'
        ],
		'send_order' => [
            'type' => 'checkbox',
            'title' => 'Отправить заказ с изменённым статусом'
        ],
        'is_fiz' => [
            'type' => 'text',
            'title' => 'Физ лицо?'
        ],
        'name' => [
            'type' => 'text',
            'title' => 'ФИО',
            'validation' => 'required'
        ],
        'email' => [
            'type' => 'text',
            'title' => 'Email'
        ],
        'phone_number' => [
            'type' => 'text',
            'title' => 'Телефон'
        ],
        'address' => [
            'type' => 'text',
            'title' => 'Адрес'
        ],
        'customer_comment' => [
            'type' => 'text',
            'title' => 'Комментарий клиента'
        ],
        'manager_comment' => [
            'type' => 'text',
            'title' => 'Комментарий менеджера'
        ],
        'total_price' => [
            'type' => 'text',
            'title' => 'Сумма, руб'
        ],
        'files' => [
            'type' => 'files',
            'title' => 'Файлы'
        ],
		
        'positions' => [
            'type' => 'positions',
            'title' => 'Купленные позиции'
        ],
		
    ];

    /**
     * {@inheritdoc}
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this
            ->belongsToMany('App\Models\Product', 'product_order', 'order_id', 'product_id')
            ->withPivot(['quantity', 'options']);
    }

    /**
     * {@inheritdoc}
     *
     * @param $productId
     * @param $options
     */
    public function addPosition($productId, $options)
    {
        $product = $this->products()
            ->where('product_id', '=', $productId)
            ->first();
        $optionsJson = json_encode($options);
        $quantity = $options['quantity'] ?? null;

            $this->products()->attach($productId, [
                'options' => $optionsJson,
                'quantity' => $quantity
            ]);
        
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files()
    {
        return $this->morphMany(File::class,'fileable');
    }

    /**
     * {@inheritdoc}
     *
     * @param $productId
     */
    public function removePosition($productId)
    {
        $this->products()->detach($productId);
    }
	
	public function typeStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'status');
    }
}
