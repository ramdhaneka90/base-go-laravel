@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card card-small mb-1">
                <div class="card-header border-bottom pt-1 pb-1">
                    @include('components.tools-filter', ['table_id' => '#main-table'])
                </div>
                <div class="card-body pb-1">
                    <div class="row">
                        <div class="col">
                            {{ Form::open(['id' => 'form-filter', 'autocomplete' => 'off']) }}
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">{{ __('Nama') }}</label>
                                        <input type="text"
                                            class="form-control filter-select form-control form-control-sm" name="name"
                                            id="name" placeholder="{{ __('Nama') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">{{ __('Status') }}</label>
                                        <select name="status" class="select2 filter-select form-control form-control-sm"
                                            data-search="false">
                                            <option value="">{{ __('Semua') }}</option>
                                            <option value="1">{{ __('Aktif') }}</option>
                                            <option value="0">{{ __('Tidak Aktif') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="card card-small mb-4">
                <div class="card-body">
                    @include('components.datatables', [
                        'id' => 'main-table',
                        'form_filter' => '#form-filter',
                        'header' => ['No', 'Code', 'Nama', 'Keterangan', 'Status'],
                        'data_source' => route($module . '.data'),
                        'delete_action' => route($module . '.destroys'),
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
    <script type="text/javascript">
        var oTable = $('#main-table').myDataTable({
            buttons: [{
                id: 'add',
                className: 'btn btn-primary btn-sm',
                url: '{{ route($module . '.create') }}',
                modal: false,
            }],
            actions: [{
                    id: 'edit',
                    className: 'btn btn-light btn-sm',
                    url: '{{ route($module . '.edit', ['__grid_doc__']) }}',
                    modal: false
                },
                {
                    id: 'delete',
                    className: 'btn btn-danger btn-sm',
                    url: '{{ route($module . '.destroy', ['id' => '__grid_doc__']) }}'
                }
            ],
            columns: [{
                    data: 'checkbox',
                    width: '30px',
                },
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    width: '50px',
                    className: 'text-center'
                },
                {
                    data: 'code',
                    name: 'code',
                    width: '80px',
                    className: 'text-center',
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'status',
                    name: 'status',
                    width: '50px',
                    className: 'text-center',
                },
                {
                    data: 'action',
                    className: 'text-center',
                    width: '120px',
                }
            ],
            onDraw: function() {
                initDatatableAction($(this), function() {
                    oTable.reload();
                });
            },
            onComplete: function() {
                initModalAjax();
            },
            customRow: function(row, data) {
                if (data.status == '1') {
                    $('td:eq(5)', row).html(__('Aktif')).addClass('text-success');
                } else {
                    $('td:eq(5)', row).html(__('Tidak Aktif')).addClass('text-danger');
                }
            }
        });
        $(function() {
            initPage();
            initDatatableTools($('#main-table'), oTable);
        });
    </script>
@endpush
