<?php

namespace Manifera\Admin\Http\Controllers;

class Index extends \App\Http\Controllers\Controller
{
    public function index()
    {
        return view($this->_config['view']);
    }
}
