@extends('layouts.master')
@section('title')
    {{'Product ' . $product->id}}
@stop

@section('content')
    @include('catalog::admin.product.ui.action-form', [
    'product' => $product
    ])
@endsection

@section('script')

@endsection
