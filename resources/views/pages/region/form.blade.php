@extends('layouts.modal')

@section('title', __('Form ' . (empty($data) ? 'Tambah' : 'Edit')))

@section('content')
    {{ Form::open([
        'id' => 'my-form',
        'route' => !empty($data) ? [$module . '.update', encrypt($data->id)] : [$module . '.store'],
        'method' => !empty($data) ? 'put' : 'post',
        'autocomplete' => 'off',
    ]) }}
    <div class="modal-body pb-2">
        @inputText(['title' => 'Nama', 'name' => 'name', 'required' => true, 'validation' => 'required', 'value' => $data->name ?? null])
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">{{ __('Tutup') }}</button>
        <button type="submit" class="btn btn-primary btn-sm">{{ __('Simpan') }}</button>
    </div>
    {!! Form::close() !!}
@endsection

@push('custom-scripts')
    <script type="text/javascript">
        $(function() {
            initPage();

            formSubmit('form#my-form', function(id) {
                $(id).myAjax({
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
