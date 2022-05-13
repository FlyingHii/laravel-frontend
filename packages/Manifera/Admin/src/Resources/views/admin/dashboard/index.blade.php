@extends('admin::layouts.master')
@section('page_title')
{{ __('admin::dashboard.title') }}
@stop
@section('content-wrapper')
    <div >
        <div >
            <h1>Dashboard</h1>
        </div>
        <a href="{{route('catalog::admin.products')}}">Products</a>
    </div>

@stop
@section('script')

@endsection
