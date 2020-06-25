<!DOCTYPE html>
<html lang="en">

@section('head')

    @include('partials.head')

@show

@section('body')

    <body>

        @include('partials.header')

{{--        content of the page--}}
        @yield('content')

        @include('partials.footer')

        @include('partials.jQueryPlugins')

    </body>
@show

</html>
