<div class="table-responsive">
<table id="{{ isset($id) ? $id :  'dt-basic' }}"
       class="{{ isset($class) ? $class :  'table table-border table-simple wrap' }} "
       style="{{ isset($style) ? $style :  'margin-top: 0 !important; padding: 0.2em !important;max-width:100%;' }} "
       data-table-source="{{ isset($data_source) ? $data_source : '' }}"
       data-table-filter="{{ isset($form_filter) ? $form_filter :  '#form-filter' }}"
       data-auto-filter="true">
    <thead>
	    <tr>
            @isset($delete_action)
            <th class="toolsTable no-sort p-1">
                <div class="btn-group">
                    <button type="button" class="btn btn-outline" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </button>

                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#btn-checked-all"><i class="fas fa-check-circle"></i> {{ __('Pilih semua') }}</a>
                        <a class="dropdown-item" href="#btn-unchecked-all"><i class="fas fa-circle"></i> {{ __('Batalkan semua') }}</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item btn-delete-selected" href="{{isset($delete_action) ? $delete_action : ''}}"><i class="fas fa-trash"></i> {{ __('Hapus yang dipilih') }}</a>
                    </div>
                </div>
            </th>
            @endisset
	    	@if (isset($header) && count($header) > 0)
	    		@foreach($header as $key => $value)
		    		<th class="no-sort">{{ strtoupper($value) }}</th>
		    	@endforeach
            @endif

            @isset($delete_action)
                <th class="no-sort">{{ __('Aksi') }}</th>
            @endisset
	    </tr>
    </thead>
</table>
</div>
