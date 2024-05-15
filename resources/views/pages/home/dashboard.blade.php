@extends('layouts.app')

@push('plugin-styles')
@endpush

@section('content')
    <div class="row">
        <div class="col-8 offset-2 grid-margin stretch-card">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="row align-items-start">
                        <div class="col-md-12">
                            @include('components.info')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
