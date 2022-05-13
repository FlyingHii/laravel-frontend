@extends('theme::frontend.layouts.master')
@section('page_title')
    {{'Product ' . $product->id}}
@stop

@section('content-wrapper')
    <div>Sku: {{$product->name}}
    </div>
    <div>price:{{$product->price}}
    </div>
    <div>Salable Qty: {{$product->qty}}
    </div>
    @include('catalog::frontend.product.ui.action-form', [
    'action' => route('checkout::cart.add', ['id' => $product->id]),
    'product' => $product
    ])
@endsection

@section('script')

@endsection
