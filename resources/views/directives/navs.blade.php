<ul class="nav nav-tabs" id="navs" role="tablist">
    @foreach ($data as $index => $item)
        <li class="nav-item">
            <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="{{ $index }}-tab" data-toggle="tab"
                href="#tabContent{{ $index }}" role="tab" aria-controls="{{ $index }}"
                @if ($index == 0) aria-selected="true" @endif>{{ $item['title'] }}</a>
        </li>
    @endforeach
</ul>
<div class="tab-content" id="navsContent">
    @foreach ($data as $index => $item)
        <div class="tab-pane fade show py-3 {{ $index == 0 ? 'active' : '' }}" id="tabContent{{ $index }}" role="tabpanel"
            aria-labelledby="{{ $index }}-tab">
            @include('pages.' . $module . '.' . $item['path_content'])
        </div>
    @endforeach
</div>
