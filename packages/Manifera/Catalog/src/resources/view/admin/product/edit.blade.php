@extends('layouts.master')
@section('title')
    @if($product->id)
        {{'Product ' . $product->id}}
    @else
        {{'Create Product'}}
    @endif
@stop

@section('content')
    @include('admin::product.ui.form', ['action' => route('admin::catalog.products.update', ['id' => $product->id ?? 0])])
@endsection

@section('script')

@endsection