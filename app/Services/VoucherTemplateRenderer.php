<?php

namespace App\Services;

class VoucherTemplateRenderer
{
    public function render(array $config, array $data): string
    {
        $canvas = $config['canvas'] ?? [];
        $fields = $config['fields'] ?? [];

        $width = (int)($canvas['width'] ?? 1080);
        $height = (int)($canvas['height'] ?? 1350);
        $background = $canvas['background'] ?? null;

        $html = '';
        $html .= '<div style="position:relative;width:' . $width . 'px;height:' . $height . 'px;overflow:hidden;background:#f8f9fa;">';

        if (!empty($background)) {
            $backgroundUrl = $this->normalizeAssetUrl($background);

            $html .= '<img src="' . e($backgroundUrl) . '" alt="Fondo" style="
                position:absolute;
                inset:0;
                width:100%;
                height:100%;
                object-fit:cover;
                z-index:0;
            ">';
        }

        usort($fields, function ($a, $b) {
            return ($a['zIndex'] ?? 0) <=> ($b['zIndex'] ?? 0);
        });

        foreach ($fields as $field) {
            $html .= $this->renderField($field, $data);
        }

        $html .= '</div>';

        return $html;
    }

    protected function renderField(array $field, array $data): string
    {
        $type = $field['type'] ?? 'text';
        $key = $field['key'] ?? '';
        $value = $data[$key] ?? '';

        $x = (int)($field['x'] ?? 0);
        $y = (int)($field['y'] ?? 0);
        $width = (int)($field['width'] ?? 200);
        $height = (int)($field['height'] ?? 40);
        $rotation = (float)($field['rotation'] ?? 0);
        $zIndex = (int)($field['zIndex'] ?? 1);

        $style = $field['style'] ?? [];

        if ($type === 'image') {
            $imageUrl = $this->normalizeAssetUrl($value);

            return '
                <div style="
                    position:absolute;
                    left:' . $x . 'px;
                    top:' . $y . 'px;
                    width:' . $width . 'px;
                    height:' . $height . 'px;
                    transform:rotate(' . $rotation . 'deg);
                    z-index:' . $zIndex . ';
                ">
                    <img src="' . e($imageUrl) . '" alt="" style="
                        width:100%;
                        height:100%;
                        object-fit:' . e($style['objectFit'] ?? 'contain') . ';
                    ">
                </div>
            ';
        }

        return '
            <div style="
                position:absolute;
                left:' . $x . 'px;
                top:' . $y . 'px;
                width:' . $width . 'px;
                height:' . $height . 'px;
                transform:rotate(' . $rotation . 'deg);
                z-index:' . $zIndex . ';
                font-family:' . e($style['fontFamily'] ?? 'Arial') . ';
                font-size:' . (int)($style['fontSize'] ?? 16) . 'px;
                font-weight:' . e($style['fontWeight'] ?? '400') . ';
                color:' . e($style['color'] ?? '#000000') . ';
                text-align:' . e($style['textAlign'] ?? 'left') . ';
                line-height:' . e($style['lineHeight'] ?? '1.2') . ';
                letter-spacing:' . (float)($style['letterSpacing'] ?? 0) . 'px;
                white-space:pre-line;
                overflow:hidden;
            ">' . e($value) . '</div>
        ';
    }

    protected function normalizeAssetUrl(?string $path): string
    {
        if (empty($path)) {
            return '';
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }
}