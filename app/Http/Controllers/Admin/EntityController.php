<?php

namespace App\Http\Controllers\Admin;

use App\Http\Resources\EntityCollection;
use App\Mail\SendMail;
use App\Mail\SendInvoiceMail;
use App\Models\AttributeItem;
use App\Models\Order;
use App\Mail\OrdersMail;
use App\Models\Post;
use App\Models\ProductCategory;
use App\Models\UsefulChapter;
use App\Models\User;
use App\Services\EntityService;
use App\Services\FieldService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Mail;
use PDF;
use App\Sms\SmsHelper;
use App\Models\OrderStatus;

class EntityController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param \Illuminate\Http\Request $request
     * @param $entity
     * @param EntityService $entityService
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request, $entity, EntityService $entityService)
    {
        $user = $request->user();
        $config = self::getConfigByRole($user, $entity);
        if ($request->ajax()) {

            // get table data
            $model = $config['model'];
            $items = $entityService->getItems($model, $request);
            $columns = $entityService->getViewColumns($model);

            return [
                'items' => EntityCollection::make($items)->setEntity($entity),
                'columns' => $columns,
                'meta' => ['total' => $items->total()]
            ];
        }

        return view('admin.entity.index')->with(compact('entity', 'config'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $entity
     * @param $id
     * @param FieldService $fieldService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, $entity, $id, FieldService $fieldService)
    {
        $user = $request->user();
        $config = self::getConfigByRole($user, $entity);
        $model = $config['model'];
        $item = $model::findOrFail($id);
        $fieldsHtml = $fieldService->index($config, $model::ADMIN_EDIT, $item, $entity);

        return view('admin.entity.update')->with(compact('entity', 'id', 'item', 'config', 'fieldsHtml'));
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @param $entity
     * @param $id
     * @param EntityService $entityService
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $entity, $id, EntityService $entityService, FieldService $fieldService)
    {
        if ($request->is_delete && $request->is_delete == 1) {
            $request->request->add(['image' => '']);
        }

        $user = $request->user();
        $config = self::getConfigByRole($user, $entity);
        $model = $config['model'];

        $editFields = $model::ADMIN_EDIT;
        $validationRules = $entityService->getValidationRules($editFields);
        $this->validate($request, $validationRules);

        $item = $model::findOrFail($id);

        // Обработка даты окончания акции
        if ($request->has('end_promo_date')) {
            $endPromoDate = $request->end_promo_date ? \Carbon\Carbon::parse($request->end_promo_date) : null;

            // Устанавливаем флаг is_promo на основе даты
            $item->is_promo = $endPromoDate && !$endPromoDate->isPast();
            $item->end_promo_date = $endPromoDate;
        }

        // Обработка даты окончания новинки
        if ($request->has('end_novelty_date')) {
            $endNoveltyDate = $request->end_novelty_date ? \Carbon\Carbon::parse($request->end_novelty_date) : null;

            // Устанавливаем флаг is_novelty на основе даты
            $item->is_novelty = $endNoveltyDate && !$endNoveltyDate->isPast();
            $item->end_novelty_date = $endNoveltyDate;
        }

        if ($model === 'App\Models\Order') {
            $order = Order::query()->find($id);
            if ($order && $order->status != $request->status) {
                $status = OrderStatus::query()->findOrFail($request->status);
                $formattedPhone = phone_format($request->phone_number);

                if (strlen($formattedPhone) === 10 && $status->title) {
                    $message = 'Ваш заказ № (' . $id . ') "' . $status->title . '"';
                    $api = new SmsHelper(config('constants.apiname_SmsHelper'), config('constants.apikey_SmsHelper'), true, false);
                    $api->sendSMS(preg_replace('/[^0-9]/', '', $formattedPhone), $message, 'mkrostov');

                    $order->status = $status->title;
                    Mail::to($request->email)->send(new OrdersMail($order));
                }
            }
        }

        if ($model === 'App\Models\Post') {
            $usefulChapter = UsefulChapter::where('slug', $item->slug)->first();
            if ($usefulChapter) {
                $entityService->update($usefulChapter, $request);
            } elseif ($request->show_in_header == 1 && isset($request->categories) && in_array(2, $request->categories)) {
                $entityService->create('App\Models\UsefulChapter', $request);
            }
        }

        $entityService->update($item, $request);

        if ($model === 'App\Models\Order' && isset($order->files[0]->filepath) && $request->send_invoice) {
            $file_name = $order->files[0]->filepath;
            Mail::send('posts.invoice', ['order_id' => $id], function ($message) use ($order, $file_name) {
                $message->to($order->email)->subject('Счет оплаты по заказу №' . $order->id)
                    ->attach(public_path('upload_files/' . $file_name));
            });
        }

        return back();
    }

    /**
     * @param $entity
     * @param FieldService $fieldService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function create(Request $request, $entity, FieldService $fieldService)
    {
        $user = $request->user();
        $config = self::getConfigByRole($user, $entity);


        $model = $config['model'];
		//print_r($config);

        $fieldsHtml = $fieldService->index($config, $model::ADMIN_EDIT, null, $entity);



        return view('admin.entity.create')->with(compact('entity', 'config', 'fieldsHtml'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param $entity
     * @param EntityService $entityService
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, $entity, EntityService $entityService)
    {
        $user = $request->user();
        $config = self::getConfigByRole($user, $entity);

        $model = $config['model'];

        if ($model === 'App\Models\Post' && $request->show_in_header == 1 && isset($request->categories) && in_array(2, $request->categories)) {
            $chapterRequest = $request;
            $editFieldsPosts = \App\Models\Post::ADMIN_EDIT;
            $validationRulesPosts = $entityService->getValidationRules($editFieldsPosts);
            $this->validate($chapterRequest, $validationRulesPosts);

            $entityService->create('App\Models\UsefulChapter', $chapterRequest);

        }

        $editFields = $model::ADMIN_EDIT;
        $validationRules = $entityService->getValidationRules($editFields);

        $entityService->create($model, $request);


        return redirect()->route('admin.entity.index', ['entity' => $entity]);
    }

    /**
     * @param Request $request
     * @param $entity
     * @param $id
     * @param EntityService $entityService
     * @return \Illuminate\Http\RedirectResponse
     */
    public
    function delete(Request $request, $entity, $id, EntityService $entityService)
    {

        $user = $request->user();
        $config = self::getConfigByRole($user, $entity);

        $model = $config['model'];
        $item = $model::find($id);
        if ($model === 'App\Models\Post') {

            $itemPostCount = \App\Models\UsefulChapter::where('slug', $item->slug)->count();
            if ($itemPostCount > 0) {
                $itemPost = \App\Models\UsefulChapter::where('slug', $item->slug)->first();
                $itemPost->delete();
            }

        }
        $item->delete();
        return back();
    }

    /**
     * @param Request $request
     * @param $id
     * @param EntityService $entityService
     * @return bool
     */
    public
    function photoDelete(Request $request, $id, EntityService $entityService)
    {
        return $entityService->deletePhoto($id);
    }

    /**
     * @param Request $request
     * @param $id
     * @param EntityService $entityService
     * @return bool
     */
    public
    function fileDelete(Request $request, $id, EntityService $entityService)
    {
        return $entityService->deleteFile($id);
    }

    /**
     * @param Request $request
     * @return
     */
    public
    function photoUpload(Request $request)
    {
        // delete old photo
        if (file_exists(public_path('upload_images/' . $request->file('file')))) {
            unlink(public_path('upload_images/' . $request->file('file')));
        }

        $photo = $request->file('file');
        $path = '/';
        $name = date('mdYHis') . uniqid();
        $extension = $photo->extension();

        return '/upload_images/' . Storage::disk('images')
                ->putFileAs($path, $photo, $name . '.' . $extension);
    }

    /**
     * @param Request $request
     */
    public
    function deleteSummernotePhoto(Request $request)
    {
        $fullPath = $request->get('filename');
        $fullPathArray = explode('/', $fullPath);
        $fileName = end($fullPathArray);
        File::delete(public_path('/upload_images/' . $fileName));
    }

    /**
     * @param Request $request
     * @param $code
     * @param EntityService $entityService
     * @return string
     */
    public
    function getAttributeOptions(Request $request, $id, EntityService $entityService)
    {
        $attributeItem = AttributeItem::query()->findOrFail($id);
        return $entityService->getAttributeOptions($attributeItem);
    }

    /**
     * @param Request $request
     * @param EntityService $entityService
     * @return
     */
    public
    function multiselectItems(Request $request, EntityService $entityService)
    {
        return $entityService->multiselectItems($request->get('productId'), $request->get('type'));
    }

    /**
     * @param Request $request
     * @param EntityService $entityService
     * @return
     */
    public
    function multiselectTags(Request $request, EntityService $entityService)
    {
        return $entityService->multiselectTags($request->get('entity'));
    }

    public
    function checkAllProducts(Request $request)
    {

        $product_id = ProductCategory::select('id')->where('title', $request->categoryName)->first();
        $query = DB::table('product_product_category')
            ->where('product_category_id', '=', $product_id->id)
            ->get();
        return response()->json($query);
    }

    /**
     * @param User $user
     * @param $entity
     * @return array
     */
    public function getConfigByRole(User $user, $entity): array
    {
        $config = [];
        if ($user->hasRole('admin')) {
            $config = config('admin.entities.' . $entity);
        } elseif ($user->hasRole('manager')) {
            $config = config('manager.entities.' . $entity);
        }


        return $config;
    }

    /**
     * Копирование записи.
     *
     * @param Request $request
     * @param $entity
     * @param $id
     */
    public function copy(Request $request, $entity, $id)
    {
        Log::info("Entity: $entity, ID: $id"); // Логируем сущность и ID

        // Проверка на наличие конфигурации для сущности
        $config = config('admin.entities.' . $entity);
        if (!$config) {
            Log::error("Конфигурация сущности не найдена: $entity");
            return response()->json([
                'success' => false,
                'message' => 'Сущность не найдена.',
            ], 404);
        }

        // Получаем модель из конфигурации
        $model = $config['model'];

        try {
            // Находим оригинальный элемент по ID
            $originalItem = $model::findOrFail($id);
        } catch (\Exception $e) {
            Log::error("Ошибка при поиске элемента: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Элемент не найден.',
            ], 404);
        }

        // Делаем копию элемента
        $newItem = $originalItem->replicate();

        // Сохраняем новую запись в базе
        $newItem->save();

        return response()->json([
            'success' => true,
            'message' => 'Запись успешно скопирована!',
        ]);
    }

}

