@php
    $title = $title ?? null;
    $colSize = $colSize ?? '12';
    $class = $class ?? null;
    $name = $name ?? null;
    $model = $model ?? null;
    $disabled = $disabled ?? false;
    $required = $required ?? false;
    $items = $items ?? [];
    $defaultItem = $defaultItem ?? true;
    $validation = $validation ?? null;
    $value = $value ?? null;
    $multiple = $multiple ?? false;
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
        <select class="form-control form-control-sm {{ $class }}"
            @if (!empty($name)) name="{{ $name }}" @endif
            @if ($required) required @endif @if ($disabled) disabled @endif
            @if (!empty($model)) v-model="{{ $model }}" @endif
            @if ($multiple) multiple @endif
            @if ($validation) data-validation="{{ $validation }}" @endif>
            @if ($defaultItem)
                <option value="">- Pilih -</option>
            @endif

            @foreach ($items as $key => $item)
                <option value="{{ $key }}" 
                    @if ($multiple == false && ($value != null && $value == $key)) selected @endif
                    @if ($multiple == true && in_array($key, $value)) selected @endif>
                    {{ $item }}
                </option>
            @endforeach
        </select>
    </div>

    @if (!empty($name))
        <div class="col">
            <div class="text-danger invalid-feedback-{{ $name }} text-danger mt-1"></div>
        </div>
    @endif
</div>
