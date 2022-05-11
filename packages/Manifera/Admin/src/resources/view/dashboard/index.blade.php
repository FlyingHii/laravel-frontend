@extends('layouts.master')
@section('title','Dashboard')

@section('content')
    <div >
        <div >
            <h1>Dashboard</h1>
        </div>
        <a href="{{route('admin::catalog.products')}}">Products</a>
    </div>
@endsection

@section('script')

@endsection