@extends('layouts.master')
@section('title')
    {{'Create Product'}}
@stop

@section('content')
    @include('catalog::admin.product.ui.form', ['action' => route('catalog::admin.product.action.create')])
@endsection

@section('script')

@endsection
