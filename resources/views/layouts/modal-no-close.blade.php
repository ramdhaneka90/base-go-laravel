<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">@yield('title')</h5>
</div>

@yield('content')

{{-- @minify('plugin-scripts') --}}
    @stack('plugin-scripts')
{{-- @endminify --}}

{{-- @minify('custom-scripts') --}}
    @stack('custom-scripts')
{{-- @endminify --}}
