<div class="modal fade" id="modalAyuda" tabindex="-1" aria-labelledby="modalAyudaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered vh-help-dialog">
        <div class="modal-content vh-help-modal">
            <div class="vh-help-watermark" aria-hidden="true">
                <img src="{{ asset('images/ayuda/regalo_grande_fondo.png') }}" alt="">
            </div>

            <div class="vh-help-header">
                <div class="vh-help-brand" id="modalAyudaLabel">
                    <img class="vh-help-brand__icon-img" src="{{ asset('images/ayuda/icono-ayuda-azul.png') }}" alt="">
                    <span>COMO SE USA VAUCHIS</span>
                </div>

                <button type="button" class="vh-help-close" data-bs-dismiss="modal" aria-label="Cerrar">
                    <span></span><span></span>
                </button>
            </div>

            <div class="vh-help-stage">
                {{-- PASO 1 --}}
                <section class="vh-help-step is-active" data-step="1">
                    <div class="vh-help-heading">
                        <h2>¿Qué vas a regalar?</h2>
                        <p>Elegí el tipo de propuesta que querés regalar.</p>
                    </div>

                    <div class="vh-help-categories">
                        <button type="button" class="vh-help-category vh-help-category--objects" data-help-category="objetos">
                            <span class="vh-help-category__title">Objetos</span>
                            <img class="vh-help-category__image" src="{{ asset('images/ayuda/ic-regalo.png') }}" alt="">
                        </button>

                        <button type="button" class="vh-help-category vh-help-category--experiences" data-help-category="experiencias">
                            <span class="vh-help-category__title">Experiencias</span>
                            <img class="vh-help-category__image" src="{{ asset('images/ayuda/ic-camara.png') }}" alt="">
                        </button>
                    </div>
                </section>

                {{-- PASO 2 --}}
                <section class="vh-help-step" data-step="2">
                    <div class="vh-help-heading">
                        <h2>Elegí un rubro</h2>
                        <p>Encontrá opciones que te inspiren</p>
                    </div>

                    <div class="vh-help-rubros" aria-hidden="true">
                        <img src="{{ asset('images/ayuda/rubros.png') }}" alt="">
                    </div>
                </section>

                {{-- PASO 3 --}}
                <section class="vh-help-step" data-step="3">
                    <div class="vh-help-heading vh-help-heading--compact">
                        <h2>Elegí tu voucher</h2>
                        <p>Elegí cómo querés regalar</p>
                    </div>

                    <div class="vh-help-vouchers">
                        <article class="vh-help-voucher-card">
                            <div class="vh-help-voucher-card__media">
                                <img src="{{ asset('images/ayuda/perfildemarca-regalo-azul.png') }}" alt="Regalo azul">
                            </div>
                            <div class="vh-help-voucher-card__body">
                                <h3>Monto a elección</h3>
                                <p>Vos elegís cuánto regalar, se canjea por productos o servicios del comercio.</p>
                            </div>
                        </article>

                        <article class="vh-help-voucher-card">
                            <div class="vh-help-voucher-card__media">
                                <img src="{{ asset('images/ayuda/perfildemarca-reglao-verde.png') }}" alt="Regalo verde">
                            </div>
                            <div class="vh-help-voucher-card__body">
                                <h3>Monto fijo</h3>
                                <p>Elegí un monto fijo sugerido por el local.</p>
                            </div>
                        </article>

                        <article class="vh-help-voucher-card">
                            <div class="vh-help-voucher-card__media">
                                <img src="{{ asset('images/ayuda/imagen_chicas.png') }}" alt="Servicio específico">
                            </div>
                            <div class="vh-help-voucher-card__body">
                                <h3>Servicio específico</h3>
                                <p>Regalá una propuesta concreta: un producto o servicio pensado para sorprender.</p>
                            </div>
                        </article>

                        <article class="vh-help-voucher-card">
                            <div class="vh-help-voucher-card__media">
                                <img src="{{ asset('images/ayuda/imagen_bolso.png') }}" alt="Producto específico">
                            </div>
                            <div class="vh-help-voucher-card__body">
                                <h3>Producto específico</h3>
                                <p>Regalá un producto específico con precio de referencia.</p>
                            </div>
                        </article>
                    </div>
                </section>

                {{-- PASO 4 --}}
                <section class="vh-help-step" data-step="4">
                    <div class="vh-help-heading vh-help-heading--solo">
                        <h2>Personalizá tu regalo</h2>
                    </div>

                    <div class="vh-help-personalize" data-personalize-carousel>
                        <div class="vh-help-personalize__slide is-active">
                            <div class="vh-help-personalize__row"><span>PARA</span><strong>Sofía</strong></div>
                            <div class="vh-help-personalize__row"><span>DE</span><strong>Juan</strong></div>
                            <div class="vh-help-personalize__message">¡Feliz cumple!</div>
                        </div>
                        <div class="vh-help-personalize__slide">
                            <div class="vh-help-personalize__row"><span>PARA</span><strong>Mamá</strong></div>
                            <div class="vh-help-personalize__row"><span>DE</span><strong>Luisa</strong></div>
                            <div class="vh-help-personalize__message">¡Feliz día!</div>
                        </div>
                        <div class="vh-help-personalize__slide">
                            <div class="vh-help-personalize__row"><span>PARA</span><strong>Jo</strong></div>
                            <div class="vh-help-personalize__row"><span>DE</span><strong>Tomás</strong></div>
                            <div class="vh-help-personalize__message">¡Felicidades amigo!</div>
                        </div>
                    </div>
                </section>

                {{-- PASO 5 --}}
                <section class="vh-help-step" data-step="5">
                    <div class="vh-help-heading">
                        <h2>Tu regalo,<br>listo para compartir</h2>
                        <p>Pagá con Mercado Pago y enviá el voucher a quien quieras.</p>
                    </div>

                    <div class="vh-help-payment" data-payment-carousel>
                        <div class="vh-help-payment__slide is-active vh-help-payment__slide--mp">
                            <img class="vh-help-payment__asset vh-help-payment__asset--mp" src="{{ asset('images/ayuda/paga_mercadopago.png') }}" alt="Pagá con Mercado Pago">
                        </div>
                        <div class="vh-help-payment__slide vh-help-payment__slide--gift">
                            <img class="vh-help-payment__asset vh-help-payment__asset--gift" src="{{ asset('images/ayuda/perfildemarca-reglao-verde.png') }}" alt="Regalo listo">
                        </div>
                    </div>
                </section>

                {{-- PASO 6 --}}
                <section class="vh-help-step" data-step="6">
                    <div class="vh-help-final">
                        <div class="vh-help-final__copy">
                            <h2>¡Listo!</h2>
                            <p>Tu regalo está listo para canjear en el local que elegiste.</p>

                            <div class="vh-help-qr-card">
                                <img class="vh-help-qr-img" src="{{ asset('images/ayuda/qr_vauchis.png') }}" alt="Código QR">
                                <span>Mostrando el QR<br>queda canjeado</span>
                            </div>
                        </div>

                        <div class="vh-help-phone-wrap" aria-hidden="true">
                            <img class="vh-help-rulo vh-help-rulo--blue" src="{{ asset('images/ayuda/rulo_azul.png') }}" alt="">
                            <img class="vh-help-rulo vh-help-rulo--pink-small" src="{{ asset('images/ayuda/rulo_rosado_chico.png') }}" alt="">
                            <img class="vh-help-rulo vh-help-rulo--pink-large" src="{{ asset('images/ayuda/rulo_rosado_grande.png') }}" alt="">
                            <img class="vh-help-star-img vh-help-star-img--large" src="{{ asset('images/ayuda/estrealla_amarilla.png') }}" alt="">
                            <img class="vh-help-star-img vh-help-star-img--small" src="{{ asset('images/ayuda/estrella_amarilla_chiquita.png') }}" alt="">
                            <img class="vh-help-phone-img" src="{{ asset('images/ayuda/celular.png') }}" alt="Voucher en celular">
                        </div>
                    </div>
                </section>
            </div>

            <div class="vh-help-footer">
                <button type="button" class="vh-help-nav vh-help-nav--prev" data-help-prev>
                    <span>‹</span> Volver
                </button>

                <div class="vh-help-dots" aria-label="Progreso">
                    @for ($i = 1; $i <= 6; $i++)
                        <button type="button" class="vh-help-dot{{ $i === 1 ? ' is-active' : '' }}" data-help-dot="{{ $i }}" aria-label="Ir al paso {{ $i }}"></button>
                    @endfor
                </div>

                <button type="button" class="vh-help-nav vh-help-nav--next" data-help-next>
                    <span data-help-next-label>Siguiente</span> <span>›</span>
                </button>
            </div>
        </div>
    </div>
</div>
