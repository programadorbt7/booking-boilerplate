<div class="banner-form wow fadeInUp" data-wow-delay="300ms">
    <div class="container">
        {{-- TABS --}}
        <div class="tab-content" id="myTabContent">
            {{-- HOTEL --}}
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                tabindex="0">
                <form class="motores" id="formbuscador" method="get">
                    {{-- GENERAL --}}
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="banner-form__control">
                                <label for="location">Destino</label>
                                <input type="hidden" name="lang" id="lang" value="es">
                                <input type="hidden" name="nombreDestinoHotelero" id="nombreDestinoHotelero"
                                    value="{{ isset($vars['nombreDestinoHotelero']) ? $vars['nombreDestinoHotelero'] : '' }}" />
                                <select autocomplete="off" name="destinoHotelero" id="buscador1" class="form-control"
                                    required>
                                    @if (isset($vars['nombreDestinoHotelero']))
                                        <option value="{{ $vars['destinoHotelero'] }}">
                                            {{ $vars['nombreDestinoHotelero'] }}</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="banner-form__control">
                                <label for="type">Fecha</label>
                                <input type="hidden" id="checkin" name="checkin"
                                    value="{{ isset($vars['checkin']) ? $vars['checkin'] : '' }}">
                                <input type="hidden" id="checkout" name="checkout"
                                    value="{{ isset($vars['checkout']) ? $vars['checkout'] : '' }}">
                                <input autocomplete="off" type="text" id="fechas" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="banner-form__control">
                                <label>Adultos</label>
                                <select autocomplete="off" name="adultos" class="form-control" id="adultos">
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}"
                                            @if (isset($vars['adultos']) && $vars['adultos'] == $i) selected @endif>
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="banner-form__control">
                                <label>Menores</label>
                                <select autocomplete="off" name="menores" class="form-control" id="menores"
                                    onchange="menoresEdadesPedrito(value)">
                                    @for ($i = 0; $i <= 4; $i++)
                                        <option value="{{ $i }}"
                                            @if (isset($vars['menores']) && $vars['menores'] == $i) selected @endif>
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    {{-- MENORES INDIVIDUAL --}}
                    <div class="row mt-2">
                        <div id="edad1" class="col-md-3 col-sm-6 oculto">
                            <div class="banner-form__control">
                                <label>Menor 1</label>
                                <select disabled name="edad[]" class="form-control " placeholder="Ingrese edad"
                                    required>
                                    @for ($i = 0; $i <= 17; $i++)
                                        <option value="{{ $i }}"
                                            @if (isset($vars['edad'][0]) && $vars['edad'][0] == $i) selected @endif>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div id="edad2" class="col-md-3 col-sm-6 oculto">
                            <div class="banner-form__control">
                                <label>Menor 2</label>
                                <select disabled name="edad[]" class="form-control " placeholder="Ingrese" required>
                                    @for ($i = 0; $i <= 17; $i++)
                                        <option value="{{ $i }}"
                                            @if (isset($vars['edad'][1]) && $vars['edad'][1] == $i) selected @endif>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div id="edad3" class="col-md-3 col-sm-6 oculto">
                            <div class="banner-form__control">
                                <label>Menor 3</label>
                                <select disabled name="edad[]" class="form-control " placeholder="Ingrese" required>
                                    @for ($i = 0; $i <= 17; $i++)
                                        <option value="{{ $i }}"
                                            @if (isset($vars['edad'][2]) && $vars['edad'][2] == $i) selected @endif>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div id="edad4" class="col-md-3 col-sm-6 oculto">
                            <div class="banner-form__control">
                                <label>Menor 4</label>
                                <select disabled name="edad[]" class="form-control " placeholder="Ingrese" required>
                                    @for ($i = 0; $i <= 17; $i++)
                                        <option value="{{ $i }}"
                                            @if (isset($vars['edad'][3]) && $vars['edad'][3] == $i) selected @endif>
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    {{-- BTN --}}
                    <div class="row mt-2">
                        <div class="text-center">
                            <div class="col-lg-4 col-md-6 col-sm-12 mx-auto">
                                <button id="buttonSearch" onclick="event.preventDefault();getHoteleria()" type="submit"
                                    aria-label="Buscar hoteles" class="trevlo-btn trevlo-btn--base">
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
