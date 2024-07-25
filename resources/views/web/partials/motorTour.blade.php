<div class="banner-form wow fadeInUp" data-wow-delay="300ms">
    <div class="container">
        {{-- TABS --}}
        <div class="tab-content" id="myTabContent">
            {{-- ACTIVIDADES --}}
            <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                tabindex="0">
                <form id="formbuscadorTours" class="motores" action="{{ route('toursResult') }}"
                    method="get">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="banner-form__control">
                                <label for="location">Destino</label>
                                <input type="hidden" name="lang" id="lang" value="es">
                                <input type="hidden" name="nombreDestinoTour" id="nombreDestinoTour" />
                                <select id="buscador2" name="idDestinoTour" class="form-control" required>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="text-center">
                            <div class="col-lg-4 col-md-6 col-sm-12 mx-auto">
                                <button type="submit" aria-label="search submit" class="trevlo-btn trevlo-btn--base">
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
