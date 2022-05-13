<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
</head>
<body>

<h1>
    @yield('title')
</h1>
@section('sidebar')
    This is the master sidebar.
@show

<div class="container">
    @yield('content')
</div>
@yield('script')
</body>
</html>
