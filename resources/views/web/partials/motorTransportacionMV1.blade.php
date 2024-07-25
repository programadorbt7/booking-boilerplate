<div class="banner-form wow fadeInUp" data-wow-delay="300ms">
    <div class="container">
        {{-- TABS --}}
        <div class="tab-content" id="myTabContent">
            {{-- TRANSPORTE --}}
            <div class="tab-pane fade show active" id="transporte" role="tabpanel" aria-labelledby="profile-tab"
                tabindex="0">
                <form class="motores" id="formbuscadorTransporte" action="{{ route('transportation-list') }}"
                    method="get">
                    {{-- SERVICIO & PERSONAS --}}
                    <div class="row">
                        {{-- SERVICIO --}}
                        <div class="col-md-6 col-sm-12">
                            <div class="banner-form__control">
                                <label class="bold " for="tipoServicio">Servicio</label>
                                <select name="tipoServicio" id="tipoServicio" class="form-control">
                                    <option value="1" {{ $tipoServicio == '1' ? 'selected' : '' }}>Sencillo
                                    </option>
                                    <option value="2" {{ $tipoServicio == '2' ? 'selected' : '' }}>Redondo</option>
                                </select>
                            </div>
                        </div>
                        {{-- ADULTOS --}}
                        <div class="col-md-3 col-sm-6">
                            <div class="banner-form__control">
                                <label class="bold ">Adultos</label>
                                <select class="form-control border-azul" name="adultosTrans" id="adultosTrans">
                                    <option value="1">1</option>
                                    @for ($i = 2; $i <= 10; $i++)
                                        <option value="{{ $i }}"
                                            @if ($adultos == $i) {{ 'selected' }} @endif>
                                            {{ $i }} </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        {{-- MENORES --}}
                        <div class="col-md-3 col-sm-6">
                            <div class="banner-form__control">
                                <label class="bold ">Menores</label>
                                <select class="form-control border-azul" name="menoresTrans" id="menoresTrans">
                                    <option value="0">0</option>
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}"
                                            @if ($menores == $i) {{ 'selected' }} @endif>
                                            {{ $i }} </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                    {{-- ORIGEN & DESTINO --}}
                    <div class="row">
                        {{-- ORIGEN --}}
                        <div class="col-md-6 col-sm-12">
                            <div class="banner-form__control">
                                <label class="bold " for="origenTransporte">Origen</label>
                                <input type="text" class="form-control" id="origenTransporte" name="origenTransporte"
                                    required placeholder="Escribe un origen" value="{{ $origenTransporte }}"
                                    onchange="verificarDestinos()">
                                <input type="hidden" name="nombreOrigenTransporte" id="nombreOrigenTransporte"
                                    value="{{ $nombreOrigenTransporte }}">
                                <input type="hidden" name="idOrigenTransporte" id="idOrigenTransporte"
                                    value="{{ $idOrigenTransporte }}">
                                <!-- id de la zona -->
                                <input type="hidden" name="idZonaOrigen" id="idZonaOrigen"
                                    value="{{ $idZonaOrigen }}">
                                {{-- animacion de carga --}}
                                <div id="loadOrigenNames" class="oculto">
                                    <div class="lds-facebook">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- DESTINO --}}
                        <div class="col-md-6 col-sm-12">
                            <div class="banner-form__control">
                                <label class="bold " for="destinoTransporte">Destino</label>
                                <input type="text" class="form-control" id="destinoTransporte"
                                    name="destinoTransporte" required placeholder="Escribe un destino"
                                    value="{{ $destinoTransporte }}" onchange="verificarDestinos()">
                                <input type="hidden" name="nombreDestinoTransporte" id="nombreDestinoTransporte"
                                    value="{{ $nombreDestinoTransporte }}">
                                <input type="hidden" name="idDestinoTransporte" id="idDestinoTransporte"
                                    value="{{ $idDestinoTransporte }}">
                                <input type="hidden" name="idZonaDestino" id="idZonaDestino"
                                    value="{{ $idZonaDestino }}">
                                <div id="loadDestinoNames" class="oculto">
                                    <div class="lds-facebook">
                                        <div></div>
                                        <div></div>
                                        <div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    {{-- FECHAS --}}
                    <div class="row">
                        {{-- LLEGADA --}}
                        <div class="col-md-6 col-sm-12">
                            <div class="banner-form__control">
                                <label class="bold " for="fechaLlegada">Llegada</label>
                                <input type="text" class="form-control" name="fechaLlegada" id="fechaLlegada"
                                    value="{{ $fechaLlegada }}">
                            </div>
                        </div>
                        {{-- REGRESO --}}
                        <div id="fechaRegreso" class="col-md-6 col-sm-6 {{ $tipoServicio == 1 ? 'oculto' : '' }}">
                            <div class="banner-form__control">
                                <label class="bold " for="fechaSalida">Regreso</label>
                                <input type="text" class="form-control" name="fechaSalida" id="fechaSalida"
                                    value="{{ isset($fechaSalida) ? $fechaSalida : '' }}">
                            </div>
                        </div>
                    </div>
                    <br>
                    {{-- BTN --}}
                    <div class="row mt-2">
                        <div class="text-center">
                            <div class="col-lg-4 col-md-6 col-sm-12 mx-auto">
                                <button id="btn-transporte" type="submit" aria-label="search submit"
                                    class="trevlo-btn trevlo-btn--base">
                                    <span><i aria-hidden="true" class="icon-search"></i> Buscar</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
