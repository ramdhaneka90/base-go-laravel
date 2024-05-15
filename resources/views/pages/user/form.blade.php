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
        @inputText(['title' => 'Nama', 'name' => 'name', 'validation' => 'required', 'value' => $data->name ?? null])
        @inputText(['title' => 'Email', 'name' => 'email', 'validation' => 'required|email', 'value' => (!empty($data->email) && $data->email != '-' ? $data->email : null)])
        @inputText(['title' => 'Username', 'name' => 'username', 'validation' => 'required', 'readonly' => !empty($data->username), 'value' => $data->username ?? null])
        @inputOption(['title' => 'Peran', 'name' => 'roles[]', 'items' => $options['roles'], 'class' => 'select2', 'value' => $role->name ?? null])
        @inputOption(['title' => 'Jabatan', 'name' => 'position', 'items' => $options['positions'], 'value' => $data->position_id ?? null])
        @inputCheckbox(['title' => 'Status', 'name' => 'status', 'id' => 'status', 'itemValue' => '1', 'itemTitle' => 'Aktif', 'value' => $data->status ?? '0'])
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">{{ __('Tutup') }}</button>
        <button type="submit" class="btn btn-primary btn-sm">{{ __('Simpan') }}</button>
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
