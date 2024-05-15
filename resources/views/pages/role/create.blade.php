@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col">
            {{ Form::open(['id' => 'my-form', 'route' => $module . '.store', 'method' => 'post', 'autocomplete' => 'off']) }}
            <div class="card card-small mb-4">
                <div class="card-header border-bottom py-3">
                    <h6 class="m-0">{{ __('Form Tambah') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group row">
                                <label for="code" class="col-sm-3 col-form-label">{{ __('Kode') }}<sup>*</sup></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" name="code"
                                        id="code">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-sm-3 col-form-label">{{ __('Nama') }}<sup>*</sup></label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control form-control-sm" name="name"
                                        id="name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="description" class="col-sm-3 col-form-label">{{ __('Keterangan') }}</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control form-control-sm" name="description" id="description"></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">{{ __('Status') }}</label>
                                <div class="col-sm-9">
                                    <div class="cb-dynamic-label custom-control custom-toggle custom-toggle-sm mb-1 mt-1">
                                        <input type="checkbox" id="status" name="status" value="1"
                                            class="custom-control-input" checked="checked"
                                            data-text-on="{{ __('Aktif') }}" data-text-off="{{ __('Tidak Aktif') }}">
                                        <label class="custom-control-label text-muted" for="status"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @include('pages.' . $module . '.permission')
                </div>
                <div class="card-footer border-top">
                    <div class="row">
                        <div class="col text-right">
                            <a href="{{ route($module . '.index') }}"
                                class="btn btn-sm btn-secondary">{{ __('Kembali') }}</a>
                            <button type="submit" class="btn btn-sm btn-primary">{{ __('Simpan') }}</button>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@push('plugin-scripts')
    <script src="{{ asset(mix('plugins/js/handlebars/handlebars.min.js')) }}"></script>
    <script src="{{ asset(mix('plugins/js/nestable2/jquery.nestable.min.js')) }}"></script>
@endpush

@push('custom-scripts')
    <script type="text/javascript">
        $(function() {
            initPage();

            $('form#my-form').submit(function(e) {
                e.preventDefault();
                $(this).myAjax({
                    waitMe: 'body',
                    success: function(data) {
                        window.location = '{{ route($module . '.index') }}'
                    },
                    error: function(data) {
                        set_validation_message(data);
                    }
                }).submit();
            });
        })
    </script>
@endpush
