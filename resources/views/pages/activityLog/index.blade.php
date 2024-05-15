@extends('layouts.app')
@section('content')
    <!-- Default Light Table -->
    <div class="row">
        <div class="col">
            <div class="card card-small mb-1">
                <div class="card-header border-bottom py-2">
                    @include('components.tools-filter', ['table_id' => '#main-table'])
                </div>
                <div class="card-body pb-2 pt-2">
                    <div class="row">
                        <div class="col">
                            {{ Form::open(['id' => 'form-filter', 'autocomplete' => 'off']) }}
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-group mb-1">
                                        <label for="keyword" class="col-form-label">{{ __('Keyword') }}</label>
                                        <input type="text" class="form-control filter-select form-control-sm"
                                            name="keyword" id="keyword" placeholder="Keyword">
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
                        'header' => ['User', 'Aksi', 'Tgl Aktifitas'],
                        'data_source' => route('activitylog.data'),
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection
@push('plugin-scripts')
    <script type="text/javascript">
        var oTable = $('#main-table').myDataTable({
            columns: [{
                    data: 'user.name',
                    name: 'user.name'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    render: function(data, type, row) {
                        return moment(row.created_at).format('DD-MM-YYYY H:m:s');
                    }
                },
            ],
            onDraw: function() {
                initModalAjax('[data-toggle="modal-edit"]');
                initModalAjax('[data-toggle="modal-detail"]');
                initDatatableAction($(this), function() {
                    oTable.reload();
                });
            },
            onComplete: function() {
                initModalAjax();
            },
            customRow: function(row, data) {}
        });

        $(function() {
            initPage();
            initDatatableTools($('#main-table'), oTable);
        })
    </script>
@endpush
