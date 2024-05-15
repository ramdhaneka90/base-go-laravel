@php
    $title = !empty($title) ? $title : null;
    $type = !empty($type) ? $type : 'text';
    $name = !empty($name) ? $name : null;
    $model = !empty($model) ? $model : null;
    $disabled = !empty($disabled) ? $disabled : false;
    $required = !empty($required) ? $required : false;
    $validation = !empty($validation) ? $validation : null;
    $value = !empty($value) ? $value : null;
    $rows = !empty($rows) ? $rows : null;
@endphp

<div class="form-group">
    @if (!empty($title))
        <label>
            {{ $title }}
            @if ($required)
                <sup class="text-danger">*</sup>
            @endif
        </label>
    @endif

    <textarea type="{{ $type }}" class="form-control form-control-sm" placeholder="{{ $title }}"
        @if (!empty($name)) name="{{ $name }}" @endif
        @if (!empty($model)) v-model="{{ $model }}" @endif
        @if (!empty($rows)) rows="{{ $rows }}" @endif
        @if ($required) required @endif @if ($disabled) disabled @endif
        @if ($validation) data-validation="{{ $validation }}" @endif>{{ !empty($value) ? $value : null }}</textarea>

    @if (!empty($name))
        <div class="invalid-feedback-{{ $name }} text-danger mt-1"></div>
    @endif
</div>
