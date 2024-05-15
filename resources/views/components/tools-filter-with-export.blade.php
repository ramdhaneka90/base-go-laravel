<h6 class="m-0 mt-1 float-left">
    {{ isset($title) ? $title : __('Filter') }}
</h6>

<div class="toolsExport btn-group float-right" data-table="{{ $table_id }}">

    <button type="button" class="btn btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bars"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-right">
        <button class="dropdown-item reload-table" type="button"><i class="fas fa-sync-alt"></i> {{ __('Muat ulang') }}</button>
        <button class="dropdown-item reset-filter" type="button"><i class="fas fa-undo"></i> {{ __('Reset Filter') }}</button>
        {{-- @can($module . '-export') --}}
            <hr style="margin: 0;">
            <a href="{{ route($module . ".export-excel", ['code' => $code]) }}" class="dropdown-item export-excel" id="export-excel" type="button"><i class="fas fa-file-excel"></i> {{ __('Export Excel') }}</a>
            <a href="{{ route($module . ".export-pdf", ['code' => $code]) }}" class="dropdown-item export-pdf" id="export-pdf" type="button" target="_blank"><i class="fas fa-file-pdf"></i> {{ __('Export PDF') }}</a>
            <a href="{{ route($module . ".export-xml", ['code' => $code]) }}" class="dropdown-item export-xml" id="export-xml" type="button" target="_blank"><i class="fas fa-file-xml"></i> {{ __('Export XML') }}</a>
            <a href="{{ route($module . ".export-txt", ['code' => $code]) }}" class="dropdown-item export-txt" id="export-txt" type="button" target="_blank"><i class="fas fa-file-txt"></i> {{ __('Export TXT') }}</a>
        {{-- @endcan --}}
    </div>
</div>
