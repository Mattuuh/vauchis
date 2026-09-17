<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tenés un regalo Vauchis</title>
</head>

<body style="margin:0; padding:0; background-color:#f5f5f5; font-family:Arial, Helvetica, sans-serif; color:#333333;">
    <div style="padding:30px 15px;">
        <div style="max-width:600px; margin:0 auto; background-color:#ffffff; border-radius:16px; overflow:hidden;">

            {{-- Barra superior con colores Vauchis --}}
            <div style="height:8px; background:linear-gradient(90deg, #0867ed 0%, #0867ed 25%, #4db88f 25%, #4db88f 50%, #aaaaaa 50%, #aaaaaa 75%, #e5007e 75%, #e5007e 100%);"></div>

            {{-- Contenido --}}
            <div style="padding:40px 35px 30px 35px;">
                <h2 style="margin:0 0 20px 0; color:#0867ed; font-size:24px; line-height:1.3;">
                    ¡{{ $voucherDetalle->vd_variante_nombre_para }}, tenés un regalo! 🎁
                </h2>
                <p style="margin:0 0 25px 0; font-size:16px; line-height:1.6;">
                    <strong>{{ $voucherDetalle->vd_variante_nombre_de }}</strong> te envió un voucher a través de Vauchis.
                </p>

                {{-- Mensaje personal --}}
                @if(!empty($voucherDetalle->vd_variante_mensaje))
                    <div style="background-color:#f7f7f7; border-radius:10px; padding:22px; margin-bottom:25px; text-align:center;">
                        <p style="margin:0 0 8px 0; font-size:13px; color:#888888; text-transform:uppercase; letter-spacing:1px;">
                            Un mensaje para vos
                        </p>
                        <p style="margin:0; font-size:17px; line-height:1.6; color:#333333; font-style:italic;">
                            “{{ $voucherDetalle->vd_variante_mensaje }}”
                        </p>
                    </div>
                @endif

                {{-- Datos del voucher --}}
                <div style="background-color:#f7f7f7; border-left:5px solid #4db88f; border-radius:8px; padding:20px; margin-bottom:25px;">
                    <p style="margin:0 0 12px 0; font-size:15px;">
                        <strong style="color:#e5007e;">Voucher:</strong>
                        {{ $voucher->vou_nombre }}
                    </p>
                    <p style="margin:0; font-size:15px;">
                        <strong style="color:#e5007e;">Código:</strong>
                        {{ $voucherDetalle->vd_codigo }}
                    </p>
                </div>
                <p style="margin:0 0 12px 0; font-size:15px; line-height:1.6; color:#555555;">
                    Tu voucher se encuentra adjunto a este correo.
                </p>
                <p style="margin:0; font-size:15px; line-height:1.6; color:#555555;">
                    Guardalo para presentarlo al momento de realizar el canje.
                </p>
            </div>

            {{-- Pie --}}
            <div style="text-align:center; padding:25px 30px 30px 30px; border-top:1px solid #eeeeee;">
                <img src="{{ asset('images/logo-1.png') }}" alt="Vauchis" style="display:block; width:180px; max-width:100%; height:auto; margin:0 auto;">
            </div>
        </div>
    </div>
</body>
</html>