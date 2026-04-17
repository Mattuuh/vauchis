@extends('layouts.app')

@section('title', 'Voucher')

@section('content')

@include('partials.navbar')

<div class="container py-4">
    <h1 class="mb-3">Voucher emitido #{{ $emision->vem_id }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3 d-flex gap-2">
        @if($emision->vem_pdf_path)
            <a href="{{ asset($emision->vem_pdf_path) }}" target="_blank" class="btn btn-danger">
                Ver PDF
            </a>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <div style="overflow:auto;">
                {!! $emision->vem_html !!}
            </div>
        </div>
    </div>
</div>
@endsection