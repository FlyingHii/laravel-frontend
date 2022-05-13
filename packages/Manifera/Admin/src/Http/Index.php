<?php
namespace Manifera\Admin\Http;

class Index
{
    public function index()
    {
        return view('admin::dashboard.index');
    }
}
