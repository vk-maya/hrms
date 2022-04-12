@include('layouts.partials.css')
@include('layouts.partials.header')
@include('layouts.partials.sidebar')
<div class="page-content-wrapper">
    <div class="page-content">
        @yield('content')
    </div>
</div>
@include('layouts.partials.header')
@include('layouts.partials.js')