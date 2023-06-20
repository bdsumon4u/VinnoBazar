<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Notification;
use App\Order;
use App\OrderProducts;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        session_start();
        error_reporting(0);
        if(!$_SESSION['delivery']){
            $_SESSION['delivery'] = 60;
        }

        return view('website.checkout');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Request
     */
    public function store(Request $request)
    {
        $product = Product::find($request->id);
        Cart::add($product->id,$product->productName, 1, $product->price() )->associate('App\Product');
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Cart::remove($id);
        $response['reload'] = 'true';
        if (Cart::count() > 0 ){
            $response['reload'] = 'false';
        }
        $response['status'] = 'success';
        $response['message'] = 'Successfully Add Product';
        return response()->json($response, 201);
    }

    public function mini_cart()
    {
        $response['count'] = Cart::count();
        $response['data'] = Cart::content();
        return response()->json($response, 200);
    }
    public function miniCart()
    {
        if(Cart::count() > 0){  ?>
            <a href="" class="icon icon-xs rounded-circle border" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <i class="fa fa-shopping-cart d-inline-block nav-box-icon"></i>
                <span class="badge badge-pill badge-danger notify"><?php echo Cart::count(); ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right px-0" x-placement="bottom-end" style="position: absolute; transform: translate3d(-328px, 32px, 0px); top: 0px; left: 0px; will-change: transform;">
                <li>
                    <div class="dropdown-cart px-0">
                        <div class="dc-header">
                            <h4 class="text-center py-2">Cart Items</h4>
                        </div>
                        <div class="dropdown-cart-items c-scrollbar">
                            <?php foreach(Cart::content() as $item) {  ?>
                                <div class="dc-item">
                                    <div class="d-flex align-items-center">
                                        <div class="dc-image">
                                            <a href="<?php echo url('/product/'.$item->model->productSlug) ;?>">
                                                <img  src="<?php echo url('/public/product/thumbnail/'.$item->model->productImage)?>" class="img-fluid" alt="">
                                            </a>
                                        </div>
                                        <div class="dc-content">
                                            <span class="d-block dc-product-name text-capitalize strong-600 mb-1">
                                                 <a href="<?php echo url('/product/'.$item->model->productSlug) ;?>">
                                                     <?php echo $item->model->productName  ?>
                                                 </a>
                                            </span>

                                            <span class="dc-quantity">x<?php echo $item->qty ?></span>
                                            <span class="dc-price">TK <?php echo $item->model->price() ?></span>
                                        </div>
                                        <div class="dc-actions">
                                            <button onclick="removeFromCart('<?php echo $item->rowId; ?>')">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                        <div class="dc-item py-3">
                            <span class="subtotal-text">Subtotal</span>
                            <span class="subtotal-amount">৳ <?php echo Cart::subtotal('0','','') ?></span>
                        </div>
                        <div class="p-2 text-center dc-btn">
                            <a href="<?php echo url('/checkout'); ?>" class="link link--style-1 text-capitalize btn btn-success px-3 py-1 light-text btn-block">
                                <i class="la la-mail-forward"></i> Checkout
                            </a>
                        </div>
                    </div>
                </li>
            </ul>
        <?php }else{ ?>
            <span class="badge badge-pill badge-danger notify">0</span>
            <a href="" class="icon icon-xs rounded-circle border" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <i class="fa fa-shopping-cart d-inline-block nav-box-icon"></i>
                <span class="badge badge-pill badge-danger notify">0</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right px-0" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(-328px, 32px, 0px);">

                <li>
                    <div class="dropdown-cart px-0">
                        <div class="dc-header">
                            <h4 class="text-center py-2">Empty Cart</h4>
                        </div>
                    </div>
                </li>
            </ul>
        <?php }
    }

    public function updateQuantity(Request $request)
    {
        session_start();
        if($request->quantity > 0){
            Cart::update($request->key, $request->quantity);
        }
        ?>
        <aside class="card">
            <article class="card-body">
                <header class="mb-4">
                    <h4 class="card-title" style="font-size: 16px;">আপনার অর্ডার</h4>
                </header>
                <div class="row">
                    <div class="table-responsive bg-white">
                        <table class="table border-bottom">
                            <thead>
                            <tr>
                                <th class="product-image">Image</th>
                                <th class="product-name">Product</th>
                                <th class="product-price">Price</th>
                                <th class="product-quanity">Quantity</th>
                                <th class="product-total">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach(Cart::content() as $item) {  ?>
                                <tr class="cart-item">
                                    <td class="product-image" style="display: flex; flex-direction: row-reverse;">
                                        <a href="#" >
                                            <img class="lazyload" src="<?php echo url('/public/product/thumbnail/'.$item->model->productImage) ?>" style="max-width: 50px">
                                        </a>
                                        <button href="#"  onclick="removeFromCart('<?php echo $item->rowId ?>')" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>

                                    <td class="product-name">
                                        <span class="d-block"><?php echo $item->model->productName ?></span>
                                    </td>

                                    <td class="product-price">
                                        <span class="d-block">TK <?php echo $item->model->price() ?></span>
                                    </td>

                                    <td class="product-quantity">
                                        <div class="input-group input-spinner">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-light btn-number" type="button" data-type="plus" data-field="quantity[<?php echo $item->id ?>]"> + </button>
                                            </div>
                                            <input type="text" name="quantity[<?php echo $item->id ?>]" class="form-control input-number" placeholder="1" value="<?php echo $item->qty ?>" min="1" max="10" onchange="updateQuantity('<?php echo $item->rowId ?>', this)">
                                            <div class="input-group-append">
                                                <button class="btn btn-light btn-number" type="button" data-type="minus"  data-field="quantity[<?php echo $item->id ?>]"> − </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="product-total">
                                        <span>TK <?php echo Cart::subtotal('0','','')?></span>
                                    </td>

                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </article>
            <article class="card-body border-top">
                <dl class="row">
                    <dt class="col-sm-8">Subtotal: </dt>
                    <dd class="col-sm-4 text-right"><strong>TK <?php echo Cart::total('0') ?></strong></dd>

                    <dt class="col-sm-8">Delivery charge: </dt>
                    <dd class="col-sm-4 text-danger text-right"><strong>TK <?php echo $_SESSION['delivery'] ?></strong></dd>

                    <dt class="col-sm-8">Total:</dt>
                    <dd class="col-sm-4 text-right"><strong class="h5 text-dark">TK <?php echo Cart::subtotal('0','','')+$_SESSION['delivery']; ?></strong></dd>
                </dl>

            </article>
            <script type="text/javascript">
                cartQuantityInitialize();
            </script>

        </aside>
    <?php }

    public function updateDeliveryCharge(Request $request)
    {
        session_start();
        $_SESSION['delivery'] = $request->selectCourier;

    }

    public function placeOrder(Request $request)
    {
        $customerPhone = $request->customerPhone;
        if (! preg_match('/^01\d{9}$/', $customerPhone)) {
            $response['status'] = 'failed';
            $response['message'] = 'Phone no. must have 11 digits';
            return response()->json($response, 201);
        }
        if (strlen($request->customerAddress) < 10 || strlen($request->customerAddress) > 250) {
            $response['status'] = 'failed';
            $response['message'] = 'Address must be between 10-250 characters';
            return response()->json($response, 201);
        }
        // old orders
        $old_orders = DB::table('orders')->whereIn('id', function ($query) use ($customerPhone) {
            $query->select('order_id')->from('customers')
                ->where('customerPhone', 'like', '%'.$customerPhone.'%')
                ->orWhere('customerAddress', 'like', '%'.$customerPhone.'%');
        })->get();
        // user_ids = distinct user ids from old orders
        $user_ids = $old_orders->unique('user_id')->pluck('user_id');
        // is_repeat = if old orders are more than 0
        $is_repeat = count($old_orders) > 0;
        // is_fraud = if old orders has any cancelled order
        $is_fraud = count($old_orders->where('status', 'Canceled')) > 0;
        // ********** Canceled banan vul in their panel **********

        $user = DB::table('users')->where([
            ['status', 'like', 'Active'],
            ['role_id', '=', '3']
        ]);

        if (count($user_ids) > 0) {
            $user = $user->whereIn('id', $user_ids);
        }
        $user = $user->inRandomOrder();
        $user = $user->first();
        if (!$user) {
            $user = User::find(1);
        }
        $order = new Order();



        $order->invoiceID = $this->uniqueID();
        $order->store_id = 1;
        $order->deliveryCharge = $request->selectCourier;
        $order->orderDate = date('Y-m-d');
        $order->subTotal = Cart::subtotal('0','','')+$request->selectCourier;
        $order->user_id = $user->id;
        $order->is_repeat = $is_repeat;
        $order->is_fraud = $is_fraud;
        $order->save();
        if($order->id){
            $customer = new Customer();
            $customer->order_id = $order->id;
            $customer->customerName = $request->customerName;
            $customer->customerPhone = $request->customerPhone;
            $customer->customerAddress = $request->customerAddress;
            $customer->save();
            foreach(Cart::content() as $item) {

                $orderProducts = new OrderProducts();
                $orderProducts->order_id = $order->id;
                $orderProducts->product_id = $item->model->id;
                $orderProducts->productCode = $item->model->productCode;
                $orderProducts->productName = $item->model->productName;
                $orderProducts->quantity = $item->qty;
                $orderProducts->productPrice = $item->model->price();
                $orderProducts->save();

                $response['link'] = url('/checkout/order-received/'.$order->id);
                $response['status'] = 'success';
                $response['message'] = 'Successfully Placed Order';
            }
            $notification = new Notification();
            $notification->order_id = $order->id;
            $notification->notificaton = '#SD' . $order->id . ' Order Has Been Created by ' . $user->name;
            $notification->user_id = $user->id;
            $notification->save();
        } else{
            Customer::where('order_id', '=', $order->id)->delete();
            OrderProducts::where('order_id', '=', $order->id)->delete();
            Notification::where('order_id', '=', $order->id)->delete();
            Order::where('id', '=', $order->id)->delete();
            $response['status'] = 'failed';
            $response['message'] = 'Unsuccessful to Add Order';
            $response['status'] = 'failed';
            $response['message'] = 'Unsuccessful to Placed Order';
        }
        Cart::destroy();
        return response()->json($response, 201);
    }

    public function orderRecived()
    {
        return view('website.thankyou');

    }
    public function uniqueID()
    {
        $lastOrder = Order::latest('id')->first();
        if ($lastOrder) {
            $orderID = $lastOrder->id + 1;
        } else {
            $orderID = 1;
        }

        return 'BB-' . $orderID;
    }
}
