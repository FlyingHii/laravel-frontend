<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
</head>
<body>
@section('sidebar')
    This is the master sidebar.
@show

<div class="container">
    @include('catalog::product.item')
</div>
</body>
</html>