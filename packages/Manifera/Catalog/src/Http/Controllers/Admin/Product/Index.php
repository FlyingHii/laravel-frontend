<?php

namespace Manifera\Catalog\Http\Controllers\Admin\Product;

use Manifera\Catalog\Model\Product;

class Index extends \App\Http\Controllers\Controller
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

    public function index()
    {
        $products = Product::all();
        return view($this->_config['view'], compact('products'));
    }

    public function edit($id)
    {
        $product = Product::where('id', $id)->first();
        if (!$product) {
            return redirect()->route('catalog::admin.product.create');
        }
        return view($this->_config['view'], compact('product'));
    }

    public function create()
    {
        $product = new Product();
        return view($this->_config['view'], compact('product'));
    }
}
