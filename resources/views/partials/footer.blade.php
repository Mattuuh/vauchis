<footer class="v-footer">
    <div class="container">
        <div class="row">

            <!-- Logo + descripción -->
            <div class="col-lg-4 mb-4">
                <img
                    src="{{ asset('images/logo-2.png') }}"
                    alt="Vauchis"
                    class="v-footer__logo"
                >

                <p class="v-footer__description">
                    Simplificamos el acto de regalar.
                    Conectamos personas con comercios locales
                    cuidadosamente seleccionados.
                </p>
            </div>

            <!-- Vauchis -->
            <div class="col-lg-2 col-md-4 mb-4">
                <h5 class="v-footer__title">Vauchis</h5>

                <ul class="v-footer__menu">
                    <li>
                        <a href="#">Sobre nosotros</a>
                    </li>
                    <li>
                        <a href="#">Cómo funciona</a>
                    </li>
                    <li>
                        <a href="#">Para comercios</a>
                    </li>
                </ul>
            </div>

            <!-- Ayuda -->
            <div class="col-lg-2 col-md-4 mb-4">
                <h5 class="v-footer__title">Ayuda</h5>

                <ul class="v-footer__menu">
                    <li>
                        <a href="#">Preguntas frecuentes</a>
                    </li>
                    <li>
                        <a href="#">Términos y condiciones</a>
                    </li>
                    <li>
                        <a href="#">Privacidad</a>
                    </li>
                </ul>
            </div>

            <!-- Contacto -->
            <div class="col-lg-2 col-md-4 mb-4">
                <h5 class="v-footer__title">Contacto</h5>

                <ul class="v-footer__menu">
                    <li>
                        <a href="mailto:hola@vauchis.com">hola@vauchis.com</a>
                    </li>
                    <li>
                        <a href="#">Instagram</a>
                    </li>
                    <li>
                        <a href="#">LinkedIn</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="v-footer__bottom">
            <div>
                © {{ date('Y') }} Vauchis · Todos los derechos reservados
            </div>

            <div class="v-footer__social">
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-envelope"></i></a>
            </div>
        </div>
    </div>
</footer>
