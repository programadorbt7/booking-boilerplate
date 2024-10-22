<div class="banner-form">
    <div class="container">

        <ul class="nav nav-tabs justify-content-center border-0" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane"
                    type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                    <i aria-hidden="true" class="fa-solid fa-hotel"></i>
                    Hoteles</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane"
                    type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                    <i aria-hidden="true" class="fa-solid fa-person-walking-luggage"></i>
                    Tours</button>
            </li>
        </ul>
        {{-- TABS --}}
        <div class="tab-content" id="myTabContent">
            {{-- HOTEL --}}
            <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                tabindex="0">
                <form class="banner-form__wrapper" id="formbuscador" action="{{ route('listaHoteles') }}"
                    method="get">
                    {{-- GENERAL --}}
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="banner-form__control">
                                <label for="location">Destino</label>
                                <input type="hidden" name="lang" id="lang" value="es">
                                <input type="hidden" name="nombreDestinoHotelero" id="nombreDestinoHotelero" />
                                <select autocomplete="off" name="destinoHotelero" id="buscador1" required></select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="banner-form__control">
                                <label for="type">Fecha</label>
                                <input type="hidden" id="checkin" name="checkin">
                                <input type="hidden" id="checkout" name="checkout">
                                <input autocomplete="off" type="text" id="fechas" class="form-control" readonly>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="banner-form__control">
                                <label for="date">Adultos</label>
                                <select autocomplete="off" name="adultos" class="form-control ">
                                    <option value="1" selected>1</option>
                                    @for ($i = 2; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6">
                            <div class="banner-form__control">
                                <label for="guests">Menores</label>
                                <select autocomplete="off" name="menores" class="form-control " id="menores"
                                    onchange="menoresEdadesPedrito(value)">
                                    <option value="0" selected>0</option>
                                    @for ($i = 1; $i <= 4; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
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
                                <select disabled required class="form-control " name="edad[]">
                                    <option value="" disabled selected>Selecciona</option>
                                    @for ($i = 0; $i <= 17; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div id="edad2" class="col-md-3 col-sm-6 oculto">
                            <div class="banner-form__control">
                                <label>Menor 2</label>
                                <select disabled required class="form-control " name="edad[]">
                                    <option value="" disabled selected>Selecciona</option>
                                    @for ($i = 0; $i <= 17; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div id="edad3" class="col-md-3 col-sm-6 oculto">
                            <div class="banner-form__control">
                                <label>Menor 3</label>
                                <select disabled required class="form-control " name="edad[]">
                                    <option value="" disabled selected>Selecciona</option>
                                    @for ($i = 0; $i <= 17; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div id="edad4" class="col-md-3 col-sm-6 oculto">
                            <div class="banner-form__control">
                                <label>Menor 4</label>
                                <select disabled required class="form-control " name="edad[]">
                                    <option value="" disabled selected>Selecciona</option>
                                    @for ($i = 0; $i <= 17; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                    {{-- BTN --}}
                    <div class="row mt-2">
                        <div class="text-center">
                            <div class="col-lg-4 col-md-6 col-sm-12 mx-auto">
                                <button type="submit" aria-label="search submit" class="trevlo-btn">
                                    <span>Buscar</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {{-- ACTIVIDADES --}}
            <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                tabindex="0">
                <form id="formbuscadorTours" class="banner-form__wrapper" action="{{ route('toursResult') }}"
                    method="get">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="banner-form__control">
                                <label for="location">Destino</label>
                                <input type="hidden" name="lang" id="lang" value="es">
                                <input type="hidden" name="nombreDestinoTour" id="nombreDestinoTour" />
                                <select id="buscador2" name="idDestinoTour" class="form-control" required>
                                    <option value="">1</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="text-center">
                            <div class="col-lg-4 col-md-6 col-sm-12 mx-auto">
                                <button type="submit" aria-label="search submit" class="trevlo-btn">
                                    <span>Buscar</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
