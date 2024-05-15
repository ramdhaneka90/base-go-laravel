@extends('layout.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin mb-2">
        <div>
            <h5 class="mb-3 mb-md-0">{{ $pageTitle }} {{ $pageSubTitle }}</h5>
        </div>
    </div>
    <!-- Default Light Table -->
    <div class="row">
        <div class="col">
            <div class="card card-small mb-1">
                <div class="card-header border-bottom pt-2 pt-1">
                    @include('components.tools-filter', ['table_id' => '#main-table'])
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            {{ Form::open(['id' => 'form-filter', 'autocomplete' => 'off']) }}
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">{{ __('Role') }}</label>
                                        {!! Form::select('role_id', $options_role, null, [
                                            'class' => 'form-control select2 filter-select form-control form-control-sm',
                                        ]) !!}
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
                        'header' => ['Nama', 'Unit Kerja'],
                        'data_source' => route($module . '.data'),
                        'delete_action' => route($module . '.destroys'),
                    ])
                </div>
            </div>
        </div>
    </div>
    <!-- End Default Light Table -->
@endsection

@push('plugin-scripts')
    <script type="text/javascript">
        var oTable = $('#main-table').myDataTable({
            buttons: [{
                id: 'add',
                url: '{{ route($module . '.create') }}',
                modal: '#modal-lg'
            }],
            actions: [{
                id: 'edit',
                url: '{{ route($module . '.edit', ['__grid_doc__']) }}',
                modal: '#modal-lg'
            }],
            columns: [{
                    data: 'checkbox'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'unitKerja',
                    name: 'unitKerja'
                },
                {
                    data: 'action',
                    className: 'text-center'
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
            customRow: function(row, data) {}
        });
    </script>
    <script type="text/javascript">
        $(function() {
            initPage();
            initDatatableTools($('#main-table'), oTable);
        })
    </script>
@endpush
