@php
    use App\Http\Controllers\Web\FnController;
    use Carbon\Carbon;
    $fn = new FnController();
@endphp

@extends('layouts.master')

@section('metaSEO')
    <title>{{ $nombreDestino }} - {{ $nameEnterprise }}</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
@endsection

@section('contenido-principal')

    <button onclick="openCloseNav()" type="button" class="btn btn-warning p-fixed boton-filtros"
        style="position: fixed; top: 90%;left: 50%; transform: translateX(-50%); z-index: 900; opacity: 0.8;">
        <i aria-hidden="true" class="fa fa-filter"></i>
    </button>

    <script>
        var nombresHotels = [];
    </script>
    <article>

        <div class="main-banner-1" style="background-image: linear-gradient(rgba(0, 0, 0, 0.30), rgba(0, 0, 0, 0.30)), url('{{ asset('assets/images/tour/tour-4.jpg')}} ')";>
            <div class="item">
                <div class="site-breadcumb ">
                    <div class="container ">
                        <div class="title-wrap-2">
                            <h2 class="section-title" style="text-align: center;"> Hospédate en {{ $nombreDestino }} </h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="search-wrap">
                <div class="container">
                  @include('web.partials.motorHotel')
                </div>
            </div>
        </div>
        
        <section class="sec-space">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4">
                        <div id="filtros-nav" class="sidebar" style="list-style:none; z-index:899;">
                            <div class="border-box">
                                <div class="box-title">Búsqueda de hoteles</div>
                                <div style="display: flex;">
                                  <input class="form-control textInput" style="border: 1px solid #b4b4b4 !important;" type="text" oninput="return cleanText()"
                                      name="nombreHotel" id="nombreHotel" onkeyup="filtrPorNombre(value)">
                                  <div class="img cleanText" style="display: flex; justify-content: center; align-content: center; margin: 0; padding: 3px;">
                                      <span class="fa fa-close" style="display: flex; justify-content: center; align-content: center; flex-wrap: wrap; cursor: pointer;"></span>
                                  </div>
                              </div>
                            </div>

                            <div class="border-box">
                                <div class="box-title">Popularidad</div>
                                <select id="popularidad" class="form-control niceSelect estilo-ordenamiento">
                                    <option data-sort="length:asc">Popularidad</option>
                                    <option data-sort="price:asc">Precio (bajo a alto)</option>
                                    <option data-sort="price:desc">Precio (alto a bajo)</option>
                                </select>
                            </div>

                            <div class="border-box">
                                <div class="box-title">Estrellas</div>
                                <span id="cantEstrellas">

                                </span>
                            </div>

                            <div class="border-box">
                                <div class="box-title">Alimentos</div>
                                <span id="planAlimentos">
                                </span>
                            </div>
                        </div>
                    </div>
                    @if($statusBusqueda == true)
                    <div class="col-lg-8 col-md-8" style="display: flex; flex-direction: column">
                        <div class="row" style="margin-bottom: 17px; padding: 1.5rem;">
                            <div class="d-flex sort-title" id="hotelesEncontrados" data-total="{{ $hotelesCount }}"
                                style="display: flex; justify-content: flex-end; border: 1px solid red; padding: 10px;">
                                <h3 style="margin-right: 1rem;">{{ $hotelesCount }} hoteles encontrados</h3>
                                <div class="d-flex toogle-view"
                                    style="display: flex; align-content: center; margin: 0; margin-right: 1rem; flex-wrap: wrap;">
                                    <i aria-hidden="true" class="icon fa fa-check active"
                                        style="font-size: 16px; display: flex; font-size: 16px; justify-content: center;"></i>
                                </div>
                            </div>
                        </div>

                        @foreach ($hotelesArray as $conteo => $hotel)
                            <div class="row item-list filaHotel stars_{{ $hotel["stars"] }} meal_{{ $hotel["filtroMeal"] }} {{ $hotel["idhotel"] }}"
                                data-length="{{ $conteo }}" data-price="{{ $hotel["filtroTotalPublico"] }}" data-posicion="">
                                <div class="col-sm-5">
                                  <a href="/{{$hotel["link"]}}">
                                   <img class="lazyload imgResponsiveCard" data-src="{{ $hotel["imgLink"] }}" alt="{{$hotel["hotelName"]}}">
                                  </a>
                                </div>
                                <div class="col-sm-7">
                                    <div class="item-desc">
                                        <!-- NOMBRE DEL HOTEL -->
                                        <h5 class="item-title"><a
                                                href="/{{$hotel["link"]}}">{{ $fn->removeGuionBajo($hotel["hotelName"]) }}</a>
                                        </h5>
                                        <!-- DIRECCIÓN Y ESTRELLAS -->

                                        <div class=" d-inline-flex" style="font-size:13px;">
                                          <div>
                                            <i aria-hidden="true" class="{{$hotel["stars"] >= 1 ? 'text-yellow' : 'text-muted'}} fa fa-star estrellaHotel"></i>
                                            <i aria-hidden="true" classhidden="true" classhidden="true" classhidden="true" classhidden="true" classhidden="true" classhidden="true" class="{{$hotel["stars"] >= 2 ? 'text-yellow' : 'text-muted'}} fa fa-star estrellaHotel"></i>
                                            <i aria-hidden="true" class="{{$hotel["stars"] >= 3 ? 'text-yellow' : 'text-muted'}} fa fa-star estrellaHotel"></i>
                                            <i aria-hidden="true" class="{{$hotel["stars"] >= 4 ? 'text-yellow' : 'text-muted'}} fa fa-star estrellaHotel"></i>
                                            <i aria-hidden="true" class="{{$hotel["stars"] >= 5 ? 'text-yellow' : 'text-muted'}} fa fa-star estrellaHotel"></i>
                                          </div>
                                        </div>
                                        <div class="sub-title">
                                            {{ $hotel["direccion"] }}
                                            <br>
                                            {{ $hotel["allotment"] > 1 ? $hotel["allotment"] . ' habitaciones disponibles' : '1 habitación disponible' }}
                                        </div>

                                        <!-- CHECK IN Y CHECKOUT -->
                                        <div class="middle">
                                            <div>
                                                <span class="fa fa-phone"></span> Checkin: {{ $hotel["checkin"] }} | Checkout:
                                                {{ $hotel["checkout"] }}
                                            </div>
                                            <div><span class="fa fa-calendar"></span> {{ $hotel["room_name"] }}</div>
                                            <div><span class="fa fa-coffee"></span> {{ $hotel["meal"] }}</div>
                                        </div>

                                    </div>

                                    <div class="item-book containerBtnPrice" style="display: flex; justify-content: space-between;">
                                        {{-- <a href="/{{$hotel["link"]}}"
                                            class="btn btn-warning" style="float: right;">Ver habitaciones</a>
                                        <div class="price" style="float: left;">${{ $hotel["totalPublico"] }}
                                            {{ $hotel["monedaSeleccionada"] }}</div> --}}

                                        <div class="lineHeightLetters" style="font-size: 1.4em;">${{ $hotel["totalPublico"] }}
                                          {{ $hotel["monedaSeleccionada"] }}</div>

                                        <div class="btnContainerMain">
                                          <a href="/{{$hotel["link"]}}"
                                          class="btnMediaResponsive btn-warning" style="">Ver habitaciones</a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <script>
                                nombresHotels.push({
                                    "value": "{{$hotel["hotelName"]}}",
                                    "label": "{{$hotel["hotelName"]}}",
                                    "buscar": "{{$hotel["idhotel"]}}"
                                });
                            </script>
                        @endforeach
                    </div>
                    @else
                    <div class="container">
                      <h4>
                        Lo sentimos no pudimos encontrar algun resultado,
                        no hay hoteles disponibles en {{$nombreDestino}}
                      </h4>
                    </div>
                    @endif
                </div>
            </div>
        </section>
    </article>
    @php
      asort($arrayStars); //Ordena el arreglo de estrellas
      $filtrosStars = array_count_values($arrayStars);
      
      //El proceso de ordenamiento se realiza a la inversa
      $filtrosMeals = array_count_values($arrayMeals);
      arsort($filtrosMeals);
    @endphp
    <!--Breadcrumb Section End-->
@endsection

@php
    if(isset($checkinDate)){
        $checkinCarbon = Carbon::parse($checkinDate);
        $checkin       = $checkinCarbon->format('Y/m/d');

        $checkoutCarbon = Carbon::parse($checkoutDate);
        $checkout       = $checkoutCarbon->format('Y/m/d');
    }
@endphp

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/themes/base/jquery-ui.min.css" integrity="sha512-ELV+xyi8IhEApPS/pSj66+Jiw+sOT1Mqkzlh8ExXihe4zfqbWkxPRi8wptXIO9g73FSlhmquFlUOuMSoXz5IRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
  .text-muted {
    color: #777 !important;
  }
  .active-nav {
    transform: translateX(0%) !important;
  }
    .boton-filtros{
    display: none;
  }
  @media screen and (min-width: 992px) {
    #ui-id-1 {
        width: 300px !important;
        height: 200px;
        overflow-Y: scroll;
        overflow-X: hidden;
        z-index: 1000;
    }
  }

  @media screen and (max-width: 991px) {
    .boton-filtros{
      display: block;
  }

  #filtros-nav {
      top: 0;
      left: 0;
      height: 100%;
      position: fixed !important;
      transform: translateX(-100%);
      z-index: 5000;
      overflow-x: hidden;
      transition: 0.5s;
      background-color: white;
    }

    #ui-id-1 {
      width: 241px !important;
      height: 100px;
      overflow-Y: scroll;
      z-index: 1000;

    }
    .ui-autocomplete {
      z-index: 8000;
      background-color: white;
    }
  }

  .imgResponsiveCard {
    width: 100%;
    object-fit: cover;
    height: 276px !important;
    max-height: 276px;
  }

  .item-list .item-book .btn {
    width: 140px;
  }

  .spotlight-slider .center {
    filter: brightness(0.7) !important;
  }

  .owl-carousel.owl-drag .owl-item {
    filter: brightness(0.7) !important;
  }
</style>
@endsection

@section('scripts')
<script src={{ asset('assets/js/plugin/bootstrap-select.min.js') }}></script>
<script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js" integrity="sha512-57oZ/vW8ANMjR/KQ6Be9v/+/h6bq9/l3f0Oc7vn6qMqyhvPd1cvKBRWWpzu0QoneImqr2SkmO4MSqU+RpHom3Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/2/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker@3/daterangepicker.min.js"></script>
<script>

        $(document).ready(function(){
          lazyload();
          $(".filaHotel").each(function(){
            var top = $(this).offset();
            $(this).data("posicion", 'test');
            // console.log(Math.trunc(top.top));
          });
        });

        $(document).on("scroll", function() {
          var sv = $(document).scrollTop();
          // console.log(sv);         
        }); 
        

        let today    = @if(isset($checkinDate)) '{{$checkin}}' @else moment().add(5, 'days').format("YYYY/MM/DD") @endif;
        let todayEnd = @if(isset($checkoutDate)) '{{$checkout}}' @else moment().add(6, 'days').format("YYYY/MM/DD") @endif; 
        let maxday   = moment().add(730, 'days').format("YYYY/MM/DD");        

        @if(!isset($checkinDate))
            $("#checkin").val(today);
            $("#checkout").val(todayEnd);
        @endif

        $('#fechas').daterangepicker({
            autoApply: true,
            opens: 'left',
            minDate: today,
            maxDate: maxday,
            maxSpan: {
                "days": 30
            },
            startDate: today,
            endDate: todayEnd,
            locale: {
                applyLabel: "Aplicar",
                format: 'YYYY-MM-DD'
            }
        }, function(start, end, label) {
            $("#checkin").val(start.format('YYYY-MM-DD'));
            $("#checkout").val(end.format('YYYY-MM-DD'));
        });        

        $('#buscador1').select2({
            minimumInputLength: 3,
            dropdownPosition: 'below',
            allowClear: true,
            width: 'resolve',
            // placeholder: "Lugar",
            language: "es",
            ajax: {
                url: '/buscar-hotel',
                delay: 150,
                dataType: 'json',
                data: function(params) {
                    var query = {
                        search: params.term
                    }
                    return query;
                }
            },
            templateResult: formatStateHotels
        });
        $('#buscador1').on('select2:select', function(e) {
            var data = e.params.data;
            $("#nombreDestinoHotelero").val(data.text);
            $("#buscador1").val(data.id);

        });

        function formatStateHotels(state) {
            if (!state.id) {
                return state.text;
            }
            var $state = $(
                '<span><i style="color:#f47520" class="fa ' + state.icono + '"></i> ' + state.text + '</span>'
            );
            return $state;
        };


        $('#buscador2').select2({
            minimumInputLength: 3,
            dropdownPosition: 'below',
            allowClear: true,
            delay: 150,
            width: 'resolve',
            placeholder: 'Escribe destino o actividad',
            language: {
                noResults: function() {
                    return "No hay resultados";
                },
                searching: function() {
                    return "Espera, estamos buscando..";
                }
            },
            templateResult: formatState,
            ajax: {
                url: '/buscar-tour',
                dataType: 'json',
                data: function(params) {
                    var query = {
                        search: params.term
                    }
                    return query;
                }
            },

        });

        $('#buscador2').on('select2:select', function(e) {
            var data = e.params.data;
            $("#nombreDestinoTour").val(data.text);
            $("#buscador2").val(data.text);
        });

        function formatState(state) {
            if (!state.id) {
                return state.text;
            }
            var $state = $(
                '<span><i style="color:#f47520" class="fa ' + state.icon + '"></i> ' + state.text + '</span>'
            );
            return $state;
        };

        function menoresEdadesPedrito(menores) {
            for (i = 1; i <= 4; i++) {
                if (i <= menores) {
                    $("#edad" + i).show();
                    $(`#edad${i} input`).removeAttr('disabled')
                } else {
                    $("#edad" + i).hide();
                    $(`#edad${i} input`).prop("disabled", true);
                }
            }
        }

    /********************************************* TERMINA CODIGO PARA EL MOTOR ***********************************************************************/



    /********************************************* INICIA CODIGO DE FILTROS DE HOTELES ***********************************************************************/
    $("#checkin").val('{{$checkinDate}}');
    $("#checkout").val('{{$checkoutDate}}');
    $("#nombreDestinoHotelero").val('{{$nombreDestino}}');

    function openCloseNav() {
      document.getElementById("filtros-nav").classList.toggle("active-nav");
    }
    $("#filtros-nav").add(document).scroll(function() {
      document.querySelector("#ui-id-1").style.display = "none";
    });
    (function($) {
        "use strict";
        $.fn.numericFlexboxSorting = function(options) {
          const settings = $.extend({
            elToSort: ".filaHotel"
          }, options);

          const $select = this;
          const ascOrder = (a, b) => a - b;
          const descOrder = (a, b) => b - a;

          $select.on("change", () => {
            const selectedOption = $select.find("option:selected").attr("data-sort"); //tipo de orden
            // console.log("tipo de orden enviado: "+selectedOption); (Ej: price:asc)
            sortColumns(settings.elToSort, selectedOption);
          });

          function sortColumns(el, opt) {
            //Filas que se afectaran, tipo de orden
            const optArr = opt.split(":");
            const attr = "data-" + opt.split(":")[0];
            const sortMethod = (opt.includes("asc")) ? ascOrder : descOrder;
            const sign = (opt.includes("asc")) ? "" : "-";
            const sortArray = $(el).map((i, el) => $(el).attr(attr)).sort(sortMethod);
            // $("#filtroresultados").show();
            for (let i = 0; i < sortArray.length; i++) {
              $(el).filter(`[${attr}="${sortArray[i]}"]`).css("order", sign + sortArray[i]);
            }
            // const myTimeout = setTimeout(quitarFiltro, 1500);
          }

          return $select;
        };
      })(jQuery);
     
    $(document).ready(function() {
      $("#popularidad").numericFlexboxSorting();

      @foreach ($filtrosMeals as $filtroName => $filtroMeal)
        $("#planAlimentos").append('<li style="margin: 0.5rem"><input class="form-check-input" type="checkbox" value="meal_{{$fn->reemplaza_espacios($filtroName)}}"> {{$filtroName}} <span class="float-end iconCountdates">{{$filtroMeal}}</span></li>');
      @endforeach 

      @php
      foreach ($filtrosStars as $filtroStarCant => $filtroStar) {

        $htmlStars  = $filtroStarCant >= 1 ? '<span class="text-yellow" style="color: #F47420"><i aria-hidden="true" class="fa fa-star"></i>' : '<span class="text-muted"><i aria-hidden="true" class="fa fa-star"></i></span>';
        $htmlStars .= $filtroStarCant >= 2 ? '<span class="text-yellow" style="color: #F47420"><i aria-hidden="true" class="fa fa-star"></i>' : '<span class="text-muted"><i aria-hidden="true" class="fa fa-star"></i></span>';
        $htmlStars .= $filtroStarCant >= 3 ? '<span class="text-yellow" style="color: #F47420"><i aria-hidden="true" class="fa fa-star"></i>' : '<span class="text-muted"><i aria-hidden="true" class="fa fa-star"></i></span>';
        $htmlStars .= $filtroStarCant >= 4 ? '<span class="text-yellow" style="color: #F47420"><i aria-hidden="true" class="fa fa-star"></i>' : '<span class="text-muted"><i aria-hidden="true" class="fa fa-star"></i></span>';
        $htmlStars .= $filtroStarCant >= 5 ? '<span class="text-yellow" style="color: #F47420"><i aria-hidden="true" class="fa fa-star"></i>' : '<span class="text-muted"><i aria-hidden="true" class="fa fa-star"></i></span>';

      @endphp
      $("#cantEstrellas").append('<li style="margin: 0.5rem"><input class="form-check-input" type="checkbox" value="stars_{{$filtroStarCant}}"> {!!$htmlStars!!} <span class="float-end"> ({{$filtroStar}})</span></li>');
      @php
        }
      @endphp


      $(".form-check-input").click(function() {
        let filtros = [];
        $(".form-check-input").each(function() {
          if ($(this).is(':checked')) {
            let valor = $(this).val();
            filtros.push(valor);
          }
        });
        FiltrarResultados(filtros);
      });


      $("#nombreHotel").autocomplete({
        minLength: 3,
        classes: {
          "ui-autocomplete": "listaHotelNames"
        },
        source: nombresHotels,
        select: function(event, ui) {
          var label = ui.item.label;
          var value = ui.item.value;
          var buscar = ui.item.buscar;
          filtrarPorHotel(buscar);
        }
      });
    });
    //Funciones de filtros
    function FiltrarResultados(filtros) {
      $("#nombreHotel").val('');
      let hotelesEncontrados = parseInt($("#hotelesEncontrados").data("total"));
      let cfiltros = filtros.length;
      let filtrados = 0;
      if (cfiltros > 0) {
        $(".filaHotel").each(function() {
          let elem = $(this);
          var elemento = elem.attr("class");

          for (i = 0; i < cfiltros; i++) {
            let filtro = filtros[i];
            if (elem.hasClass(filtro)) {
              elem.show();
              filtrados++;
              break;
            } else {
              elem.hide();
            }
          }
        });
        if (filtrados === 1) {
          $("#hotelesEncontrados").html(filtrados + " hotel filtrado de " + hotelesEncontrados + " hoteles encontrados");
        } else {
          $("#hotelesEncontrados").html(filtrados + " hoteles filtrados de " + hotelesEncontrados + " hoteles encontrados");
        }

      } else {
        $(".filaHotel").show();
        $("#hotelesEncontrados").html("Se encontraron " + hotelesEncontrados + " hoteles");
      }

    }

    function filtrarPorHotel(hotelName) {
      let hotelesEncontrados = parseInt($("#hotelesEncontrados").data("total"));
      $(".form-check-input").each(function() {
        $(this).prop("checked", false)
      });

      $(".filaHotel").show();
      $(".filaHotel").not('.' + hotelName).hide();

      $("#hotelesEncontrados").html("1 hotel filtrado de " + hotelesEncontrados + " hoteles encontrados");
    }

    function filtrPorNombre(hotel) {
      if (hotel === '') {
        $(".filaHotel").show();
      }
    }

    menoresEdadesPedrito($('#menores').val());
  </script>
@stop
