<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <title>@yield('page_title')</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

{{--        @if ($favicon = core()->getConfigData('general.design.admin_logo.favicon'))--}}
{{--            <link rel="icon" sizes="16x16" href="{{ \Illuminate\Support\Facades\Storage::url($favicon) }}" />--}}
{{--        @else--}}
{{--            <link rel="icon" sizes="16x16" href="{{ asset('vendor/webkul/ui/assets/images/favicon.ico') }}" />--}}
{{--        @endif--}}

        <link rel="stylesheet" href="{{ asset('vendor/webkul/ui/assets/css/ui.css?v=10') }}">
        <link rel="stylesheet" href="{{ asset('vendor/webkul/admin/assets/css/admin.css?v=10') }}">
        <link rel="stylesheet" href="{{ asset('vendor/webkul/admin/assets/css/admin-custom.css?v=10') }}">

        @yield('head')

        @yield('css')

{{--        {!! view_render_event('bagisto.admin.layout.head') !!}--}}

    </head>

    <body
{{--        @if (core()->getCurrentLocale() && core()->getCurrentLocale()->direction == 'rtl') class="rtl" @endif --}}
    style="scroll-behavior: smooth;">
{{--        {!! view_render_event('bagisto.admin.layout.body.before') !!}--}}

        <div id="app">
            <h1>@yield('page_title')</h1>
            <flash-wrapper ref='flashes'></flash-wrapper>

{{--            {!! view_render_event('bagisto.admin.layout.nav-top.before') !!}--}}

{{--            @include ('admin::layouts.nav-top')--}}

{{--            {!! view_render_event('bagisto.admin.layout.nav-top.after') !!}--}}


{{--            {!! view_render_event('bagisto.admin.layout.nav-left.before') !!}--}}

{{--            @include ('admin::layouts.nav-left')--}}

{{--            {!! view_render_event('bagisto.admin.layout.nav-left.after') !!}--}}


            <div class="content-container">

{{--                {!! view_render_event('bagisto.admin.layout.content.before') !!}--}}

                @yield('content-wrapper')

{{--                {!! view_render_event('bagisto.admin.layout.content.after') !!}--}}

            </div>

        </div>

        <script type="text/javascript">
            window.flashMessages = [];

            @foreach (['success', 'warning', 'error', 'info'] as $key)
                @if ($value = session($key))
                    window.flashMessages.push({'type': 'alert-{{ $key }}', 'message': "{!! $value !!}" });
                @endif
            @endforeach

            window.serverErrors = [];
            @if (isset($errors))
                @if (count($errors))
                    window.serverErrors = @json($errors->getMessages());
                @endif
            @endif
        </script>

        @stack('scripts')

{{--        {!! view_render_event('bagisto.admin.layout.body.after') !!}--}}

        <div class="modal-overlay"></div>
    </body>
</html>
