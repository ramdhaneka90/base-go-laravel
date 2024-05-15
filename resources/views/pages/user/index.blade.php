@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            <div class="card card-small mb-2">
                <div class="card-header border-bottom py-2">
                    @include('components.tools-filter', ['table_id' => '#main-table'])
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            {{ Form::open(['id' => 'form-filter', 'autocomplete' => 'off']) }}
                            <div class="form-row">
                                <div class="col-md-6">
                                    @inputText(['title' => 'Nama / Username', 'name' => 'name'])
                                </div>
                                <div class="col-md-6">
                                    @inputOption(['title' => 'Area', 'name' => 'area', 'class' => 'select2 filter-select', 'items' => $options['areas']])
                                </div>
                                <div class="col-md-6">
                                    @inputOption(['title' => 'Jabatan', 'name' => 'position', 'class' => 'select2 filter-select', 'items' => $options['positions']])
                                </div>
                                <div class="col-md-6">
                                    @inputOption(['title' => 'Peran', 'name' => 'role', 'class' => 'select2 filter-select', 'items' => $options['roles']])
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="filter_status">Status</label>
                                        <select name="status" class="select2 filter-select form-control form-control-sm"
                                            data-search="false">
                                            <option value="">Semua</option>
                                            <option value="1">Aktif</option>
                                            <option value="0">Tidak Aktif</option>
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
                        'header' => ['No', 'Nama', 'Username', 'Jabatan', 'Peran', 'Status'],
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
                className: 'btn btn-sm btn-primary',
                url: '{{ route($module . '.create') }}',
                modal: '#modal-md'
            }],
            actions: [{
                    id: 'edit',
                    className: 'btn btn-sm btn-light',
                    url: '{{ route($module . '.edit', ['__grid_doc__']) }}',
                    modal: '#modal-md'
                },
                {
                    id: 'delete',
                    className: 'btn btn-sm btn-danger btn-delete',
                    url: '{{ route($module . '.destroy', ['id' => '__grid_doc__']) }}'
                },
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
                    width: '30px',
                    className: 'text-center'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'username',
                    name: 'username',
                    width: '150px',
                    className: 'text-center',
                },
                {
                    data: 'position',
                    name: 'position',
                    width: '150px',
                    className: 'text-center',
                },
                {
                    data: 'roles',
                    name: 'roles',
                    width: '150px',
                    className: 'text-center',
                },
                {
                    data: 'status',
                    name: 'status',
                    width: '80px',
                    className: 'text-center',
                },
                {
                    data: 'action',
                    className: 'text-center',
                    width: '150px',
                }
            ],
            onDraw: function() {
                initModalAjax('[data-toggle="modal-edit"]');
                initDatatableAction($(this), function() {
                    oTable.reload();
                });
            },
            onComplete: function() {
                initModalAjax();
            },
            customRow: function(row, data) {
                if (data.email_verified_at != '') {
                    if (data.status == '1') {
                        $('td:eq(6)', row).html(__('Aktif')).addClass('text-success');
                    } else {
                        $('td:eq(6)', row).html(__('Tidak Aktif')).addClass('text-danger');
                    }
                } else {
                    $('td:eq(6)', row).html(__('Belum Aktif')).addClass('text-danger');
                }
            }
        });

        $(function() {
            initPage();
            initDatatableTools($('#main-table'), oTable);
        })
    </script>
@endpush
