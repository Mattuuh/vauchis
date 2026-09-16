<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <title>Tu voucher</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:30px;">

    <div style="
        max-width:600px;
        margin:auto;
        background:#ffffff;
        padding:30px;
        border-radius:12px;
    ">

        <h2>
            ¡Gracias por tu compra!
        </h2>

        <p>
            Tu voucher ya se encuentra disponible.
        </p>

        <p>
            <strong>Voucher:</strong>
            {{ $voucher->vou_nombre }}
        </p>

        <p>
            <strong>Código:</strong>
            {{ $voucherDetalle->vd_codigo }}
        </p>

        <p>
            Podés acceder a tu voucher desde Vauchis.
        </p>

    </div>

</body>
</html>