<?php


namespace Manifera\Theme\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Manifera\Catalog\Model\Product;

class Home extends Controller
{
    public function index()
    {
        $products = Product::latest()
            ->limit(5)->get();
        return view($this->_config['view'], compact('products'));
    }
}
