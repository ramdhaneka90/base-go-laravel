@extends((request()->get('password_expired') || request()->get('password_reset')) ? 'layout.modal-no-close' : 'layout.modal')
@section('title',  __('Ganti Password'))

@section('content')
    {{ Form::open(['id' => 'my-form', 'route' => 'admin.savechangepassword', 'method' => 'post', 'autocomplete' => 'off']) }}
    <div class="modal-body pb-2">
        @if(request()->get('password_expired') && !request()->get('password_reset'))
            <div class="alert alert-danger">
                {{ __('passwords.password_expired') }} <br>
            </div>
        @elseif(request()->get('password_expired') && request()->get('password_reset'))
            <div class="alert alert-danger">
                {{ __('passwords.password_reset') }} <br>
            </div>
       @endif
        <div class="form-group m-0 row p-0">
            <label for="password" class="col-sm-4 col-form-label">{{ __('Password Baru') }} <i rel="tooltip" title="Password kombinasi harus mengandung huruf besar[A..Z], huruf kecil [a..z], Angka[0..9] dan Karakter (!@$#%*&^)" class="fas fa-question-circle"></i><sup class="text-danger">*</sup></label>
            <div class="col-sm-8">
                <input type="password" class="form-control" name="password" id="password">
            </div>
        </div>
        <div class="form-group m-0 row p-0">
            <label for="password_confirmation" class="col-sm-4 col-form-label">{{ __('Konfirm Password') }}<sup class="text-danger">*</sup></label>
            <div class="col-sm-8">
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
            </div>
        </div>
        <div class="form-group m-0 row p-0">
            <label for="old_password" class="col-sm-4 col-form-label">{{ __('Password Lama') }}<sup class="text-danger">*</sup></label>
            <div class="col-sm-8">
                <input type="password" class="form-control" name="old_password" id="old_password">
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
  $(function(){
    initPage();

    $('form#my-form').submit(function(e){
      e.preventDefault();
      $(this).myAjax({
          waitMe: 'body',
          success: function (data) {
              $('.modal').modal('hide');
          }
      }).submit({confirm:{
          title: 'Yakin Password akan diubah?',
          text: __('Data Password akan disimpan')
        }});
    });

  })
</script>
@endpush
