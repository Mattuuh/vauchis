@extends('layouts.app')

@section('title', 'Vouchers vinculados')

@push('scripts')
<script>
$(document).ready(function () {

    function cargar_vouchers(page = 1, orderby = '')
    {
        let dataString = $('#formftro').serialize()+'&page='+page+'&orderby='+orderby;

        $.ajax({
            type: 'GET',
            url: '/vouchers/listado',
            data: dataString,
            beforeSend: function() {
                $('#box-espere').show();
            },
            complete: function() {
                $('#box-espere').hide();
            },
            success: function(response) {
                $('#box_body').html(response.body);
                $('#box_foot').html(response.foot);
                $('#f_organismo_totales').html(response.kregtotal);
            }
        });
    }

    $('#btn_filtro').on('click', function () {
        cargar_vouchers($('#pag').val(), $('#ob').val());
    });

    $(document).on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#btn_filtro').click();
        }
    });

});
</script>
@endpush


@section('content')

@include('partials.navbar')

<main class="mv-page">
    {{-- ENCABEZADO --}}
    <section class="mv-header">
        <div class="container">
            <div class="mv-header-content">
                <h1><strong>Entidad</strong></h1>
                <p>
                    Visualiza todos los vouchers vinculados, consultá su estado y stock.
                </p>
            </div>
        </div>
    </section>
    {{-- CONTENIDO --}}
    <section class="mv-content">
        <div class="container">
            {{-- RESUMEN DE LA ENTIDAD --}}
            <div class="mv-entity-grid">

                {{-- DATOS BASICOS --}}
                <article class="mv-info-card mv-info-card--entity">
                    <div class="mv-info-card__header">
                        <div class="mv-info-card__icon">
                            <i class="bi bi-shop"></i>
                        </div>

                        <div>
                            <span class="mv-info-card__eyebrow">Nombre fantasia</span>
                            <h2>{{ $entidad->ent_nombre_fantasia }}</h2>
                        </div>
                    </div>

                    <div class="mv-entity-data">
                        <div class="mv-entity-data__item">
                            <span>Razon social</span>
                            <strong>{{ $entidad->ent_razon_social ?? '-' }}</strong>
                        </div>
                        <div class="mv-entity-data__item">
                            <span>CUIT</span>
                            <strong>{{ $entidad->ent_documento ?? '-' }}</strong>
                        </div>
                        <div class="mv-entity-data__item">
                            <span>Domicilio fiscal</span>
                            <strong>{{ $entidad->ent_domicilio_fiscal ?? '-' }}</strong>
                        </div>
                        <div class="mv-entity-data__item">
                            <span>Responsabilidad ante IVA</span>
                            <strong>{{ $entidad->tipo_responsabilidad->tipo_resp_nombre ?? '-' }}</strong>
                        </div>
                    </div>
                </article>


                {{-- RESUMEN VOUCHERS --}}
                <article class="mv-info-card">
                    <div class="mv-info-card__header">
                        <div class="mv-info-card__icon">
                            <i class="bi bi-ticket-perforated"></i>
                        </div>

                        <div>
                            <span class="mv-info-card__eyebrow">Vouchers</span>
                            <h2>Resumen general</h2>
                        </div>
                    </div>

                    <div class="mv-stats">
                        <div class="mv-stat">
                            <strong>{{ $vouchersTotal ?? 0 }}</strong>
                            <span>Publicados</span>
                        </div>

                        <div class="mv-stat">
                            <strong>{{ $vouchersVendidos ?? 0 }}</strong>
                            <span>Vendidos</span>
                        </div>

                        <div class="mv-stat">
                            <strong>{{ $vouchersCanjeados ?? 0 }}</strong>
                            <span>Canjeados</span>
                        </div>
                    </div>
                </article>

            </div>


            {{-- SUCURSALES --}}
            <div class="mv-branches-card">

                <div class="mv-section-heading">
                    <div>
                        <span class="mv-section-heading__eyebrow">Puntos de atención</span>
                        <h2>Sucursales</h2>
                    </div>

                    <span class="mv-branches-count">
                        {{ $entidad->domicilios->count() }}
                        {{ $entidad->domicilios->count() === 1 ? 'sucursal' : 'sucursales' }}
                    </span>
                </div>

                <div class="mv-branches-grid">

                    @forelse($entidad->domicilios as $sucursal)

                        <article class="mv-branch">

                            <div class="mv-branch__icon">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>

                            <div class="mv-branch__content">

                                <div class="mv-branch__title">
                                    {{ $sucursal->ed_nombre ?? 'Sucursal' }}
                                </div>

                                <div class="mv-branch__address">
                                    {{ $sucursal->ed_direccion }}
                                </div>

                                @if(!empty($sucursal->ed_telefono1))
                                    <div class="mv-branch__detail">
                                        <i class="bi bi-telephone"></i>
                                        {{ $sucursal->ed_telefono1 }}
                                    </div>
                                @endif

                                <div class="mv-branch__status">
                                    @if($sucursal->ed_canje == 1)
                                        <span class="mv-branch-badge mv-branch-badge--success">
                                            <i class="bi bi-check-circle-fill"></i>
                                            Recibe canjes
                                        </span>
                                    @else
                                        <span class="mv-branch-badge mv-branch-badge--muted">
                                            <i class="bi bi-dash-circle"></i>
                                            No recibe canjes
                                        </span>
                                    @endif
                                </div>

                            </div>

                        </article>

                    @empty

                        <div class="mv-empty-branches">
                            <i class="bi bi-geo-alt"></i>
                            <span>No hay sucursales registradas.</span>
                        </div>

                    @endforelse

                </div>

            </div>
            <div class="mv-panel">
                {{-- BUSCADOR --}}
                <div class="mv-toolbar">
                    <form action="" id="formftro" class="mv-search-form">
                        <div class="mv-search">
                            <i class="bi bi-search"></i>
                            <input type="text" class="form-control" name="buscar" id="buscar" placeholder="Buscar voucher...">
                        </div>
                    </form>
                    <div class="mv-toolbar-actions">
                        <div class="mv-loading" id="box-espere" style="display: none;">
                            <span class="spinner-border spinner-border-sm"></span>
                        </div>
                        <button type="button" id="btn_filtro" class="mv-btn-search">Buscar</button>
                    </div>
                </div>
                {{-- TABLA --}}
                <div class="mv-table-wrapper">
                    <table class="mv-table">
                        <thead>
                            <tr>
                                <th>VOUCHER</th>
                                <th>FECHA DE ALTA</th>
                                <th>STOCK</th>
                                <th>VENDIDOS</th>
                                <th>CANJEADOS</th>
                                <th class="text-center">ESTADO</th>
                            </tr>
                        </thead>
                        <tbody id="box_body">
                            @foreach($vouchers as $voucher)
                                <tr>
                                    <td data-label="Voucher">
                                        <span class="mv-code">{{ $voucher->vou_nombre }}</span>
                                    </td>
                                    <td data-label="Fecha de alta">
                                        <span class="mv-date">{{ $voucher->vou_fecha_alta!='' ? $voucher->vou_fecha_alta->format('d/m/Y') : '' }}</span>
                                    </td>
                                    <td data-label="Stock">
                                        <div class="mv-voucher-name">{{ $voucher->vou_stock }}</div>
                                    </td>
                                    <td data-label="Vendidos">
                                        <div class="mv-voucher-name">{{ $voucher->vou_stock }}</div>
                                    </td>
                                    <td data-label="Canjeados">
                                        <div class="mv-voucher-name">{{ $voucher->vou_stock }}</div>
                                    </td>
                                    <td class="text-center" data-label="Estado de canje">
                                        @php
                                            $estado = estado($voucher->vd_estado);
                                        @endphp

                                        <span class="mv-status {{ $estado['class'] }}" title="{{ $estado['text'] }}">
                                            <i class="bi bi-{{ $estado['icon'] }}"></i>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- PIE --}}
                <div class="mv-footer" id="box_foot">
                    <span>Mostrando <strong>{{ $vouchers->count() }}</strong> registros</span>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection

@push('styles')
<style>
/* =========================================================
   MIS VOUCHERS
   ========================================================= */

.mv-page {
    font-family: 'Montserrat', sans-serif;
    background: #f7f8fb;
    min-height: 100vh;
    color: #1f2937;
}


/* =========================================================
   HEADER
   ========================================================= */

.mv-header {
    padding: 95px 0 42px;
    background: #07378C;
}

.mv-header-content {
    max-width: 760px;
}

.mv-header h1 {
    margin: 0;
    font-size: 38px;
    line-height: 1.15;
    font-weight: 400;
    letter-spacing: -1px;
    color: #fff;
}

.mv-header h1 strong {
    font-weight: 700;
}

.mv-header p {
    max-width: 680px;
    margin: 14px 0 0;
    font-size: 15px;
    font-weight: 400;
    line-height: 1.65;
    color: #dddddd;
}


/* =========================================================
   CONTENT
   ========================================================= */

.mv-content {
    padding: 38px 0 70px;
}


/* =========================================================
   PANEL
   ========================================================= */

.mv-panel {
    background: #fff;
    border-radius: 16px;
    padding: 28px 30px 20px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, .07);
}


/* =========================================================
   TOOLBAR
   ========================================================= */

.mv-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 28px;
}

.mv-search-form {
    flex: 1;
    max-width: 520px;
}

.mv-search {
    position: relative;
}

.mv-search > i {
    position: absolute;
    top: 50%;
    left: 17px;
    transform: translateY(-50%);
    font-size: 17px;
    color: #9198a4;
    pointer-events: none;
}

.mv-search .form-control {
    width: 100%;
    height: 46px;
    padding: 0 18px 0 47px;
    border: 1px solid #dde1e7;
    border-radius: 999px;
    background: #fff;
    color: #222;
    font-family: 'Montserrat', sans-serif;
    font-size: 13px;
    font-weight: 500;
    box-shadow: none;
    transition:
        border-color .2s ease,
        box-shadow .2s ease;
}

.mv-search .form-control::placeholder {
    color: #9ca3af;
}

.mv-search .form-control:focus {
    border-color: #07378C;
    box-shadow: 0 0 0 3px rgba(7, 55, 140, .08);
}


/* =========================================================
   ACCIONES
   ========================================================= */

.mv-toolbar-actions {
    display: flex;
    align-items: center;
    gap: 12px;
}

.mv-loading {
    color: #07378C;
}

.mv-btn-search {
    min-width: 132px;
    height: 44px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border: 0;
    border-radius: 999px;

    background: #07378C;
    color: #fff;

    font-family: 'Montserrat', sans-serif;
    font-size: 14px;
    font-weight: 600;

    cursor: pointer;

    transition:
        background .2s ease,
        transform .15s ease,
        box-shadow .2s ease;
}

.mv-btn-search:hover {
    background: #062d73;
    box-shadow: 0 5px 14px rgba(7, 55, 140, .18);
}

.mv-btn-search:active {
    transform: scale(.98);
}


/* =========================================================
   TABLE
   ========================================================= */

.mv-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.mv-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.mv-table thead th {
    padding: 14px 18px;
    background: #f6f7f9;

    border-top: 1px solid #edf0f3;
    border-bottom: 1px solid #e7e9ee;

    color: #737b88;

    font-family: 'Montserrat', sans-serif;
    font-size: 11px;
    font-weight: 700;
    line-height: 1.2;

    letter-spacing: .35px;
    white-space: nowrap;
}

.mv-table thead th:first-child {
    border-radius: 9px 0 0 9px;
}

.mv-table thead th:last-child {
    border-radius: 0 9px 9px 0;
}

.mv-table tbody td {
    padding: 19px 18px;

    border-bottom: 1px solid #edf0f3;

    color: #3f4650;

    font-size: 13px;
    font-weight: 500;

    vertical-align: middle;
}

.mv-table tbody tr {
    transition: background .18s ease;
}

.mv-table tbody tr:hover {
    background: #fafbfc;
}


/* =========================================================
   DATOS
   ========================================================= */

.mv-code {
    display: inline-flex;
    align-items: center;

    padding: 6px 10px;

    border-radius: 6px;

    background: #f0f4fb;
    color: #07378C;

    font-size: 12px;
    font-weight: 700;

    letter-spacing: .3px;
}

.mv-voucher-name {
    color: #20252c;
    font-size: 14px;
    font-weight: 650;
}

.mv-date {
    white-space: nowrap;
    color: #646c78;
}


/* =========================================================
   ESTADO
   ========================================================= */

.mv-status {
    width: 32px;
    height: 32px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border-radius: 50%;

    font-size: 15px;
}


/* Si tu helper estado() ya devuelve colores,
   estas reglas no son necesarias.
   Sirven solamente como ejemplo.

.mv-status.success {
    background: #e7f8ef;
    color: #36a269;
}

.mv-status.warning {
    background: #fff4db;
    color: #d89100;
}

.mv-status.danger {
    background: #fdeaea;
    color: #d34c4c;
}

*/


/* =========================================================
   PDF
   ========================================================= */

.mv-pdf-btn {
    width: 36px;
    height: 36px;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    border: 1px solid #e1e5ea;
    border-radius: 50%;

    background: #fff;
    color: #07378C;

    font-size: 17px;

    cursor: pointer;

    transition:
        background .2s ease,
        color .2s ease,
        border-color .2s ease,
        transform .15s ease;
}

.mv-pdf-btn:hover {
    background: #07378C;
    border-color: #07378C;
    color: #fff;
}

.mv-pdf-btn:active {
    transform: scale(.94);
}


/* =========================================================
   FOOTER
   ========================================================= */

.mv-footer {
    display: flex;
    justify-content: flex-end;

    padding-top: 18px;

    color: #7b8492;

    font-size: 12px;
    font-weight: 500;
}

.mv-footer strong {
    color: #07378C;
    font-weight: 700;
}


/* =========================================================
   TABLET
   ========================================================= */

@media (max-width: 991px) {

    .mv-header {
        padding: 40px 0 32px;
    }

    .mv-header h1 {
        font-size: 32px;
    }

    .mv-panel {
        padding: 24px;
    }

}


/* =========================================================
   MOBILE
   ========================================================= */

@media (max-width: 767px) {

    .mv-page {
        background: #fff;
    }

    .mv-header {
        padding: 28px 0 22px;
    }

    .mv-header-content {
        padding: 0 4px;
    }

    .mv-header-line {
        width: 30px;
        height: 4px;
        margin-bottom: 10px;
    }

    .mv-header h1 {
        font-size: 27px;
        letter-spacing: -.5px;
    }

    .mv-header p {
        margin-top: 10px;
        font-size: 13px;
        line-height: 1.55;
    }

    .mv-content {
        padding: 12px 0 50px;
    }

    .mv-panel {
        padding: 0;
        border-radius: 0;
        box-shadow: none;
    }


    /* BUSCADOR */

    .mv-toolbar {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 9px;
        margin-bottom: 22px;
    }

    .mv-search-form {
        width: 100%;
        max-width: none;
    }

    .mv-search .form-control {
        height: 43px;
        font-size: 12px;
        padding-left: 42px;
    }

    .mv-search > i {
        left: 15px;
    }

    .mv-btn-search {
        min-width: auto;
        padding: 0 19px;
        height: 43px;
        font-size: 12px;
    }


    /* ================================
       TABLA -> CARDS
       ================================ */

    .mv-table-wrapper {
        overflow: visible;
    }

    .mv-table,
    .mv-table tbody,
    .mv-table tr,
    .mv-table td {
        display: block;
        width: 100%;
    }

    .mv-table thead {
        display: none;
    }

    .mv-table tbody {
        display: grid;
        gap: 14px;
    }

    .mv-table tbody tr {
        padding: 18px 17px;

        border: 1px solid #e9ebef;
        border-radius: 12px;

        background: #fff;

        box-shadow: 0 2px 8px rgba(0, 0, 0, .07);
    }

    .mv-table tbody tr:hover {
        background: #fff;
    }

    .mv-table tbody td {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;

        padding: 9px 0;

        border: 0;

        font-size: 12px;
        text-align: right !important;
    }

    .mv-table tbody td::before {
        content: attr(data-label);

        flex-shrink: 0;

        color: #89919d;

        font-size: 10px;
        font-weight: 700;

        text-transform: uppercase;
        letter-spacing: .3px;

        text-align: left;
    }

    .mv-table tbody td:nth-child(2) {
        padding-top: 2px;
        padding-bottom: 13px;

        margin-bottom: 4px;

        border-bottom: 1px solid #edf0f3;
    }

    .mv-table tbody td:nth-child(2) .mv-voucher-name {
        max-width: 62%;
        font-size: 14px;
        line-height: 1.35;
    }

    .mv-code {
        font-size: 11px;
    }

    .mv-status {
        width: 29px;
        height: 29px;
    }

    .mv-pdf-btn {
        width: 32px;
        height: 32px;
        font-size: 15px;
    }

    .mv-footer {
        justify-content: center;
        padding: 23px 0 0;
        font-size: 11px;
    }

}


/* =========================================================
   MOBILE MUY PEQUEÑO
   ========================================================= */

@media (max-width: 420px) {

    .mv-toolbar {
        grid-template-columns: 1fr;
    }

    .mv-btn-search {
        width: 100%;
    }

    .mv-table tbody tr {
        padding: 16px 15px;
    }

}

/* =========================================================
   RESUMEN ENTIDAD
   ========================================================= */

.mv-entity-grid {
    display: grid;
    grid-template-columns: 1.35fr 1fr;
    gap: 22px;
    margin-bottom: 22px;
}

.mv-info-card,
.mv-branches-card {
    background: #fff;
    border: 1px solid #edf0f3;
    border-radius: 16px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, .06);
}

.mv-info-card {
    padding: 25px 27px;
}

.mv-info-card__header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 23px;
}

.mv-info-card__icon {
    width: 46px;
    height: 46px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 12px;

    background: #f0f4fb;
    color: #07378C;

    font-size: 20px;
}

.mv-info-card__eyebrow,
.mv-section-heading__eyebrow {
    display: block;
    margin-bottom: 4px;

    color: #8a929e;

    font-size: 10px;
    font-weight: 700;
    letter-spacing: .7px;
    text-transform: uppercase;
}

.mv-info-card h2,
.mv-section-heading h2 {
    margin: 0;

    color: #20252c;

    font-family: 'Montserrat', sans-serif;
    font-size: 19px;
    font-weight: 700;
}


/* DATOS BASICOS */

.mv-entity-data {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 12px;
}

.mv-entity-data__item {
    min-width: 0;

    padding: 14px 15px;

    border-radius: 10px;

    background: #f8f9fb;
}

.mv-entity-data__item span {
    display: block;
    margin-bottom: 5px;

    color: #9097a2;

    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .4px;
}

.mv-entity-data__item strong {
    display: block;

    overflow: hidden;
    text-overflow: ellipsis;

    color: #303640;

    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}


/* ESTADISTICAS */

.mv-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
}

.mv-stat {
    padding: 12px 8px;
    text-align: center;

    border-right: 1px solid #edf0f3;
}

.mv-stat:last-child {
    border-right: 0;
}

.mv-stat strong {
    display: block;

    color: #07378C;

    font-size: 25px;
    line-height: 1;
    font-weight: 700;
}

.mv-stat span {
    display: block;
    margin-top: 8px;

    color: #8a929e;

    font-size: 10px;
    font-weight: 600;
}


/* =========================================================
   SUCURSALES
   ========================================================= */

.mv-branches-card {
    padding: 25px 27px;
    margin-bottom: 22px;
}

.mv-section-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;

    margin-bottom: 20px;
}

.mv-branches-count {
    display: inline-flex;
    align-items: center;

    padding: 7px 12px;

    border-radius: 999px;

    background: #f0f4fb;
    color: #07378C;

    font-size: 11px;
    font-weight: 700;
}

.mv-branches-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 14px;
}

.mv-branch {
    display: flex;
    gap: 13px;

    padding: 17px;

    border: 1px solid #e9ecf1;
    border-radius: 12px;

    background: #fff;

    transition:
        border-color .2s ease,
        box-shadow .2s ease,
        transform .15s ease;
}

.mv-branch:hover {
    border-color: #d7dde7;
    box-shadow: 0 5px 15px rgba(0, 0, 0, .05);
    transform: translateY(-1px);
}

.mv-branch__icon {
    width: 37px;
    height: 37px;

    flex-shrink: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    border-radius: 10px;

    background: #f0f4fb;
    color: #07378C;

    font-size: 15px;
}

.mv-branch__content {
    min-width: 0;
}

.mv-branch__title {
    margin-bottom: 4px;

    color: #242932;

    font-size: 13px;
    font-weight: 700;
}

.mv-branch__address {
    color: #6e7682;

    font-size: 11px;
    line-height: 1.45;
}

.mv-branch__detail {
    display: flex;
    align-items: center;
    gap: 6px;

    margin-top: 8px;

    color: #7d8591;

    font-size: 10px;
    font-weight: 500;
}

.mv-branch__status {
    margin-top: 11px;
}

.mv-branch-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;

    padding: 5px 8px;

    border-radius: 999px;

    font-size: 9px;
    font-weight: 700;
}

.mv-branch-badge--success {
    background: #e9f7ef;
    color: #29915b;
}

.mv-branch-badge--muted {
    background: #f2f3f5;
    color: #858c96;
}

.mv-empty-branches {
    grid-column: 1 / -1;

    display: flex;
    align-items: center;
    justify-content: center;
    gap: 9px;

    min-height: 100px;

    border: 1px dashed #d8dde5;
    border-radius: 12px;

    color: #89919c;

    font-size: 12px;
}

@media (max-width: 991px) {

    .mv-entity-grid {
        grid-template-columns: 1fr;
    }

    .mv-branches-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

}


@media (max-width: 767px) {

    .mv-entity-grid {
        gap: 12px;
        margin-bottom: 12px;
    }

    .mv-info-card,
    .mv-branches-card {
        border-radius: 12px;
        padding: 19px 17px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
    }

    .mv-info-card__header {
        margin-bottom: 17px;
    }

    .mv-info-card__icon {
        width: 40px;
        height: 40px;
        font-size: 17px;
    }

    .mv-info-card h2,
    .mv-section-heading h2 {
        font-size: 16px;
    }

    .mv-entity-data {
        grid-template-columns: 1fr;
        gap: 7px;
    }

    .mv-entity-data__item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;

        padding: 11px 12px;
    }

    .mv-entity-data__item span {
        margin: 0;
    }

    .mv-entity-data__item strong {
        max-width: 65%;
        text-align: right;
    }

    .mv-stat strong {
        font-size: 21px;
    }

    .mv-stat span {
        font-size: 9px;
    }

    .mv-branches-card {
        margin-bottom: 18px;
    }

    .mv-section-heading {
        margin-bottom: 15px;
    }

    .mv-branches-grid {
        grid-template-columns: 1fr;
        gap: 9px;
    }

    .mv-branch {
        padding: 14px;
    }

    .mv-branches-count {
        padding: 6px 9px;
        font-size: 9px;
    }

}
</style>
@endpush