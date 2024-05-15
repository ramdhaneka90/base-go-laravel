@php
    $title = !empty($title) ? $title : null;
    $name = !empty($name) ? $name : null;
    $model = !empty($model) ? $model : null;
    $disabled = !empty($disabled) ? $disabled : false;
    $required = !empty($required) ? $required : false;
    $validation = !empty($validation) ? $validation : null;
    $value = !empty($value) ? $value : null;
    $margin = $margin ?? '1rem';
@endphp

<div class="form-group" style="margin-bottom: {{ $margin }}">
    @if (!empty($title))
        <label>
            {{ $title }}
            @if ($required)
                <sup class="text-danger">*</sup>
            @endif
        </label>
    @endif

    <div class="custom-file">
        <input type="file" class="custom-file-input form-control-sm" id="customFile" 
        @if (!empty($name)) name="{{ $name }}" @endif
        @if (!empty($model)) v-model="{{ $model }}" @endif
        @if ($required) required @endif @if ($disabled) disabled @endif
        @if ($validation) data-validation="{{ $validation }}" @endif
        @if ($value) value="{{ $value }}" @endif>
        <label class="custom-file-label col-form-label-sm" for="customFile">Pilih File</label>
    </div>

    @if (!empty($name))
        <div class="invalid-feedback-{{ $name }} text-danger mt-1"></div>
    @endif
</div>
