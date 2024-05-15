<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-1">
            <div class="col-sm-6">
                <h5 class="m-0">{!! isset($pageTitle) ? $pageTitle : '' !!}</h5>
            </div><!-- /.col -->
            <div class="col-sm-6">
                @php
                    $i = 0;
                @endphp
                @if (isset($breadcrumb))
                    <ol class="breadcrumb float-sm-right">
                        @foreach ($breadcrumb as $b)
                            @if (!empty($b))
                                @if ($i == 0)
                                    <li class="breadcrumb-item"><a href="">{{ $b }}</a></li>
                                @else
                                    <li class="breadcrumb-item active">{{ $b }}</li>
                                @endif
                            @endif
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </ol>
                @endif
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
