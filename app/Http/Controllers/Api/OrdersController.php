<?php

namespace App\Http\Controllers\Api;

use Mail;
use App\ApiToken;
use App\DeliveryArea;
use App\OrderStatus;
use App\Order;
use App\OrderedProduct;
use App\Product;
use App\Settings;
use App\PromoCode;
use Carbon\Carbon;
use App\Services\OrdersService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with('orderedProducts')->
            where('customer_id', $request->user->id)->
            orderBy('created_at', 'DESC')->
            limit(50)->get();
        return response()->json($orders);
    }

    public function setStatus(Request $request)
    {
        $order = Order::find($request->input('id'));
        $success = false;
        if ($request->user->id == $order->delivery_boy_id) {
            $status = OrderStatus::find($request->input('order_status_id'));
            if ($status != null && $status->available_to_delivery_boy) {
                $order->order_status_id = $status->id;
                $order->save();
                $success = true;
            }
        }
        return response()->json(['success' => $success]);
    }

    public function indexDriver(Request $request)
    {
        $orders = Order::where('delivery_boy_id', $request->user->id)->
            orderBy('created_at', 'DESC')->
            paginate(20);
        return response()->json($orders);
    }

    public function create(Request $request)
    {
        try{
        $apiToken = ApiToken::where('token', $request->header('token'))->first();
        $customer_id = null;
        if ($apiToken) {
            $customer_id = $apiToken->customer_id;
        }
        $loyalty = 0;
        if ($request->input('loyalty')) {
            $loyalty = $request->input('loyalty');
        }
        $data = [
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'lat' => $request->input('lat'),
            'lng' => $request->input('lng'),
            'payment_method' => $request->input('payment_method'),
            'stripe_token' => $request->input('stripe_token'),
            'paypal_id' => $request->input('paypal_id'),
            'delivery_area_id' => $request->input('delivery_area_id'),
            'customer_id' => $customer_id,
            'city_id' => $request->input('city_id'),
            'loyalty' => $loyalty,
            'restaurant_id' => $request->input('restaurant_id'),
            'comment' => $request->input('comment')
        ];
        $service = new OrdersService();
        $response = $service->createOrder($data, $request->input('products'), $request->input('code'));
        if ($response['success']) {
            $order = $response['order']->fresh();
            // Mail::send('emails.order_created', ['item' => $order], function ($m) use ($order) {
            //     $m->from(Settings::getSettings()->mail_from_mail, Settings::getSettings()->mail_from_name);
            //     $m->to(Settings::getSettings()->notification_email)->subject(Settings::getSettings()->mail_from_new_order_subject);
            // });
            $response = [
                'success' => true,
                'order' => $order->load('orderedProducts')->toArray()
            ];
        }
        return response()->json($response);
    }catch(\Exception $e){
        print $e;
    }
    }

    protected function getValidator($data)
    {
        $service = new OrdersService();
        return $service->getValidator();
    }
}
