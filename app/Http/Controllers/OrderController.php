<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Exception;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            $orders = Order::query()
                        ->select('id', 'subtotal', 'priority', 'deliver')
                        ->where(function ($query) use($request) {
                            if($request->has('date')) {
                                $query->where('deliver', $request->input('date'));
                            }
                            if ($request->has('order_id')) {
                                $query->where('id', 'like', "%{$request->input('order_id')}%");
                            }
                        })
                        ->with(['items' => function ($query) {
                            $query->select('id', 'product_id', 'order_id', 'quantity', 'unit_price', 'total_price')
                                ->with(['product' => function ($query) {
                                    $query->select('id', 'name', 'stock');
                                }]);
                        }])
                        ->orderBy('priority')
                        ->get();

            return response()->json([
                'response' => 'success',
                'data' => [
                    'orders' => $orders
                ],
                'error' => null
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'response' => 'error',
                'data' => null,
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {

            $orders = Order::query()
                ->select('id', 'subtotal', 'priority', 'deliver')
                ->where('id', $id)
                ->with(['items' => function ($query) {
                    $query->select('id', 'product_id', 'order_id', 'quantity', 'unit_price', 'total_price')
                        ->with(['product' => function ($query) {
                            $query->select('id', 'name', 'stock')->with(['suppliers' => function ($query) {
                                $query->select('id', 'name', 'mobile', 'email');
                            }]);
                        }]);
                }])
                ->orderBy('priority')
                ->first();

            return response()->json([
                'response' => 'success',
                'data' => [
                    'order' => $orders
                ],
                'error' => null
            ]);

        } catch (Exception $exception) {
            return response()->json([
                'response' => 'error',
                'data' => null,
                'error' => $exception->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
