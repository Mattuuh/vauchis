{{-- resources/views/layouts/app.blade.php --}}
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- <title>Vauchis</title> --}}
    <title>@yield('title', 'Vauchis')</title>

    {{-- Bootstrap 5.3 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Jquery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- Sweet Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script> {{-- Lib en español --}}


    <link href="{{ asset('css/home.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/vauchis-base.css') }}">

    @stack('libs')

    @stack('styles')
</head>
<body>

    @if(session('success')!='')
    <script>
    Swal.fire({
        icon: 'success',
        title: 'OK',
        text: '{{ session('success') }}'
    });
    </script>
    @elseif ($errors->any())
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Error :(',
        text: '{{ session('error') }}'
    });
    </script>
    @endif

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    $(document).ready(function () {

        $('#btn_guardar').on('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se va a crear el registro",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5cb85c',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, crear',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {

                    // Loader opcional
                    Swal.fire({
                        title: 'Procesando...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $('#form_main').submit();
                }
            });
        });

        $('#btn_actualizar').on('click', function (e) {
            e.preventDefault();

            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se va a actualizar el registro",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#5cb85c',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {

                    // Loader opcional
                    Swal.fire({
                        title: 'Procesando...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $('#form_main').submit();
                }
            });
        });

    });
    </script>

    @stack('scripts')
</body>
</html>