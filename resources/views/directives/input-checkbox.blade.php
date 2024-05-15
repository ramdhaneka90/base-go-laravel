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
    $itemValue = !empty($itemValue) ? $itemValue : null;
    $itemTitle = $itemTitle ?? null;
    $value = $value ?? null;
    $id = $id ?? null;
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
        <div class="cb-dynamic-label custom-control custom-toggle custom-toggle-sm mt-1">
            <input type="checkbox" class="custom-control-input"
                @if (!empty($id)) id="{{ $id }}" @endif
                @if (!empty($name)) name="{{ $name }}" @endif
                @if (!empty($itemValue)) value="{{ $itemValue }}" @endif
                @if ($validation) data-validation="{{ $validation }}" @endif
                @if (!empty($value) && $itemValue == $value) checked="checked" @endif
                data-text-on="{{ $itemTitle }}" data-text-off="{{ $itemTitle }}">
            <label class="custom-control-label text-muted" @if(!empty($id)) for="{{ $id }}" @endif></label>
        </div>
    </div>

    @if (!empty($name))
        <div class="col">
            <div class="invalid-feedback-{{ $name }} text-danger mt-1"></div>
        </div>
    @endif
</div>
