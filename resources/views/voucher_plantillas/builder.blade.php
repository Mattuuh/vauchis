@extends('layouts.app')

@section('title', 'Editor de Plantillas')

@push('styles')
<style>
    .builder-wrapper {
        display: grid;
        grid-template-columns: 260px 1fr 320px;
        gap: 20px;
        align-items: start;
    }

    .builder-panel {
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        padding: 16px;
    }

    .builder-stage-wrap {
        overflow: auto;
        background: #f1f3f5;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        padding: 20px;
        min-height: 700px;
    }

    .field-btn {
        width: 100%;
        text-align: left;
        margin-bottom: 8px;
    }

    #builder-container {
        margin: 0 auto;
        background: #fff;
        box-shadow: 0 0 30px rgba(0,0,0,.08);
    }

    .form-label-sm {
        font-size: .875rem;
        margin-bottom: .35rem;
        font-weight: 600;
    }
</style>
@endpush

@section('content')

@include('partials.navbar')

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1">Builder de plantilla</h1>
            <div class="text-muted">{{ $plantilla->vpl_nombre }}</div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('voucher_plantillas.preview', $plantilla->vpl_id) }}" target="_blank" class="btn btn-outline-success">
                Ver preview
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="builder-wrapper">
        <div class="builder-panel">
            <h5 class="mb-3">Campos de texto</h5>

            @foreach($textFields as $key => $label)
                <button type="button" class="btn btn-outline-primary field-btn" onclick="addTextField('{{ $key }}', '{{ $label }}')">
                    {{ $label }}
                </button>
            @endforeach

            <hr>

            <h5 class="mb-3">Campos de imagen</h5>

            @foreach($imageFields as $key => $label)
                <button type="button" class="btn btn-outline-secondary field-btn" onclick="addImageField('{{ $key }}', '{{ $label }}')">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <div class="builder-stage-wrap">
            <div id="builder-container"></div>
        </div>

        <div class="builder-panel">
            <h5 class="mb-3">Propiedades</h5>

            <div class="mb-2">
                <label class="form-label-sm">ID</label>
                <input type="text" id="prop-id" class="form-control" readonly>
            </div>

            <div class="mb-2">
                <label class="form-label-sm">Campo</label>
                <input type="text" id="prop-key" class="form-control" readonly>
            </div>

            <div class="row">
                <div class="col-6 mb-2">
                    <label class="form-label-sm">X</label>
                    <input type="number" id="prop-x" class="form-control">
                </div>
                <div class="col-6 mb-2">
                    <label class="form-label-sm">Y</label>
                    <input type="number" id="prop-y" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-6 mb-2">
                    <label class="form-label-sm">Width</label>
                    <input type="number" id="prop-width" class="form-control">
                </div>
                <div class="col-6 mb-2">
                    <label class="form-label-sm">Height</label>
                    <input type="number" id="prop-height" class="form-control">
                </div>
            </div>

            <div class="mb-2">
                <label class="form-label-sm">Tamaño fuente</label>
                <input type="number" id="prop-fontSize" class="form-control">
            </div>

            <div class="mb-2">
                <label class="form-label-sm">Color</label>
                <input type="color" id="prop-color" class="form-control form-control-color">
            </div>

            <div class="mb-2">
                <label class="form-label-sm">Alineación</label>
                <select id="prop-align" class="form-select">
                    <option value="left">Izquierda</option>
                    <option value="center">Centro</option>
                    <option value="right">Derecha</option>
                </select>
            </div>

            <div class="d-grid gap-2 mt-3">
                <button type="button" class="btn btn-danger" onclick="removeSelectedField()">
                    Eliminar campo
                </button>
                <button type="button" class="btn btn-primary" onclick="submitBuilderForm()">
                    Guardar diseño
                </button>
            </div>

            <form id="builder-form" action="{{ route('voucher_plantillas.builder.save', $plantilla->vpl_id) }}" method="POST">
                @csrf
                <input type="hidden" name="config_json" id="config_json">
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/konva@9/konva.min.js"></script>
<script>
    const initialConfig = @json($plantilla->vpl_config_json ?? []);
    const backgroundUrl = @json($plantilla->vpl_fondo_path ? asset($plantilla->vpl_fondo_path) : null);

    let templateConfig = initialConfig && Object.keys(initialConfig).length
        ? initialConfig
        : {
            canvas: {
                width: {{ $plantilla->vpl_ancho ?? 1080 }},
                height: {{ $plantilla->vpl_alto ?? 1350 }},
                background: backgroundUrl
            },
            fields: []
        };

    if (!templateConfig.canvas) {
        templateConfig.canvas = {
            width: {{ $plantilla->vpl_ancho ?? 1080 }},
            height: {{ $plantilla->vpl_alto ?? 1350 }},
            background: backgroundUrl
        };
    }

    templateConfig.canvas.background = templateConfig.canvas.background || backgroundUrl;

    const stage = new Konva.Stage({
        container: 'builder-container',
        width: templateConfig.canvas.width || 1080,
        height: templateConfig.canvas.height || 1350,
    });

    const backgroundLayer = new Konva.Layer();
    const fieldsLayer = new Konva.Layer();
    const transformer = new Konva.Transformer({
        rotateEnabled: false,
        enabledAnchors: ['middle-left', 'middle-right']
    });

    stage.add(backgroundLayer);
    stage.add(fieldsLayer);
    fieldsLayer.add(transformer);

    let selectedGroup = null;

    function drawBackground() {
        backgroundLayer.destroyChildren();

        if (!templateConfig.canvas.background) {
            backgroundLayer.draw();
            return;
        }

        const imageObj = new Image();
        imageObj.onload = function () {
            const bg = new Konva.Image({
                x: 0,
                y: 0,
                width: stage.width(),
                height: stage.height(),
                image: imageObj,
                listening: false
            });

            backgroundLayer.add(bg);
            backgroundLayer.draw();
        };
        imageObj.src = templateConfig.canvas.background;
    }

    function renderAllFields() {
        fieldsLayer.destroyChildren();
        fieldsLayer.add(transformer);

        (templateConfig.fields || []).forEach(field => renderField(field));

        fieldsLayer.draw();
        syncConfigInput();
    }

    function renderField(field) {
        if (field.type === 'text') {
            renderTextField(field);
            return;
        }

        if (field.type === 'image') {
            renderImageField(field);
        }
    }

    function renderTextField(field) {
        const textValue = field.label || field.key;

        const text = new Konva.Text({
            x: field.x,
            y: field.y,
            width: field.width,
            height: field.height,
            text: textValue,
            fontSize: field.style.fontSize || 24,
            fontFamily: field.style.fontFamily || 'Arial',
            fontStyle: String(field.style.fontWeight || '400') === '700' ? 'bold' : 'normal',
            fill: field.style.color || '#000000',
            align: field.style.textAlign || 'left',
            draggable: false,
        });

        const group = new Konva.Group({
            x: 0,
            y: 0,
            draggable: true,
            name: 'field-group',
            fieldId: field.id,
        });

        const rect = new Konva.Rect({
            x: field.x,
            y: field.y,
            width: field.width,
            height: field.height,
            stroke: '#0d6efd',
            dash: [6, 4],
            cornerRadius: 4,
        });

        group.add(rect);
        group.add(text);

        attachGroupEvents(group, field);
        fieldsLayer.add(group);
    }

    function renderImageField(field) {
        const group = new Konva.Group({
            x: 0,
            y: 0,
            draggable: true,
            name: 'field-group',
            fieldId: field.id,
        });

        const rect = new Konva.Rect({
            x: field.x,
            y: field.y,
            width: field.width,
            height: field.height,
            stroke: '#6c757d',
            dash: [6, 4],
            cornerRadius: 4,
            fill: '#f8f9fa',
        });

        const text = new Konva.Text({
            x: field.x,
            y: field.y + (field.height / 2) - 10,
            width: field.width,
            align: 'center',
            text: field.label || field.key,
            fontSize: 16,
            fill: '#6c757d',
        });

        group.add(rect);
        group.add(text);

        attachGroupEvents(group, field);
        fieldsLayer.add(group);
    }

    function attachGroupEvents(group, field) {
        group.on('click tap', function () {
            selectedGroup = group;
            transformer.nodes([group]);
            loadFieldProperties(field);
            fieldsLayer.draw();
        });

        group.on('dragend', function () {
            const rect = group.findOne('Rect');
            field.x = Math.round(rect.x() + group.x());
            field.y = Math.round(rect.y() + group.y());
            group.x(0);
            group.y(0);

            updateFieldNode(group, field);
            loadFieldProperties(field);
            syncConfigInput();
            fieldsLayer.draw();
        });

        group.on('transformend', function () {
            syncConfigInput();
        });
    }

    function updateFieldNode(group, field) {
        const rect = group.findOne('Rect');
        const text = group.findOne('Text');

        rect.x(field.x);
        rect.y(field.y);
        rect.width(field.width);
        rect.height(field.height);

        text.x(field.x);
        text.y(field.type === 'image' ? field.y + (field.height / 2) - 10 : field.y);
        text.width(field.width);

        if (field.type === 'text') {
            text.height(field.height);
            text.fontSize(field.style.fontSize || 24);
            text.fill(field.style.color || '#000000');
            text.align(field.style.textAlign || 'left');
            text.fontStyle(String(field.style.fontWeight || '400') === '700' ? 'bold' : 'normal');
        }
    }

    function addTextField(key, label) {
        const field = {
            id: 'field_' + Date.now(),
            type: 'text',
            key: key,
            label: label,
            x: 80,
            y: 80,
            width: 350,
            height: 60,
            rotation: 0,
            zIndex: (templateConfig.fields || []).length + 1,
            style: {
                fontFamily: 'Arial',
                fontSize: 28,
                fontWeight: '700',
                color: '#ffffff',
                textAlign: 'left',
                lineHeight: 1.2,
                letterSpacing: 0
            }
        };

        templateConfig.fields.push(field);
        renderAllFields();
    }

    function addImageField(key, label) {
        const field = {
            id: 'field_' + Date.now(),
            type: 'image',
            key: key,
            label: label,
            x: 80,
            y: 80,
            width: 140,
            height: 140,
            rotation: 0,
            zIndex: (templateConfig.fields || []).length + 1,
            style: {
                objectFit: 'contain'
            }
        };

        templateConfig.fields.push(field);
        renderAllFields();
    }

    function getSelectedField() {
        if (!selectedGroup) return null;

        const fieldId = selectedGroup.getAttr('fieldId');
        return templateConfig.fields.find(f => f.id === fieldId) || null;
    }

    function loadFieldProperties(field) {
        $('#prop-id').val(field.id || '');
        $('#prop-key').val(field.key || '');
        $('#prop-x').val(field.x || 0);
        $('#prop-y').val(field.y || 0);
        $('#prop-width').val(field.width || 0);
        $('#prop-height').val(field.height || 0);
        $('#prop-fontSize').val(field.style?.fontSize || '');
        $('#prop-color').val(field.style?.color || '#000000');
        $('#prop-align').val(field.style?.textAlign || 'left');
    }

    function applyPropertiesToSelected() {
        const field = getSelectedField();
        if (!field) return;

        field.x = parseInt($('#prop-x').val() || 0);
        field.y = parseInt($('#prop-y').val() || 0);
        field.width = parseInt($('#prop-width').val() || 100);
        field.height = parseInt($('#prop-height').val() || 40);

        if (!field.style) field.style = {};

        if (field.type === 'text') {
            field.style.fontSize = parseInt($('#prop-fontSize').val() || 24);
            field.style.color = $('#prop-color').val() || '#000000';
            field.style.textAlign = $('#prop-align').val() || 'left';
        }

        renderAllFields();
    }

    function removeSelectedField() {
        const field = getSelectedField();
        if (!field) return;

        templateConfig.fields = templateConfig.fields.filter(f => f.id !== field.id);
        selectedGroup = null;
        transformer.nodes([]);
        renderAllFields();

        $('#prop-id, #prop-key, #prop-x, #prop-y, #prop-width, #prop-height, #prop-fontSize').val('');
        $('#prop-color').val('#000000');
        $('#prop-align').val('left');
    }

    function syncConfigInput() {
        $('#config_json').val(JSON.stringify(templateConfig));
    }

    function submitBuilderForm() {
        syncConfigInput();
        $('#builder-form').submit();
    }

    $('#prop-x, #prop-y, #prop-width, #prop-height, #prop-fontSize, #prop-color, #prop-align').on('input change', function () {
        applyPropertiesToSelected();
    });

    drawBackground();
    renderAllFields();
</script>
@endpush