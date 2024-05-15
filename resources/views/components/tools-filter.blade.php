<h6 class="m-0 mt-1 float-left">
    {{ isset($title) ? $title : __('Filter') }}
</h6>

<div class="toolsFilter btn-group float-right" data-table="{{ $table_id }}">

    <button type="button" class="btn btn-xs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-bars"></i>
    </button>
    <div class="dropdown-menu dropdown-menu-right">
        <button class="dropdown-item reload-table" type="button"><i class="fas fa-sync-alt"></i> {{ __('Muat ulang') }}</button>
        <button class="dropdown-item reset-filter" type="button"><i class="fas fa-undo"></i> {{ __('Reset Filter') }}</button>
    </div>
</div>
