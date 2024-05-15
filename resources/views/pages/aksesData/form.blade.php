@extends('layout.modal')

@section('title', __('Form Edit'))

@section('content')
    {{ Form::open(['id' => 'my-form', 'route' => [$module . '.update', encrypt($data->id)], 'method' => 'put', 'autocomplete' => 'off']) }}
    <div class="modal-body pb-2">
        <div class="form-group m-0 row">
            <label for="name" class="col-sm-3 col-form-label">{{ __('Role') }}<sup>*</sup></label>
            <div class="col-sm-9">
                {!! Form::select('role_id', $options_role, $data->id, ['class' => 'form-control select2']) !!}
            </div>
        </div>
        <div class="form-group m-0 row">
            <label for="code" class="col-sm-3 col-form-label">{{ __('Akses Data') }}<sup>*</sup></label>
            <div class="col-sm-9">
                <div class="btn-group btn-group-sm mb-1" role="Table row actions">
                    <button type="button" class="btn btn-xs btn-success" id="selected-all">Pilih Semua</button>
                </div>
                {!! Form::select(
                    'unit_kerja_id[]',
                    $options_unit_kerja,
                    $data->aksesdata()->pluck('id')->toArray(),
                    ['multiple' => true, 'id' => 'unit_kerja', 'class' => 'form-control select2-unitkerja'],
                ) !!}
                <div id="error_unit_kerja_id"></div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Tutup') }}</button>
        <button type="submit" class="btn btn-primary">{{ __('Simpan') }}</button>
    </div>
    {!! Form::close() !!}
@endsection

@push('plugin-scripts')
    <script type="text/javascript">
        $("#selected-all").click(function() {
            $("#unit_kerja > option").prop("selected", "selected");
            $("#unit_kerja").trigger("change");
        });
        $(function() {
            initPage();

            $('.select2-unitkerja').select2({
                width: '100%',
                theme: "bootstrap",
                placeholder: 'Pilih Unit Kerja',
                allowClear: true
            });

            $('form#my-form').submit(function(e) {
                e.preventDefault();
                $(this).myAjax({
                    waitMe: 'body',
                    success: function(data) {
                        $('.modal').modal('hide');
                        oTable.reload();
                    }
                }).submit();
            });
        })
    </script>
@endpush
