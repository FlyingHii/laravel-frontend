
@extends('admin::admin.layouts.master')
@section('page_title')
    {{'Homepage'}}
@stop
@section('content-wrapper')
    <div >
        @foreach($products as $product)
            <div>
                <a href="{{route('catalog::frontend.products.index', ['sku' => $product->sku])}}">{{$product->name}}</a>
            </div>
        @endforeach
    </div>

@stop
@section('script')

@endsection
