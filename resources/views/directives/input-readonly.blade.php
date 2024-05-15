@php
    $title = !empty($title) ? $title : null;
    $text = !empty($text) ? $text : null;
    $margin = $margin ?? '1rem';
    $colSize = $colSize ?? '12';
@endphp

<div class="form-row" style="margin-bottom: {{ $margin }}">
    @if (!empty($title))
        <div class="col-12">
            <label>{{ $title }}</label>
        </div>
    @endif
    <div class="col-{{ $colSize }}">
        <input type="text" class="form-control form-control-sm bg-light" value="{{ $text }}" readonly>
    </div>
</div>
