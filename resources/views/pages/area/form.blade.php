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
        @inputOption(['title' => 'Wilayah', 'name' => 'region_id', 'required' => true, 'validation' => 'required', 'items' => $options['regions'], 'value' => $data->region_id ?? null])
        @inputText(['title' => 'Nama', 'name' => 'name', 'required' => true, 'validation' => 'required', 'value' => $data->name ?? null])

        <div class="row">
            <div class="col">
                @inputText(['title' => 'Latitude', 'name' => 'latitude', 'required' => true, 'validation' => 'required', 'value' => $data->latitude ?? null])
            </div>
            <div class="col">
                @inputText(['title' => 'Longitude', 'name' => 'longitude', 'required' => true, 'validation' => 'required', 'value' => $data->longitude ?? null])
            </div>
        </div>

        @inputOption(['title' => 'Divisi & Jabatan', 'name' => 'positions[]', 'class' => 'select2', 'multiple' => true, 'defaultItem' => false, 'items' => $options['positions'], 'value' => !empty($data->positions) ? $data->positions->pluck('id')->toArray() : []])
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
