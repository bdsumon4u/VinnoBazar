<?php

use App\Http\Controllers\Admin\OrderController;
use App\Order;
use App\OrderProducts;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('status-update', function (Request $request)
{
    if ($request->header('X-PATHAO-Signature') != 'vinnohbs') {
        return;
    }

    if (! $order = Order::where('invoiceID', $request->merchant_order_id)->orWhere('courier->consignment_id', $request->consignment_id)->first()) return;

    $courier = $request->only([
        'consignment_id',
        'order_status',
        'reason',
        'invoice_id',
        'payment_status',
        'collected_amount',
    ]);
    $order->forceFill(['courier' => ['booking' => 'Pathao'] + $courier]);

    if ($request->order_status_slug == 'Pickup_Cancelled') {
        $order->status = 'Canceled';
    }
    if ($request->order_status_slug == 'On_Hold') {
        $order->status = 'On Hold';
    }
    if ($request->order_status_slug == 'Delivered') {
        $order->status = 'Delivered';
        $order->deliveryDate = date('Y-m-d');
        $orderProducts = OrderProducts::query()->where('order_id', '=', $order->id)->get();
        foreach ($orderProducts as $orderProduct) {
            $stock = Stock::query()->where('product_id', '=', $orderProduct->product_id)->first();
            if ($stock) {
                $stock->stock = $stock->stock - $orderProduct->quantity;
                $stock->save();
            }
        }
    }
    if ($request->order_status_slug == 'Payment_Invoice') {
        $order->status = 'Paid';
        $order->completeDate = date('Y-m-d');
    }
    if ($request->order_status_slug == 'Return') {
        $order->status = 'Return';
        $order->completeDate = date('Y-m-d');
        $orderProducts = OrderProducts::query()->where('order_id', '=', $order->id)->get();
        foreach ($orderProducts as $orderProduct) {
            $stock = Stock::query()->where('product_id', '=', $orderProduct->product_id)->first();
            if ($stock) {
                $stock->stock = $stock->stock + $orderProduct->quantity;
                $stock->save();
            }
        }
    }

    $order->save();
});
