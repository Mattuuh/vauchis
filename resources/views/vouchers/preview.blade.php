@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-center py-4">
    <div class="voucher-preview"
         style="
            position: relative;
            width: {{ $config['canvas']['width'] ?? 800 }}px;
            height: {{ $config['canvas']['height'] ?? 500 }}px;
            background-image: url('{{ asset($plantilla->vpl_fondo_path) }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            overflow: hidden;
         ">

        @foreach(($config['fields'] ?? []) as $field)
            @php
                $value = $field['text'] ?? ($data[$field['key']] ?? '');
                $style = $field['style'] ?? [];
            @endphp

            <div style="
                position: absolute;
                left: {{ $field['x'] ?? 0 }}px;
                top: {{ $field['y'] ?? 0 }}px;
                width: {{ $field['width'] ?? 100 }}px;
                height: {{ $field['height'] ?? 30 }}px;
                z-index: {{ $field['zIndex'] ?? 1 }};
                transform: rotate({{ $field['rotation'] ?? 0 }}deg);
            ">
                @if(($field['type'] ?? 'text') === 'text')
                    <div style="
                        font-family: {{ $style['fontFamily'] ?? 'Arial' }};
                        font-size: {{ $style['fontSize'] ?? 16 }}px;
                        font-weight: {{ $style['fontWeight'] ?? 400 }};
                        color: {{ $style['color'] ?? '#000' }};
                        text-align: {{ $style['textAlign'] ?? 'left' }};
                        line-height: {{ $style['lineHeight'] ?? 1.2 }};
                        letter-spacing: {{ $style['letterSpacing'] ?? 0 }}px;
                        width: 100%;
                        height: 100%;
                        overflow: hidden;
                    ">
                        {{ $value }}
                    </div>
                @endif

                @if(($field['type'] ?? null) === 'image' && $value)
                    <img src="{{ asset('storage/'. $value) }}"
                         style="
                            width: 100%;
                            height: 100%;
                            object-fit: {{ $style['objectFit'] ?? 'contain' }};
                         ">
                @endif
            </div>
        @endforeach

    </div>
</div>

@endsection