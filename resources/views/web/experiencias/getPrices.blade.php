@php
    use App\Http\Controllers\Web\FnController;
    $fn = new FnController();
@endphp

<input type="hidden" id="descuento" name="descuento" value="{{ $grales == 1 ? $generales[0]->descuento : '' }}">
<input type="hidden" id="tipo_descuento" name="tipo_descuento" value="{{ $grales == 1 ? $generales[0]->tipo_descuento : '' }}">
<input type="hidden" id="valor_promocion" name="valor_promocion" value="{{ $grales == 1 ? $generales[0]->valor_promocion : '' }}">
<input type="hidden" id="paxes_promocion" name="paxes_promocion" value="{{ $grales == 1 ? $generales[0]->paxes_promocion : '' }}">
<input type="hidden" id="mostrarpromo" name="mostrarpromo" value="{{ $mostrarpromo }}">
<input type="hidden" id="nombre" name="nombredescuento" value="{{ $grales == 1 ? $generales[0]->nombreDescuento : '' }}">
<input type="hidden" id="idpromo" name="idpromo" value="{{ $grales == 1 ? $generales[0]->id : '' }}">
<input type="hidden" id="idexpromo" name="idexpromo" value="{{ $grales == 1 ? $generales[0]->idexpromo : '' }}">

@if (count($precios) > 0)
    <script>
        $("#btngetprices").prop("disabled", false);
        $("#tickets").removeClass("oculto");
    </script>
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th scope="col" class="tituloPax">ADULTOS</th>
                <th scope="col" class="tituloPax">MENORES</th>
                <th scope="col" class="tituloPax">INFANTES</th>
            </tr>
        </thead>
        <tbody>
            @if ($generales != 0 && $mostrarpromo == 1)
                {{-- Tarifas promocionales --}}
                <tr>
                    <td style="background-color: #c7dff2; color:black;">
                        <p class="text-center precios">
                            <label>
                                @php
                                    if ($promocion[0]['descuento'] == 1) {
                                        if ($promocion[0]['tipo_descuento'] == 1) {
                                            //Porcentaje
                                            $precioAdulto   = $precios[0]->adulto_sencilla - $precios[0]->adulto_sencilla * ($promocion[0]['valor_promocion'] / 100);
                                        } else {
                                            //Monto
                                            $precioAdulto   = $precios[0]->adulto_sencilla - $promocion[0]['valor_promocion'];
                                        }
                                    
                                        $precioAdultoNormal = $fn->precio($precios[0]->adulto_sencilla, $precios[0]->iso, $monedaSeleccionada, $monedaDefault, $monedas);
                                        $precioAdulto       = $fn->precio($precioAdulto, $precios[0]->iso, $monedaSeleccionada, $monedaDefault, $monedas);
                                    
                                        echo '<span class="">$ ' . $precioAdultoNormal['precioformato'] . ' ' . $precioAdultoNormal['iso'] . '</span><br>';
                                        // echo '<span class="">$ ' . $precioAdulto['precioformato'] . ' ' . $precioAdulto['iso'] . '</span><br>';
                                    } else {
                                        echo "$ " . $precioAdulto['precioformato'] . ' ' . $precioAdulto['iso'];
                                    }
                                @endphp
                            </label>
                        </p>
                        <input type="hidden" id="adulto_precio" value="{{ $precioAdultoNormal['preciosimple'] }}">
                        <input type="hidden" id="adulto_precio_promo" value="{{ $precioAdulto['preciosimple'] }}">
                    </td>

                    <td style="background-color: #c7dff2; color:black;">
                        <p class="text-center precios">
                            <label>
                                @php
                                    if ($promocion[0]['descuento'] == 1) {
                                        if ($promocion[0]['tipo_descuento'] == 1) {
                                            //Porcentaje
                                            $precioMenor = $precios[0]->menor_sencilla - $precios[0]->menor_sencilla * ($promocion[0]['valor_promocion'] / 100);
                                        } else {
                                            //Monto
                                            $precioMenor = $precios[0]->menor_sencilla - $promocion[0]['valor_promocion'];
                                        }
                                    
                                        $precioMenorNormal = $fn->precio($precios[0]->menor_sencilla, $precios[0]->iso, $monedaSeleccionada, $monedaDefault, $monedas);
                                        $precioMenor = $fn->precio($precioMenor, $precios[0]->iso, $monedaSeleccionada, $monedaDefault, $monedas);
                                    
                                        echo '<span class="">$ ' . $precioMenorNormal['precioformato'] . ' ' . $precioMenorNormal['iso'] . '</span><br>';
                                        // echo '<span class="">$ ' . $precioMenor['precioformato'] . ' ' . $precioMenor['iso'] . '</span><br>';
                                    } else {
                                        $precioMenor = $fn->precio($precios[0]->menor_sencilla, $precios[0]->iso, $monedaSeleccionada, $monedaDefault, $monedas);
                                        echo "$ " . $preciomenor['precioformato'] . ' ' . $preciomenor['iso'];
                                    }
                                @endphp
                            </label>
                        </p>
                        <input type="hidden" id="menor_precio" value="{{ $precioMenorNormal['preciosimple'] }}">
                        <input type="hidden" id="menor_precio_promo" value="{{ $precioMenor['preciosimple'] }}">
                    </td>

                    <td style="background-color: #c7dff2; color:black;">
                        <p class="text-center precios">
                            <label>
                                @php
                                    if ($promocion[0]['descuento'] == 1) {
                                        if ($promocion[0]['tipo_descuento'] == 1) {
                                            //Porcentaje
                                            $precioInfante = $precios[0]->infante_sencilla - $precios[0]->infante_sencilla * ($promocion[0]['valor_promocion'] / 100);
                                        } else {
                                            //Monto
                                            $precioInfante = $precios[0]->infante_sencilla - $promocion[0]['valor_promocion'];
                                        }
                                    
                                        $precioInfanteNormal = $fn->precio($precios[0]->infante_sencilla, $precios[0]->iso, $monedaSeleccionada, $monedaDefault, $monedas);
                                        $precioInfante = $fn->precio($precioInfante, $precios[0]->iso, $monedaSeleccionada, $monedaDefault, $monedas);
                                    
                                        echo '<span class="">$ ' . $precioInfanteNormal['precioformato'] . ' ' . $precioInfanteNormal['iso'] . '</span><br>';
                                        // echo '<span class="">$ ' . $precioInfante['precioformato'] . ' ' . $precioInfante['iso'] . '</span><br>';
                                    } else {
                                        $precioInfante = $fn->precio($precios[0]->infante_sencilla, $precios[0]->iso, $monedaSeleccionada, $monedaDefault, $monedas);
                                        echo "$ " . $precioInfante['precioformato'] . ' ' . $precioInfante['iso'];
                                    }
                                @endphp
                            </label>
                        </p>
                        <input type="hidden" id="infante_precio" value="{{ $precioInfanteNormal['preciosimple'] }}">
                        <input type="hidden" id="infante_precio_promo" value="{{ $precioInfante['preciosimple'] }}">
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        {!! '<b class="text-danger">' . $promocion[0]['mensaje'] . '</b>' . '<br><b>Promoción válida a partir de ' . $promocion[0]['paxes_promocion'] . ' persona(s)</b>' !!}
                        {!! '<br>' . $txtFechaPromo !!}
                    </td>
                </tr>
            @else
                @php
                    //NO TIENE PROMOCION
                    $precioAdulto  = $fn->precio($precios[0]->adulto_sencilla,  $precios[0]->iso, $monedaSeleccionada, $monedaDefault, $monedas);
                    $precioMenor   = $fn->precio($precios[0]->menor_sencilla,   $precios[0]->iso, $monedaSeleccionada, $monedaDefault, $monedas);
                    $precioInfante = $fn->precio($precios[0]->infante_sencilla, $precios[0]->iso, $monedaSeleccionada, $monedaDefault, $monedas);                    
                @endphp
                <tr>
                    <td class="tdPrecios">
                        <p class="text-center precios">$ 
                            <label id="menorescostoscuadruple_1">{{ $precioAdulto['precioformato'] }}</label>
                            {{ $precioAdulto['iso'] }}
                        </p>
                        <input type="hidden" id="adulto_precio" value="{{ $precioAdulto['preciosimple'] }}">
                    </td>

                    <td class="tdPrecios">
                        <p class="text-center precios">$ 
                            <label id="menorescostostriple_1">{{ $precioMenor['precioformato'] }}</label>
                            {{ $precioMenor['iso'] }}</p>
                        <input type="hidden" id="menor_precio" value="{{ $precioMenor['preciosimple'] }}">
                    </td>

                    <td class="tdPrecios">
                        <p class="text-center precios">$ 
                            <label id="menorescostosdoble_1">{{ $precioInfante['precioformato'] }}</label>
                            {{ $precioInfante['iso'] }}</p>
                        <input type="hidden" id="infante_precio" value="{{ $precioInfante['preciosimple'] }}">
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
@else
    <script>
        $("#btngetprices").prop("disabled", true);
        $("#tickets").addClass("oculto");
    </script>
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th scope="col" style="background-color:#f1f1f1">ADULTOS</th>
                <th scope="col" style="background-color:#f1f1f1">MENORES</th>
                <th scope="col" style="background-color:#f1f1f1;">INFANTES</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="3" style="background-color: #c7dff2; color:black;">
                    <p class="text-center">La fecha seleccionada no tiene disponibilidad</p>
                </td>
            </tr>
        </tbody>
    </table>
@endif
