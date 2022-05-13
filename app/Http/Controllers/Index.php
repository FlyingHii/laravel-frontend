<?php

namespace App\Http\Controllers;

class Index extends \App\Http\Controllers\Controller
{
    public function index()
    {
        return view($this->_config['view']);
    }
}
