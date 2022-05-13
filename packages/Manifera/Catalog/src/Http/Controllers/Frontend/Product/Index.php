<?php

namespace Manifera\Catalog\Http\Controllers\Frontend\Product;

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

    public function index($sku)
    {
        $product = Product::where('sku', $sku)
            ->first();
        return view($this->_config['view'], compact('product'));
    }
}
