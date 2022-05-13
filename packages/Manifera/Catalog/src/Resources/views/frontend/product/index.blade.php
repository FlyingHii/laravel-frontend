@extends('layouts.master')
@section('title')
    {{'Product ' . $product->id}}
@stop

@section('content')
    @include('catalog::frontend.product.ui.action-form', [
    'action' => route('catalog::admin.product.action.edit', ['id' => $product->id]),
    'product' => $product
    ])
@endsection

@section('script')

@endsection
