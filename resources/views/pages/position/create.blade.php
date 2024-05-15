@extends('layouts.modal')

@section('title', __('Form Tambah'))

@section('content')
    {{ Form::open(['id' => 'my-form', 'route' => $module . '.store', 'method' => 'post', 'autocomplete' => 'off']) }}
    <div class="modal-body pb-2">
        <div class="form-group row">
            <label for="division_id" class="col-sm-3 col-form-label">Divisi<sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                {{ Form::select('division_id', $options['divisions'], null, ['id' => 'division_id', 'class' => 'form-control select2']) }}
                <div id="error_division_id"></div>
            </div>
        </div>
        <div class="form-group row">
            <label for="name" class="col-sm-3 col-form-label">{{ __('Nama') }}<sup class="text-danger">*</sup></label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="name" id="name">
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
        $(function() {
            initPage();

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
