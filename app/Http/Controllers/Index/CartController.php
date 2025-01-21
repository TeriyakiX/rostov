<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Mail\CompleteOrder;
use App\Mail\NewOrderAdminMail;
use App\Mail\OrdersMail;
use App\Mail\SendOneClickMail;
use App\Models\ManagerContacts;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\FileService;
use App\Services\ProductService;
use App\Services\Shop\CartPosition;
use App\Services\Shop\CartService;
use Dompdf\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Rawilk\Printing\Facades\Printing;
use Spatie\Permission\Models\Role;
use Mail;
use PDF;
use Kenvel\Sberbank;
use App\Sms\SmsHelper;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\Session;
use Swift_TransportException;

class CartController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function index(Request $request)
    {
//        $cart=$request->session()->all()['cart']['products']??[];
//        $arrId=[];
//        foreach ($cart as $key=>$item){
//            $id=explode('@',$key);
//                $arrId[]=$id;
//        }
//        $resultArr=[];
//        foreach ($arrId as $item){
//            if (count($item)>1){
//    $key=array_search($item[0], $resultArr);
//    if (count($item)>1){
//        $resultArr[]=[$item[0]=>$item[1]];
//    }
//
//            }else{
//                $resultArr[]=$item[0];
//            }
//
//        }
//        dd($resultArr);
//dd(Session::get('temp.cart.products'));
        return view('cart.index');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function checkout()
    {
        $userData = auth()->check() ? auth()->user() : null;

        return view('cart.checkout')->with(compact('userData'));
    }

    public function change(Request $request)
    {
        $cart = app()->make('cart');

        $request['product_id'] = str_replace('length_', 'length=', $request['product_id']);
        foreach (Session::get($cart::SESSION_KEY_PRODUCTS, []) as $productId => $options) {

            if ($productId == $request['product_id']) {

                $length = isset($options['length']) ? $options['length'] / 1000 : 1;
                $width = isset($options['width']) ? $options['width'] / 1000 : 1;

                $options['totalPrice'] = $request['qtty'] * $options['price'] * $length * $width;

                $options['totalSquare'] = $request['qtty'] * $length * $width;
                $options['quantity'] = $request['qtty'];
                Session::put($cart::SESSION_KEY_PRODUCTS . '.' . $productId, $options);
            }

        }

        $cart->commit();

    }
    private function createRandomPassword() {

        $chars = "abcdefghijkmnopqrstuvwxyz023456789";
        srand((double)microtime()*1000000);
        $i = 0;
        $pass = '' ;

        while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }

        return $pass;

    }
    /**
     * @param CheckoutRequest $request
     * @param FileService $fileService
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function checkoutDo(CheckoutRequest $request, FileService $fileService)
    {
        $data = $request->all();
        $cart = app()->make('cart');
        $userHaveAccount = User::query()
            ->where('email', $request->email)
            ->exists();

        $userHaveOrder = Order::query()
            ->where('email', $request->email)
            ->exists();
        if($userHaveAccount && !auth()->check()){
            return redirect()->route('index.cart.index')->with('error', 'Данная почта уже существует. Авторизуйтесь чтобы оформить заказ или измените почту.');
        }
        if ($request->get('register_me') == 1) {
            if (!$userHaveAccount && !$userHaveOrder) {
                $newPassword = $this->createRandomPassword();
                $user = User::query()
                    ->create([
                        'email' => $request->email,
                        'phone_number'=> $request->phone_number,
                        'name' => $request->name,
                        'password' => bcrypt($newPassword)
                    ]);
                $clientRole = Role::findByName('client', 'web');
                $user->assignRole($clientRole);
                Mail::to($request->email)->send(new CompleteOrder($newPassword));
                Auth::login($user);
            } else {
                return redirect()->route('index.cart.index')->with('error', 'Данная почта уже существует. Авторизуйтесь чтобы оформить заказ или измените почту.');
            }
        }

        $order = new Order($data);
        $order->total_price = $cart->getTotalPrice();
        if(auth()->check()) {
            $order->user_id = auth()->id();
        } elseif(!auth()->check() && (!$userHaveOrder || !$userHaveAccount)) {
            $order->user_id = 0;
        } else {
            $order->user_id = 0;
        }
        $order->status = Order::STATUS_AWAITING_PAYMENT;
        $status = OrderStatus::query()->findOrFail($order->status);
        $order->status = $status->title;
        foreach ($cart->getPositions()->all() as $position) {
            $order->addPosition($position->getProduct()->id, $position->getOptions());
        }
        $order->save();

        // files
        $file = $request->file('file');
        if ($file) {
            $fileService->uploadFile($file, $order);
        }
        $file2 = $request->file('file2');
        if ($file2) {
            $fileService->uploadFile($file2, $order);
        }
        //logger($model);

        try{
            Mail::to($data['email'])->send(new OrdersMail($order));
            Mail::to(ManagerContacts::firstOrFail()->email)->send(new OrdersMail($order));
        }
        catch (\Swift_TransportException $e){
            $response_message = $e->getMessage();
            return redirect()->route('index.cart.index')->with('error', 'Проблема с отправкой почты: ' . $response_message);
        }
        catch(\Exception $e){
            return redirect()->route('index.cart.index')->with('error', 'Произошла непредвиденная ошибка: ' . $e->getMessage());
        }
        $api = new SmsHelper (config('constants.apiname_SmsHelper'), config('constants.apikey_SmsHelper'), true, false);
        $result_sms = $api->sendSMS(preg_replace('/[^0-9]/', '', ManagerContacts::firstOrFail()->phone), 'Оформлен заказ', 'mkrostov');

        $cart->flush();

        return redirect()->route('index.cart.index')->with('message', 'zakas oformlen');
    }

    /**
     * Add product to cart.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */


    public function add(Request $request)
    {


        /** @var CartService $cart */
        $cart = app()->make('cart');
        Session::put('temp',[]);
        $message = '';
        // TODO: ПОКА НЕ УДАЛЯТЬ!!!
//        if ($request->has('product_id')) {
//            $productId = $request->get('product_id');
//            if ($request->get('length')) {
//                foreach ($request->get('length') as $key => $length) {
//                    if ($request->get('totalSquare')[$key]) {
//                        $all = $request->except(['_token', 'product_id', 'length']);
//                        $all['quantity'] = $request->get('quantity')[$key];
//                        $all['totalSquare'] = $request->get('totalSquare')[$key];
//                        $all['square'] = $request->get('totalSquare')[$key] / $request->get('quantity')[$key];
//                        $all['totalPrice'] = $request->get('totalPrice')[$key];
//                        $all['price'] = $request->get('price');
//                        $all['length'] = $length;
//                        if($request->get('temporary_cart'))
//                        $sessionKey = 'temp.'.$cart::SESSION_KEY_PRODUCTS . '.' . $productId . 'length=' . $length;
//                        else
//                            $sessionKey = $cart::SESSION_KEY_PRODUCTS . '.' . $productId . 'length=' . $length;
//                        $cart->setPositionAlt($productId, $sessionKey, $all);
//                    }
//                }
//            } else {
//                $all = $request->except(['_token', 'product_id', 'length']);
//                if($request->get('temporary_cart'))
//                $sessionKey =  'temp.'.$cart::SESSION_KEY_PRODUCTS . '.' . $productId;
//                else
//                    $sessionKey = $cart::SESSION_KEY_PRODUCTS . '.' . $productId;
//                $all['quantity'] = $request->get('quantity')[0];
//                $all['totalPrice'] = $request->get('totalPrice')[0];
//                $cart->setPositionAlt($productId, $sessionKey, $all);
//            }
//
//            $cart->commit();
//            $message = 'Товар успешно добавлен в корзину!';
//            \Log::debug('Request Data:', $request->all());
//        } else {
//            $message = 'Не удалось добавить товар в корзину.';
//        }

        if ($request->has('product_id')) {
            $productId = $request->get('product_id');
            $options = $request->except(['_token', 'product_id']);

            $sessionKey = $cart::SESSION_KEY_PRODUCTS . '.' . $productId;
            if ($request->get('length')) {
                foreach ($request->get('length') as $key => $length) {
                    $options['length'] = $length;
                    $options['totalSquare'] = $request->get('totalSquare')[$key] ?? 0;
                    $options['quantity'] = $request->get('quantity')[$key] ?? 1;
                    $options['totalPrice'] = $request->get('totalPrice')[$key] ?? 0;
                    $options['square'] = $request->get('totalSquare')[$key] / $request->get('quantity')[$key];
                    $options['price'] = $request->get('price');
                    $sessionKeyWithLength = $sessionKey . 'length=' . $length;
                    $cart->setPositionAlt($productId, $sessionKeyWithLength, $options);
                }
            } else {
                $options['quantity'] = $request->get('quantity')[0] ?? 1;
                $options['totalPrice'] = $request->get('totalPrice')[0] ?? 0;
                $cart->setPositionAlt($productId, $sessionKey, $options);
            }

            $cart->commit();
            $message = 'Товар успешно добавлен в корзину!';
        } else {
            $message = 'Не удалось добавить товар в корзину.';
        }

        $quantity = $cart->getTotalQuantity();
        $totalPrice = $cart->getTotalPrice();
        $positions = $cart->getPositions();

        $cartContentView = view('products._cart_modal_content', [
            'positions' => $positions,
            'quantity' => $quantity,
            'totalPrice' => $totalPrice
        ])->render();

        return [
            'status' => 200,
            'message' => $message,
            'cartContentView' => $cartContentView,
            'cartInfo' => 'В корзине ' . $cart->getTotalQuantity() . ' товар на сумму ' . $cart->getTotalPrice() . ' ₽',
            'totalItemsInCart' => $quantity
        ];
    }

    /**
     * Remove product from cart.
     *
     * @param \Illuminate\Http\Request $request
     * @return int[]
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function remove(Request $request)
    {
        /** @var CartService $cart */
        $cart = app()->make('cart');
        if ($request->has('product_id')) {
            $product_id = $request->get('product_id');
            $cart->removePosition($product_id);
            $cart->commit();
        }
        return [
            'status' => 200
        ];
    }

    public function send_order_toMail()
    {
        $cart = app()->make('cart');
        Mail::to(Auth::user()->email)->send(new OrdersMail($cart->getPositions()));
        return redirect()->back();
    }

    public function print_order()
    {
        $cart = app()->make('cart');
        return view('posts.order_mail', ['orders' => $cart->getPositions()]);
    }

//    public function pay(Request $request)
//    {
//        dd(3);
////        $acquiring_url = 'https://3dsec.sberbank.ru/';
////        $access_token  = 'qttofspue28gsj809rbkedsde';
//
//        $sberbank = new Sberbank($acquiring_url, $access_token);
////        dd($sberbank);
//        //Подготовка массива с данными об оплате
//        $payment = [
//            'orderNumber'   => '1234567',                           //Номер заказа
//            'amount'        => 100,                                 //Сумма заказа в рублях
//            'language'      => 'ru',                                //Локализация
//            'description'   => 'New payment',                       //Описание заказа
//            'returnUrl'     => 'https://google.com', //URL сайта в случае успешной оплаты
//            'failUrl'       => 'https://google.com',       //URL сайта в случае НЕуспешной оплаты
//        ];
//        $result = $sberbank->paymentURL($payment);
//
//
//
//        if(!$result['success']){
//            echo($result['error']);
//        } else{
//            $payment_id = $result['payment_id'];
//            return redirect($result['payment_url']);
//        }
//    }

    public function clearCart(Request $request, CartService $cartService)
    {
        $countInSession = Session::get(CartService::SESSION_KEY_PRODUCTS, []);
        $cartService->flushSessionPart(CartService::SESSION_KEY_PRODUCTS);

        return ['message' => 'Все товары успешно удалены из корзины!', 'count' => count($countInSession)];
    }
}
