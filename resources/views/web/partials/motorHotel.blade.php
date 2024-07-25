<!--Motor de busqueda del index Hotel-->
<div id="superbuscador" class="search-bar bottom motorHotel" style="background-color: #010440;">

    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#hoteles" class="py-2" data-toggle="tab">Hoteles</a></li>
    </ul>

    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="hoteles">
            <form id="formbuscador" action="{{ route('listaHoteles') }}" method="get">

                <div class="col-sm-2 mt-3 text-wrap">

                </div>

                <div class="col-sm-8 row">
                    <div class="col-sm-4 mt-2 form-group">
                        <label>Destino</label>
                        <input type="hidden" name="lang" id="lang" value="es">
                        <input type="hidden" name="nombreDestinoHotelero" id="nombreDestinoHotelero"
                            value="{{ isset($nombreDestino) ? $nombreDestino : '' }}" />
                        <select autocomplete="off" name="destinoHotelero" id="buscador1" class="form-control" required
                            style="background-color: #f47520; color:white; width: 100%;">
                            @if (isset($nombreDestino))
                                <option value="{{ $idregion }}">{{ $nombreDestino }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-4 mt-2 form-group">
                        <label>Fechas</label>
                        <input type="hidden" id="checkin" name="checkin"
                            value="{{isset($checkinDate) ? $checkinDate : '' }}">
                        <input type="hidden" id="checkout" name="checkout"
                            value="{{isset($checkoutDate) ? $checkoutDate : '' }}">
                        <input autocomplete="off" type="text" id="fechas" class="form-control" readonly>
                    </div>
                    <div class="col-sm-2 mt-2 form-group">
                        <label>Adultos</label>
                        <select autocomplete="off" name="adultos" class="form-control selectpicker">
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" @if (isset($adultos) && $adultos == $i) selected @endif>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="col-sm-2 mt-2 form-group">
                        <label>Menores</label>
                        <select autocomplete="off" name="menores" class="form-control selectpicker" id="menores"
                            onchange="menoresEdadesPedrito(value)">
                            @for ($i = 0; $i <= 4; $i++)
                                <option value="{{ $i }}" @if (isset($menoresInput) && $menoresInput == $i) selected @endif>
                                    {{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="containerMotorHotelInputs">
                            <div id="edad1" class="mb-4 col-xs-6 col-sm-2" @if(count($menoresarray) < 1) style="display: none;" @endif>
                                <label>Edad</label>
                                <input disabled name="edad[]" class="form-control" type="number" placeholder="Ingrese"
                                    min="1" max="16" value="{{array_key_exists('0', $menoresarray) ? $menoresarray[0] : ''}}" required />
                            </div>
                            <div id="edad2" class="col-xs-6 col-sm-2" @if(count($menoresarray) < 2) style="display: none;" @endif>
                                <label>Edad</label>
                                <input disabled name="edad[]" class="form-control" type="number" placeholder="Ingrese"
                                    min="1" max="16" value="{{array_key_exists('1', $menoresarray) ? $menoresarray[1] : ''}}" required />
                            </div>
                            <div id="edad3" class="col-xs-6 col-sm-2" @if(count($menoresarray) < 3) style="display: none;" @endif>
                                <label>Edad</label>
                                <input disabled name="edad[]" class="form-control" type="number" placeholder="Ingrese"
                                    min="1" max="16" value="{{array_key_exists('2', $menoresarray) ? $menoresarray[2] : ''}}" required />
                            </div>
                            <div id="edad4" class="col-xs-6 col-sm-2" @if(count($menoresarray) < 4) style="display: none;" @endif>
                                <label>Edad</label>
                                <input disabled name="edad[]" class="form-control" type="number" placeholder="Ingrese"
                                    min="1" max="16" value="{{array_key_exists('3', $menoresarray) ? $menoresarray[3] : ''}}" required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 containerMotorHotelInputs">
                        <div class="col-sm-2">
                            <button style="margin-top: 23px; border-radius:10px;"
                                class="btn btn-search btn-warning button__input">Buscar</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>