<section class="cta-three distintivo pt-5">
    <div class="footer_textura_arrugada"></div>
    <div class="container overflow_hiden text-center">
        <div class="distintivos_text_container">
            <h2 class="cta-three__title correcion-pedrito-21 distintivos">Certificaciones</h2>
            <h5 class="cta-three__sub-title correcion-pedrito-22 distintivos">Viaja con toda confianza sabiendo que tenemos Certificaciones avaladas por el Gobierno como profesionales del Turismo</h5>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="cta-three__image distintivos">
                    <div class="pricing-page__carousel trevlo-owl__carousel owl-theme owl-carousel  distintivos">
                        @foreach ($distintivos['result'] as $i => $distintivo)
                            @if ($distintivo['link'] == '')
                                <div class="client-carousel__one__item">
                                    <img class="client-carousel__one__item__normal" src="{{ $distintivo['imagen'] }}"
                                        alt="{{ $distintivo['nombre'] }}">
                                </div>
                            @else
                                <div class="client-carousel__one__item">
                                    <a href="{{ $distintivo['link'] }}" target="_blank">
                                        <img class="client-carousel__one__item__normal"
                                            src="{{ $distintivo['imagen'] }}" alt="{{ $distintivo['nombre'] }}">
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- <div class="col-lg-12">
                <div class="cta-three__content" style="background-image: url('{{asset('assets/images/texturas/funtastic-textur-08.webp')}}'); background-color: white">
                    <div class="cta-three__content__inner">
                        <div class="cta-three__content__inner__bg"
                            style="background-image: url(assets/images/shapes/cta-3-3.png);"></div>
                        <h2 class="cta-three__title correcion-pedrito-21">Certificaciones!</h2>
                        <h5 class="cta-three__sub-title correcion-pedrito-22">Viaja con total confianza sabiendo que tenemos certificaciones que nos avalan como profesionales
                            del turismo certificados ante el gobierno</h5>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
</section>
