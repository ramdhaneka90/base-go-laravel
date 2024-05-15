@extends('layouts.master')

@section('content')
<div class="page-content d-flex align-items-center justify-content-center">

  <div class="row w-100 mx-0 auth-page mt-5">
    <div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center">
      <h1 class="font-weight-bold mb-22 mt-2 tx-80 text-muted"><i class="fas fa-ban text-danger" style="font-size: 35px;"></i> 419</h1>
      <h4 class="mb-2">Halaman tidak valid</h4>
      <h6 class="text-muted mb-3 text-center">Oopps!! Halaman yang anda tuju tidak valid.</h6>
      <br>
      <a href="{{ url('/') }}" class="btn btn-primary">Kembali ke home</a>
    </div>
  </div>

</div>
@endsection