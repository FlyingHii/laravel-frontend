@extends('layouts.master')
@section('title')

    {{'Products'}}

@stop

@section('content')
    <a href="{{route('catalog::admin.product.create')}}">Create</a>
    <div>
        <ul>
            @foreach($products->all() as $product)
                <li><a href="{{route('catalog::admin.product.edit', ['id' => $product->id])}}">{{$product->name}}</a></li>
            @endforeach
        </ul>
    </div>

@endsection

@section('script')

@endsection
