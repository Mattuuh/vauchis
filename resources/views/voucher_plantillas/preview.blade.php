@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Preview de plantilla</h1>

    <div class="card">
        <div class="card-body">
            <div style="overflow:auto;">
                {!! $html !!}
            </div>
        </div>
    </div>
</div>
@endsection