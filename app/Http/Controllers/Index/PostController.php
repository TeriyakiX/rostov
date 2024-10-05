<?php

namespace App\Http\Controllers\Index;

use App\Actions\PostAction;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Mail\OrderMail;
use App\Mail\SendDocumentMail;
use App\Mail\SendMail;
use App\Mail\SendOneClickMail;
use App\Models\AttributeItem;
use App\Models\Brand;
use App\Models\BuilderGuide;
use App\Models\Calculator;
use App\Models\Coatings;
use App\Models\File;
use App\Models\ManagerContacts;
use App\Models\OptionItem;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductCategory;
use App\Models\ProductionCategories;
use App\Models\Tags;
use App\Models\TagsCategories;
use App\Models\TurnkeySolutions;
use App\Models\VideoYoutube;
use App\Models\TypesAttribute;
use App\Models\UsefulChapter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;
use function Sodium\add;
use Illuminate\Support\Facades\Storage;
use App\Sms\SmsHelper;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {

        $posts = Post::query()
            ->active()
            ->get();

        return view('posts.index')->with(compact('posts'));
    }

    /**
     * @param Request $request
     * @param $slug
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function category(Request $request, $slug)
    {
        $postCategory = PostCategory::query()->where('slug', $slug)->first();
        $posts = $postCategory
            ->posts()
            ->active()
            ->get();

        return view('posts.category')->with(compact('posts', 'postCategory'));
    }

    /**
     * @param $slug
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show($slug, Request $request, PostAction $action)
    {

        return $action->handle($slug, $request);
    }

    public function getCalculator($slug)
    {
        $post = Calculator::where('slug', $slug)->firstOrFail();
        return view('posts.custom._calculator')->with(compact('post'));

    }

    public function getWordInfo($word)
    {
        $post = BuilderGuide::where('slug', $word)->first();
        return view('posts.custom._full_guide_info')->with(compact('post'));
    }

    public function getReviewById($slug)
    {

        $post = Post::query()
            ->whereSlug($slug)
            ->firstOrFail();
        return view('posts.custom._by_id')->with(compact('post'));
    }

    //Метод отправки сообщения "Купить в 1 клик"//
    public function sendOneClickMail(Request $request)
    {

        $address = $request->address;
        $name = $request->name;
        $phoneNumber = $request->phone_number;
        $vendorCode = $request->vendor_code ? $request->vendor_code : 'none';
        $product_title = $request->title ? $request->title : 'none';
        $deliveryMethod = $request->delivery_method;


        $products = '';
        if (Session::get('temp.cart.products')) {

            foreach (Session::get('temp.cart.products') as $product) {
                $data = [
                    'Цвет' => $product['color'] ?? '',
                    'Код товара' => $vendorCode,
                    'Кол-во' => $product['quantity'] ?? '',
                    'Цена' => $product['totalPrice'] ?? '',
                ];
                // Проверка на наличие атрибута и его добавление, если он есть
                if (isset($product['attribute'])) {
                    $data['Атрибут'] = $product['attribute'];
                }
                // Process nested arrays if present in $data
                foreach ($data as $key => $value) {
                    if (is_array($value)) {
                        $nestedData = '';
                        foreach ($value as $nestedKey => $nestedValue) {
                            $nestedData .= "$nestedKey: $nestedValue\n";
                        }
                        $data[$key] = $nestedData;
                    }
                }

                // Convert $data to a formatted string
                $productInfo = '';
                foreach ($data as $key => $value) {
                    $productInfo .= "$key: $value\n";
                }

                $products .= "Товар: $product_title\n" . $productInfo . "\n";
            }


            switch ($deliveryMethod) {
                case ('1'):
                {
                    $deliveryMethod = 'Самовывоз';
                    Mail::to(ManagerContacts::firstOrFail())->send(new SendOneClickMail($name, $phoneNumber, $products, $deliveryMethod));
                    break;
                }
                case ('2'):
                    $deliveryMethod = 'Доставка';
                    Mail::to(ManagerContacts::firstOrFail())->send(new SendOneClickMail($name, $phoneNumber, $products, $deliveryMethod, $address));
                    break;
            }
            $api = new SmsHelper (config('constants.apiname_SmsHelper'), config('constants.apikey_SmsHelper'), true, false);
            $result_sms = $api->sendSMS(preg_replace('/[^0-9]/', '', ManagerContacts::firstOrFail()->phone), 'Покупка в один клик', 'mkrostov');
        }
        return redirect()->back();
    }

    public function sendDocumentMail(Request $request)
    {

        $typeOfRequest = $request->typeOfRequest ?? '';
        $link = $request->link ?? '';
        $phone = $request->phoneNumber ?? '';
        $email = $request->email ?? '';
        $name = $request->username ?? '';
        $documentName = $request->documentName ?? '';
        Mail::to(ManagerContacts::firstOrFail())->send(new SendDocumentMail($name, $phone, $email, $typeOfRequest, $link, $documentName));
        $api = new SmsHelper (config('constants.apiname_SmsHelper'), config('constants.apikey_SmsHelper'), true, false);
        $result_sms = $api->sendSMS(preg_replace('/[^0-9]/', '', ManagerContacts::firstOrFail()->phone), $typeOfRequest, 'mkrostov');
        return redirect()->back();
    }

    public function sendMail(Request $request)
    {
        $typeOfRequest = $request->typeOfRequest ?? '';
        $address = $request->address;

        $link = $request->link ?? '';
        $phone = $request->phone_number;
        $comment = $request->comment;
        if ($request->has('file')) {

            $file = $request->file('file');
            $file_name = time() . '.' . $file->getClientOriginalExtension();
            $upload_path = public_path('upload_files');

            if (!file_exists($upload_path)) {
                mkdir($upload_path, 0755, true);
            }

            $file->move(public_path('upload_files'), $file_name);

            Mail::send('posts.send_email', [], function ($message) use ($file, $file_name) {
                $message->to(ManagerContacts::firstOrFail()->email, 'Manager')->subject('Консультация')
                    ->attach(public_path('upload_files/' . $file_name), ['as' => $file_name]);
            });
        } else {
            Mail::to(ManagerContacts::firstOrFail())->send(new SendMail($address, $phone, $comment, $typeOfRequest, $link));

        }
        $api = new SmsHelper (config('constants.apiname_SmsHelper'), config('constants.apikey_SmsHelper'), true, false);
        $result_sms = $api->sendSMS(preg_replace('/[^0-9]/', '', ManagerContacts::firstOrFail()->phone), $typeOfRequest, 'mkrostov');
        return redirect()->back();
    }

    public function FileFilter(Request $request)
    {


        if (isset($request->tagId)) {

            $files = File::where('active', '1')->where('file_type_id', $request->type)->where('files_tags.tag_id', $request->tagId)
                ->join('files_tags', 'file_id', 'files.id')->paginate(20)->withQueryString();
        } else {
            $files = File::where('active', '1')->where('file_type_id', $request->type)->paginate(20);
        }

        if ($request->has('search_body')) {
            $files = File::where('active', '1')->where('file_type_id', $request->type)->where('title', 'LIKE', "%$request->search_body%")->get();
        }
//        foreach ($files as $key => $file) {
//            if (substr(strrchr($file->filepath, "."), 1) != $request->type) {
//                unset($files[$key]);
//            }
//        }
        $file_number = $request->type;
        $data = [
            'files' => $files,
            'type' => $request->type,
            'file_number' => $file_number,
        ];
        return response()->json($data);
    }

    public function filter($slug, $request)
    {
        $post = Post::query()
            ->whereSlug($slug)
            ->firstOrFail();

        $input = $request->all();
        $query = new Coatings();

        $result = $query->orderBy('id', 'DESC');

        if (array_key_exists('coating_id', $input)) {
            $result = $result->where('id', $input['coating_id']);
        }
        if (array_key_exists('filter', $input)) {
            if (array_key_exists('metal_thickness', $input['filter'])) {
                $optionIds = explode(';', $input['filter']['metal_thickness']);
                $result = $result->whereIn('metal_thickness', $optionIds);
            }
            if (array_key_exists('polymer_coating_thickness', $input['filter'])) {
                $optionIds = explode(';', $input['filter']['polymer_coating_thickness']);
                $result = $result->whereIn('polymer_coating_thickness', $optionIds);
            }
            if (array_key_exists('guarantee', $input['filter'])) {
                $optionIds = explode(';', $input['filter']['guarantee']);
                $result = $result->whereIn('guarantee', $optionIds);
            }
            if (array_key_exists('light_fastness', $input['filter'])) {
                $optionIds = explode(';', $input['filter']['light_fastness']);
                $result = $result->whereIn('light_fastness', $optionIds);
            }
            if (array_key_exists('protective_layer', $input['filter'])) {
                $optionIds = explode(';', $input['filter']['protective_layer']);
                $result = $result->whereIn('protective_layer', $optionIds);
            }
        }

        $coatings = $result->get();
        return view('posts.show')->with(compact('post', 'coatings'));
    }
}
