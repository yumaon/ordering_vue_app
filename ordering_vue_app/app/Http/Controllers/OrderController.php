<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;

use App\Models\Product;
use App\Models\Customer;
use Inertia\Inertia;
use App\Http\Resources\OrderResource;

use Illuminate\Http\Request;

// PDF化のため、DomPDFを読み込む
use Barryvdh\DomPDF\Facade\Pdf;
use NumberFormatter;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $orders = OrderResource::collection(Order::paginate(5));
        // return Inertia::render('Orders/Index', [
        //     'orders' => $orders
        // ]);
        if (empty($request->input()['search_str'])) {
            $search_str = null;
            $orders = OrderResource::collection(
                Order::orderBy('id', 'desc')->paginate(5)
            );
        } else {
            $search_str = $request->input()['search_str'];
            $orders = Order::whereHas('customer', function ($query) use ($search_str) {
                $query->where('name', 'LIKE', '%' . $search_str . '%');
            })
                ->orderBy('id', 'desc')
                ->paginate(5);

            $orders = OrderResource::collection($orders);
        }

        return Inertia::render('Orders/Index', [
            'orders' => $orders,
            'search_str' => $search_str,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = Customer::all();
        $products = Product::all();
        return Inertia::render('Orders/Create', [
            'customers' => $customers,
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $order = new Order($request->input());
        $order->orderDay = date("Y-m-d H:i:s");
        $order->save();
        return redirect()->route('orders.index')->with('succsess_str', '登録完了しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $orderResource = new OrderResource($order);

        $normal_tax_total = 0;
        $reduced_tax_total = 0;
        // 商品1
        if($orderResource->product1['tax'] == 10) {
            $normal_tax_total = $normal_tax_total + $orderResource->product1['price'] * $orderResource->num1;
        }
        if($orderResource->product1['tax'] == 8) {
            $reduced_tax_total = $reduced_tax_total + $orderResource->product1['price'] * $orderResource->num1;
        }
        // 商品2
        if($orderResource->product2) {
            if($orderResource->product2['tax'] == 10) {
                $normal_tax_total = $normal_tax_total + $orderResource->product2['price'] * $orderResource->num2;
            }
            if($orderResource->product2['tax'] == 8) {
                $reduced_tax_total = $reduced_tax_total + $orderResource->product2['price'] * $orderResource->num2;
            }
        }
        
        // 商品3
        if($orderResource->product3) {
            if($orderResource->product3['tax'] == 10) {
                $normal_tax_total = $normal_tax_total + $orderResource->product3['price'] * $orderResource->num3;
            }
            if($orderResource->product3['tax'] == 8) {
                $reduced_tax_total = $reduced_tax_total + $orderResource->product3['price'] * $orderResource->num3;
            }
        }

        // 税率計算
        $normal_tax = (int)($normal_tax_total * 0.1);
        $reduced_tax = (int)($reduced_tax_total * 0.08);
        $total = $normal_tax_total + $reduced_tax_total + $normal_tax + $reduced_tax;

        return Inertia::render('Orders/Show', [
            'order' => $orderResource,
            'normal_tax_total' => number_format($normal_tax_total),
            'reduced_tax_total' => number_format($reduced_tax_total),
            'normal_tax' => number_format($normal_tax),
            'reduced_tax' => number_format($reduced_tax),
            'total' => number_format($total)
        ]);
        
        // return Inertia::render('Orders/Show', [
        //     'order' => $orderResource,
        // ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $customers = Customer::all();
        $products = Product::all();
        return Inertia::render('Orders/Edit', [
            'order' => $order,
            'customers' => $customers,
            'products' => $products,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->orderday = date("Y-m-d H:i:s");
        $order->update($request->input());
        return redirect()->route('orders.index')->with('succsess_str', '更新完了しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect('orders');
    }

    public function generatePdf(Order $order)
    {        
        $orderResource = new OrderResource($order);
        $normal_tax_total = 0;
        $reduced_tax_total = 0;
        //商品1
        if($orderResource->product1['tax']==10){
            $normal_tax_total = $normal_tax_total + $orderResource->product1['price'] * $orderResource->num1;
        }
        if($orderResource->product1['tax']==8){
            $reduced_tax_total = $reduced_tax_total + $orderResource->product1['price'] * $orderResource->num1;
        }
        //商品2
        if($orderResource->product2){
            if($orderResource->product2['tax']==10){
                $normal_tax_total = $normal_tax_total + $orderResource->product2['price'] * $orderResource->num1;
            }
            if($orderResource->product2['tax']==8){
                $reduced_tax_total = $reduced_tax_total + $orderResource->product2['price'] * $orderResource->num1;
            }
        }
        //商品3
        if($orderResource->product3){
            if($orderResource->product3['tax']==10){
                $normal_tax_total = $normal_tax_total + $orderResource->product3['price'] * $orderResource->num1;
            }
            if($orderResource->product3['tax']==8){
                $reduced_tax_total = $reduced_tax_total + $orderResource->product3['price'] * $orderResource->num1;
            }
        }
        //税率計算
        $normal_tax = (int)($normal_tax_total * 0.1);
        $reduced_tax = (int)($reduced_tax_total * 0.08);
        $total = $normal_tax_total + $reduced_tax_total + $normal_tax + $reduced_tax;

        $pdf = PDF::loadView('orders.pdf', [
            'order' => $order,
            'normal_tax_total' => number_format($normal_tax_total),
            'reduced_tax_total' => number_format($reduced_tax_total),
            'normal_tax' => number_format($normal_tax),
            'reduced_tax' => number_format($reduced_tax),
            'total' => number_format($total) 
        ])
                    ->set_option('compress', 1)
                    ->setPaper('a4', 'portrait'); // 縦A4サイズに指定
        $fileName = '請求書.pdf';   
        return $pdf->download($fileName);
    }    

}
