<?php

namespace Manifera\Catalog\Http\Controllers\Admin\Product;

use Manifera\Catalog\Model\Product;

class Action extends \App\Http\Controllers\Controller
{
    /**
     * @var Product
     */
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
        parent::__construct();
    }

    public function edit($id)
    {
        $request = request()->all();
        $product = Product::where('id', $id)->first();
        if (!$product) {
            throw new \Exception('Product is not existed!');
        }
        $product->name = $request['name'];
        $product->price= $request['price'];
        $product->qty= $request['qty'];
        $product->sku= $request['sku'];
        $product->save();

        return redirect()->route('catalog::admin.products');
    }

    public function create()
    {
        $request = request()->all();
        $product = new Product();
        $product->name = $request['name'];
        $product->price= $request['price'];
        $product->qty= $request['qty'];
        $product->sku= $request['sku'];
        $product->save();

        return redirect()->route('catalog::admin.products');
    }
}
