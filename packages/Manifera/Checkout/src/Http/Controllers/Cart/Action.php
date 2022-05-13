<?php

namespace Manifera\Checkout\Http\Controllers\Cart;

use Illuminate\Http\Request;
use Manifera\Checkout\Model\Cart;

class Action extends \App\Http\Controllers\Controller
{
    public function add()
    {
        $request = request()->all();
        try {
            Cart::created([
                'customer_email' => $request->customer_email,
                'grand_total'    => $request->grand_total,
                'sub_total'      => $request->sub_total,
                'is_active'      => $request->is_active,
            ]);
        } catch (\Exception $e) {
            return request()->session()->flash('status', 'fail');
        }
        return request()->session()->flash('status', 'success');
    }
}
