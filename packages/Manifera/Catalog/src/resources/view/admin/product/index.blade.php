@extends('layouts.master')
@section('title')

    {{'Products'}}

@stop

@section('content')
    <a href="{{route('admin::catalog.products.update', ['id' => 0])}}">Create</a>
    <div>
        <ul>
            @foreach($products->all() as $product)
                <li><a href="{{route('admin::catalog.products.update', ['id' => $product->id])}}">{{$product->name}}</a></li>
            @endforeach
        </ul>
    </div>

@endsection

@section('script')

@endsection