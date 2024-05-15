@php
    $title = $title ?? null;
    $type = $type ?? 'text';
    $name = $name ?? null;
    $class = $class ?? null;
    $model = $model ?? null;
    $disabled = $disabled ?? false;
    $required = $required ?? false;
    $validation = $validation ?? null;
    $value = $value ?? null;
    $readonly = $readonly ?? false;
    $marginBottom = $marginBottom ?? '1rem';
@endphp

<div class="form-group" style="margin-bottom: {{ $marginBottom }}">
    @if (!empty($title))
        <label>
            {{ $title }}
            @if ($required)
                <sup class="text-danger">*</sup>
            @endif
        </label>
    @endif

    <input type="{{ $type }}" class="form-control form-control-sm {{ $class }}"
        placeholder="{{ $title }}" @if (!empty($name)) name="{{ $name }}" @endif
        @if (!empty($model)) v-model="{{ $model }}" @endif
        @if ($required) required @endif @if ($disabled) disabled @endif
        @if ($validation) data-validation="{{ $validation }}" @endif
        @if ($readonly) readonly @endif
        @if ($value) value="{{ $value }}" @endif>

    {{-- Show error from client --}}
    @if (!empty($name))
        <div class="invalid-feedback-{{ $name }} text-danger mt-1"></div>
    @endif

    {{-- Show error from server --}}
    @if ($errors->has($name))
        <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first($name) }}</strong>
        </span>
    @endif
</div>
