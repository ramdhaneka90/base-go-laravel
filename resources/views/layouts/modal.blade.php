<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLongTitle">@yield('title')</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>

@yield('content')

{{-- @minify('plugin-scripts') --}}
    @stack('plugin-scripts')
{{-- @endminify --}}

{{-- @minify('custom-scripts') --}}
    @stack('custom-scripts')
{{-- @endminify --}}
