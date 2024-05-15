@php
    $title = !empty($title) ? $title : null;
    $colSize = !empty($colSize) ? $colSize : '12';
    $name = !empty($name) ? $name : null;
    $model = !empty($model) ? $model : null;
    $disabled = !empty($disabled) ? $disabled : false;
    $required = !empty($required) ? $required : false;
    $items = !empty($items) ? $items : [];
    $defaultItem = !empty($defaultItem) ? $defaultItem : true;
    $validation = !empty($validation) ? $validation : null;
    $value = !empty($value) ? $value : null;
@endphp

<div class="form-row" style="margin-bottom: 1rem">
    @if (!empty($title))
        <div class="col-12">
            <label>
                {{ $title }}
                @if ($required)
                    <sup class="text-danger">*</sup>
                @endif
            </label>
        </div>
    @endif

    <div class="col-{{ $colSize }}">
        <div class="row">
            @foreach ($items as $item)
                <div class="col-{{ $item['col-size'] }}">
                    <div class="custom-control custom-radio">
                        <input type="radio" class="custom-control-input" id="{{ $item['id'] ?? '' }}"
                            @if (!empty($name)) name="{{ $name }}" @endif
                            @if (!empty($item['value'])) value="{{ $item['value'] }}" @endif
                            @if (!empty($model)) v-model="{{ $model }}" @endif
                            @if ($validation) data-validation="{{ $validation }}" @endif
                            @if ($value && ($value == $item['value'])) selected @endif>
                        <label class="custom-control-label"
                            for="{{ $item['id'] ?? '' }}">{{ $item['title'] ?? '-' }}</label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if (!empty($name))
        <div class="col">
            <div class="invalid-feedback-{{ $name }} text-danger mt-1"></div>
        </div>
    @endif
</div>
