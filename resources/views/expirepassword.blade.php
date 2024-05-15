@extends('layout.app')

@push('plugin-styles')
  <link href="{{ asset('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin mb-2">
  <div>
    <h4 class="mb-2 mb-md-0">Beranda</h4>
  </div>
</div>

<div class="row">
  <div class="col-12 col-xl-12 stretch-card">
    <div class="row flex-grow">
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline">
              <h6 class="card-title mb-0">Frekuensi Kejadian {{ date('M Y') }}</h6>
            </div>
            <div class="row">
              <div class="col-6 col-md-12 col-xl-5">
                <h3 class="mb-2">{{ $countCurrentData }}</h3>
                <div class="d-flex align-items-baseline">
                  <p class="{!! ($trendFrekuensi > 0) ? 'text-danger' : 'text-success' !!}">
                  <span>{!! ($trendFrekuensi > 0) ? '+'.$trendFrekuensi : '-'.$trendFrekuensi !!}%</span>
                    <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                  </p>
                </div>
              </div>
              <div class="col-6 col-md-12 col-xl-7">
                <div id="frekuensi" class="mt-md-3 mt-xl-0"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline">
              <h6 class="card-title mb-0">Total Kerugian {{ date('M Y') }}</h6>
            </div>
            <div class="row">
              <div class="col-6 col-md-12 col-xl-5">
                <h5 class="mb-2">{{ App\Helpers\Common::formatNumber($sumCurrentData,'') }}</h5>
                <div class="d-flex align-items-baseline">
                  <p class="{!! ($trendDampak > 0) ? 'text-danger' : 'text-success' !!}">
                  <span>{!! ($trendDampak >= 0) ? '+'.$trendDampak : '-'.$trendDampak !!}%</span>
                    <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                  </p>
                </div>
              </div>
              <div class="col-6 col-md-12 col-xl-7">
                <div id="nominalKerugian" class="mt-md-3 mt-xl-0"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-baseline">
            <h6 class="card-title mb-0">Potensi Kerugian {{ date('M Y') }}</h6>
            </div>
            <div class="row">
              <div class="col-6 col-md-12 col-xl-5">
                <h5 class="mb-2">{{ App\Helpers\Common::formatNumber($sumPotensialCurrentData,'') }}</h5>
                <div class="d-flex align-items-baseline">
                  <p class="{!! ($trendPotensialDampak > 0) ? 'text-danger' : 'text-success' !!}">
                  <span>{!! ($trendPotensialDampak >= 0) ? '+'.$trendPotensialDampak : '-'.$trendPotensialDampak !!}%</span>
                    <i data-feather="arrow-up" class="icon-sm mb-1"></i>
                  </p>
                </div>
              </div>
              <div class="col-6 col-md-12 col-xl-7">
                <div id="chartNominalPotensiKerugian" class="mt-md-3 mt-xl-0"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> <!-- row -->

<div class="row">
  <div class="col-12 col-xl-12 grid-margin stretch-card">
    <div class="card overflow-hidden">
      <div class="card-body">
        <div class="row align-items-start mb-2">
          <div class="col-md-12">
            @include('components.information')
          </div>
        </div>
      </div>
    </div>
  </div>
</div> <!-- row -->

@endsection

@push('plugin-scripts')
  <script src="{{ asset('assets/plugins/apexcharts/apexcharts.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script type="text/javascript">
    var data = {!! json_encode($chartFrekuensi['data']) !!};
    var category = {!! json_encode($chartFrekuensi['category']) !!};
    var dataNominal = {!! json_encode($chartNominal['data']) !!};
    var categoryNominal = {!! json_encode($chartNominal['category']) !!};
    var dataPotensiKerugian = {!! json_encode($chartNominalPotensiKerugian['data']) !!};
    var categoryPotensiKerugian = {!! json_encode($chartNominalPotensiKerugian['category']) !!};
    
    $(function(){
        initPage();
        initModalAjax();
    })
</script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush
