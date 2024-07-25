# Sitio Web Demo Plantilla Laravel
Implementación de nueva plantilla de migracion a Laravel Version 9.xxx
actualizado 06/03/2024
> [!IMPORTANT]
> - No manipular, editar o alterar la codificación realizada en este presente proyecto para prevenir el mal funcionamiento de la aplicación web.
> - Consultar previamente antes de requerir especificamente la alteración de un fragmento del código para comprobar que no haya conflictos.

# Actualización Motor Hoteles List y Region V.1.0.
El recurso ya esta actualizado, es necesario actualizar el sitio web controller para que pueda funcionar correctamente.
Un solo unico motor ya es funcional con ambos listados tanto para hoteles search y hoteles region.

Requerimientos:

- Actualizar el SitioWebController.

25/12/2023

# Migración del Módulo del Motor de Transportación MV1 V.1.0.
Se ha implementado la migración del módulo de transportación correspondiente al MV1.
Para su implementación es necesario lo siguiente.

Requerimientos:

- Agregar al proyecto TransportacionController.
- Agregar sus respectivas vistas.
    1. index.
    2. datosCompra.
    3. graciasOpenpay.
- Actualizar SitioWebController.
- Actualizar web.php.

24/12/2023

# Módulo Cupones V.1.0.
Se ha implementado los cupones para los siguientes sectores: experiencias, tours civitatis, hoteles y transportación.
Requerimientos: 
- Actualizar customFunctions (Versión para Laravel > V.9xxx).
- Actualizar SitioWebController.
- Actualizar wep.php.

22/12/2023

# Módulo de Listado de Civitatis.
Se implemento la imagen de Not Found 404, cuando un tour de civitatis no tiene asignada la galería

Requerimientos: 
- La imagen que se encuentra en la carpeta assets/images/image-not-404.webp.

Actualizacion:
- Agregar una condicional de la imagen en la Card del Tour.

29/12/2023

# Actualización de precios detalle experiencias propias.
Corregir tomando en cuenta la condicional que se encuentra en la linea 532 de views->detalle Experiencias la siguiente condicional:

- @if ($tour['paquete'][0]['cantidad_dias'] > 1 && $tour['paquete'][0]['hoteleria'] == 1) onchange="calculaPreciosCircuito()" en los name de 'infantes' , 'adultos' y 'menores'

Requerimientos

> [!IMPORTANT]
> - Actualizar el script del customFunctions.js.
> - Actualizar el SitioWebController.php

- Agregar en la view de Detalle Experiencias la condicional.
- Agregar el input hidden con el name de  <input type="hidden" id="tipo_reserva_hotelera" name="tipo_reserva_hotelera" value="{{ $tour["paquete"][0]["tipo_reserva_hotelera"] }}">
- Agregar el input hidden con el name de  input type="hidden" name="tipo_costo" id="tipo_costo" value="{{ $tipo_costo }}"
- Agregar el input hidden con el name de  input type="hidden" name="cantidad_tipo_costo" id="cantidad_tipo_costo" value="{{ $cantidad_tipo_costo }}"

02/01/2024

# Actualización de comprobación de capacidad de personas por grupo en experiencias propias.

Implementacion de la comprobacion de la cantidad de personas aceptadas en un unico tour(si el tour tiene un grupo de capacidad asignada, mostrara el mensaje de su capacidad aceptada).

Requerimientos:
- Actualizar customFunctions.js
- En detalle experiencias agregar los siguientes div con sus respectivos ID
    1. Div id="mensajeLimiteGroup"
        1. ``` "<p class=messageGroup></p>" ```
    2. Div id="mensajeLimiteGroup"
    3. Actualizar el ```<script> el javascript que se encuentra en el detalle de la experiencias </script>``` (importante).
- Agregar el stylesMessageGroup.css para los estilos del mensaje.

02/01/2024

# Actualización de tabla de precios en experiencias propias cuando su duración es de 1 solo dia.
Se ha resolvido el bug de que cuando se reflejaba el detalle de precios de un tour con duración de un dia, este mismo mostraba los detalles de precios de habitaciones, se ha implementado una solucion para que muestre unicamente sus precios respectivos

Requerimientos: 
- Actualizar customFunctions.js
- En detalle experiencias agregar el siguiente id="hoteleria" al input con el name="hoteleria" (importante)

02/01/2024

# Actualización de Inputs a Select en los campos de edades de los menores en el listado de Hoteles V2.

Se ha resolvido el bug de que permitia los campos de las edades de los menores poner un valor mayor a 16, en este caso se cambio el tipo de etiqueta a un select.

Requerimientos: 

- Actualizar el siguiente script de la ```función menoresEdadesPedrito()``` -> las declaraciones $(`#edad${i} input`) cambiarlo a $(`#edad${i} select`) (Son unicamente 3)

- Cambiar la etiqueta de los inputs a select en el motorHotelV2:
```
<select disabled name="edad[]" class="form-control edadInput" placeholder="Ingrese" required>
            @for ($i = 0; $i <= 16; $i++) 

            en cada uno de los select ira cada valor de edad[$distintos]
            
            <option style="color: black" value="{{ $i }}" @if (isset($vars['edad'][0]) && $vars['edad'][0] == $i) selected @endif>
            
            <option style="color: black" value="{{ $i }}" @if (isset($vars['edad'][1]) && $vars['edad'][1] == $i) selected @endif>
            
            <option style="color: black" value="{{ $i }}" @if (isset($vars['edad'][2]) && $vars['edad'][2] == $i) selected @endif>
            
            <option style="color: black" value="{{ $i }}" @if (isset($vars['edad'][3]) && $vars['edad'][3] == $i) selected @endif>
                {{ $i }}
            </option>
            @endfor
</select>
```
06/01/2024


# Actualización Módulo de mostrar precios de habitaciones, cuando existe hoteleria y el tour no esta calendarizado.

Actualización, la persona debe de seleccionar su dia de reserva y esta misma fecha debe de guardarse en la plataforma teneniendo hoteleria y no esta calendarizado.

> [!IMPORTANT]
> - Debes de verificar que hayas puesto correctamente los nombres de los inputs hidden y tambien haber agregado el contenedor del calendario.
> - Agregar el siguiente complemento de la condicional que se encuentra en el número de la linea de código 233 verificar que en tu código esta misma condicional este comparado en tu version de código. 

Requerimientos:
- Agregar el compelmento ```@if ($tour['paquete'][0]['calendario'] == 1 || $tour['paquete'][0]['calendario'] == 0 && $tour['paquete'][0]['hoteleria'] == 1 )```
- Actualizar customFunctions.js.
- Actualizar el SitioWebController.php.
- Agregar en la vista de Detalle.php de experiencias el script que se encuentra en la vista de este presente proyecto [web.experiencias.detalle] el ultimo ```<script> $('#fecha_viaje')</script>``` que se encuentra al final a demas agregarle la siguiente codicional ``` @if ($tour['paquete'][0]['calendario'] == 0 && $tour['paquete'][0]['hoteleria'] == 1) $('#fecha_viaje').on("change",function() {} @endif```.
- Agregar los siguientes Inputs hidden.
```
<input type="hidden" name="fechaInicioDeLaTemporada" id="fechaInicioDeLaTemporada">
<input type="hidden" name="fechaFinDeLaTemporada" id="fechaFinDeLaTemporada">
<input type="hidden" name="fechaSeleccionadaPorDia" id="fechaSeleccionadaPorDia">
```
- Después, debemos de agregar el siguiente div con la siguiente condicional.
```
@if ($tour['paquete'][0]['calendario'] == 0 && $tour['paquete'][0]['hoteleria'] == 1)
    <label for="datepickerCalendario" style="margin-top: 10px;">Selecciona una fecha</label>
    <div id="contenedorCalendario">
        <input required type="text" name="fecha"  id="datepickerCalendario"
            class="form-control" placeholder="Fecha" readonly>
    </div>
@endif
```

06/01/2024

# Módulo reCAPTCHA Google V.2.0

Se ha implementado el módulo de casilla de verificacion de reCAPTCHA de google en su version 2.0.

Requerimientos:
- Actualizar el sitioWebController.
- Agregar en la vista del formulario del contacto el siguiente div (preferentemente lo podrias poner encima del boton de Enviar).
```
<div>
    <div id="recaptchaContent" class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
    <br/>
</div>
```
- Agregar en la vista del formulario de contacto los siguientes script.js 
```
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    window.onload = function() {
      let recaptcha = document.forms["registerForm"]["g-recaptcha-response"];
      recaptcha.required = true;
      recaptcha.oninvalid = function(e) {
        alert("Porfavor Resuelva el reCAPTCHA");
        $('#recaptchaContent').addClass('errorReCaptcha');
      }
    }
</script>
```
- Agregar el estilo para remarcar cuando no haya resuelto el changelle del reCAPTCHA el usuario final.
```
.errorReCaptcha{
        border: #B80000 solid 4px;
        border-radius: 5px;
    }
```
- Agregar el contenido que se encuentra en el archivo services.php de este presente proyecto, preferentemente deberas de copiar TODO el contenido (Importante aquel archivo solo lo manipularas una unica vez, y solo para cuando requieras agregar este modulo a tu proyecto, No EDITAR por ningun motivo ese archivo mas que el contenido reemplazable, debido a que podrias dañar la configuracion de todo el proyecto).
- Agregar las siguientes variables en el archivo .ENV (Una unica vez manipularas el contenido de este archivo, no agregar, eliminar o sustituir variables de mas, debido a que el archivo iteractua con el funcionamiento de la aplicacion web).
```
RECAPTCHA_SITE_KEY =6LdfSD0pAAAAAN10Wm4zntlafUpyrx-WwScZm2Zs
RECAPTCHA_SECRET_KEY =6LdfSD0pAAAAAOKfKWHYwer5vlceLYNVP8Gaz4ht
```

16/01/2024


# Actualizar en el datos compra de experiencias, tours civitatis y hoteles.
- Dejar unicamente una sola etiqueta ```<form action="{{route('save-openpay-depende-cual-sea')}}" method="post"></form>```, que  abarque de manera global todo el contenedor de la reserva y el ticket de compra ```<form action="{{route('save-openpay-depende-cual-sea')}}" method="post"></form> borrar la etiqueta de <form method="post" action="assets/check_avail.php" id="check_avail" autocomplete="off"> y su cierre </form> y solo dejar la principal que abarque todo el formulario de reserva y la tabla del ticket```

- En experiencias propias unicamente ahi, deberas buscar el input hidden ```<input type="hidden" name="totalConCuponPrecio" id="totalTourPrecioCupon" value=""> cambiarlo a -> <input type="hidden" name="totalConCupon" id="totalTourPrecioCupon" value="">```.

20/01/2024

# Módulo Filtros Experiencias
Se implemento los filtros para experiencias propias.

Requerimientos:
- Actualizar FnController.
- Actualizar el método de experiencias ``` public function experiencias() ```;
- Actualizar el método de categoriasExperienciasUnica ``` public function categoriasExperienciasUnica() ```;
- Importar la hoja de estilos de stylesFiltrosExperiences.css ```<link rel="stylesheet" href="{{ asset('assets/css/stylesFiltrosExperiences.css') }}">```

20/01/2024

# Actualización de fix en motor hoteleria cuando se seleciona un menor con 0 años
Se resolvio el fix de cuando se realiza una busqueda de un hotel seleccionando un adulto y un menor pero con la edad de 0.

Requerimientos:
- En la vista de hoteleria deberas de encontrar la linea donde se encuentra esta funcion ``` dataBusquedaMotorSearch(dataHotel); ``` y debajo de el vas a agregar el siguiente script 
```
if(!parseInt(destinoHotelero)) {
    let newUrlDetailsHotel = urlRequestHotelUnic();
    return location.replace(newUrlDetailsHotel);
}
```

- Ahora deberas de verificar en la linea donde se encuentra la siguiente variable con el nombre de ``` let linkV3Hotel ```, encima de esa precisa variable vas a poner el siguiente scripts 
``` 
if(menores > 0) {
        edades = edad;
    } else {
        edades = 'cero';
    }
 ```

- Ahora hasta al final del script que se encuentra en la vista de listado deberas de agregar esta function ```const urlRequestHotelUnic() ``` esta function se encuentra en la vista de listado en demo, deberas de copiar toda la function.

# Actualizacion Hoteleria fix cuando no existe informacion acerca de un hotel  / cuando el hotel se encuentra con el lema de en construccion
Se ha resolvido el fix que cuando realizas una busqueda en el motor de hoteleria en el listado de hoteles existen hoteles que se encuentra en construccion (muestran un lema de que esta propiedad se encuentra en construccion) y por la tanta al ingresar a ese hotel no se encuetra ninguna informacion acerca de el.

Requerimientos: 
- Actualizar la ``` function habitaciones()  ``` que se encuentra en el SitioWebController (copiar toda la funcion tal cual esta).
- En la vista de habitaciones deberas de agregar el siguiente condicional, ``` @if($existInformationHotel == true) <div>toda la informacion del hotel</div>  @else  No hay información acerca de este hotel, por favor intentelo más tarde  @endif```

# Agregacion de la propiedad tipoDuracion en detalle experiencias
Se agrego una nueva propiedad en el detalle de experiencias mandando como nueva propiedad el tipodURACION.

Requerimientos:
- Actualizar la function ``` function experiencia_detalle() {} ```

22/01/2024

# Promociones express
Verificar que al momento de enviar el mensaje de whatsApp se envie el titulo de la promocion

# En la imagen de la card del listado del blog y por categorias de blog agregar la imagen ['carrousel']
Agregar la imagen del ['carrousel'].

# Actualizar el nombre de la variable $cantidad_tipo_costo
Actualizar la variable en el SitioWebController y vas a cambiar el nombre de $cantidad_tipo_costo a $cant_pax_max

Requerimientos:

- Actualizar el nombre de la variable desde el SitioWebController.php en la ``` function experiencia_detalle() {} ``` vas a encontrar la variable con el nombre de ``` $cantidad_tipo_costo ``` y la reemplazaras por ``` $cant_pax_max ``` de igual manera tendras que actualizar en el ``` return { de la function }. ```
- Actualizar en la vista de detalle experiencias vas a encontrar todas las variables que empiecen de la siguiente manera ``` $cantidad_tipo_costo ``` y vas a reemplazar a ``` $cant_pax_max ```.

# Actualizacion detalle experiencias horas y dias
Se actualizo la informacion del detalle de una experiencia, ahora en la vista del detalle deberas de agregar este script en la parte donde renderizas las horas/dias del tour, de igual manera deberas de verificar que se aplique en la descripcion en las cards del listado de experiencias.

```  {{ $tour['paquete'][0]['cantidad_dias'] > 1 ? $tour['paquete'][0]['cantidad_dias'] . ($tipoDuracion == 0 ? ' días' : ' horas') : $tour['paquete'][0]['cantidad_dias'] . ($tipoDuracion == 0 ? ' día' : ' hora') }} ```

- En listado del index de la experiencias debes de enviar la siguiente variable.
``` 
public function experiencias(Request $request)   $experienciasList[$i]["tipoDuracion"]       =  $experiencia["tipo_duracion"]; 

{{ $experiencia['cantidad_dias'] > 1 ? $experiencia['cantidad_dias'] . ($experiencia['tipoDuracion'] == 0 ? ' días' : ' horas') : $experiencia['cantidad_dias'] . ($experiencia['tipoDuracion'] == 0 ? ' día' : ' hora') }}
```

- Tambien en listado de categorias y tour relacionados.

23/01/2024

# Actualizar link que redirige al detalle
Se actualizo la forma de como esta añadida todo aquel link que redirigia al detalle de un tour y a los listados y se construyan por medio de una api.
Solamente deberas de agregar este metodo ``` $fn->stringToUrl() ``` en donde se ingresa el link hacia el tour, ejemplo: 
``` <a href="hoteles-en/{{ $hotelFavorito['nombre_destino'] }}/{{ $hotelFavorito['id_region'] }} ``` cambiarlo a ``` <a href="hoteles-en/{{ $fn->stringToUrl($hotelFavorito['nombre_destino']) }}/{{ $hotelFavorito['id_region'] }} ""></a>  ```

23/01/2024

# Módulo de Reseteo de Cache
Se ha implementado el módulo de reestrablecer la cache de la aplicación web;

Requerimientos:
- En el SitioWebController deberas de agregar esta function debajo de la ``` function sandBox(){} ``` el siguiente script ``` public function resetCacheStatus() {
        $response = Http::withToken($this->token)
                    ->withHeaders([
                        'realip'  => $_SERVER['REMOTE_ADDR'],
                        'dominio' => $_SERVER['SERVER_NAME'] 
                    ])->get('https://app.bookingtrap.com/api/v2/cache');
        return $response['cache'];
    } ```
- En el archivo ``` AppServiceProvider.php ``` deberas de agregar debajo de la variable $blog el siguiente scrupt ``` 
$cacheResponse = $sw->resetCacheStatus();

if($cacheResponse == 1) {
    session()->forget('sitioWeb');
    Artisan::call('cache:clear');
} ```

23/01/2024

# Actualizacion clases-servicios no existentes en un tour de experiencias propias
Cuando un tour no tiene servicios registrados aparece el error del blade, verificar en el codigo en el detalle de experiencias el comentarios ```  {{-- SERVICIO --}} ```.

Requerimientos:
-En el detalle de la vista de detalle.php de experiencias agregar el siguiente codigo en el blade.php
``` {{-- SERVICIO --}}
    @if (count($clases) > 1)
        <div class="mt-2">
            <label for="">Selecciona el servicio</label>
            <select required name="clase" id="clase"
                class="selectBook form-control" onchange="buscaPrecios()">
                <option value="" disabled selected>Selecciona una opción</option>
                @foreach ($clases as $clase)
                    <option value="{{ $clase['id'] }}">{{ $clase['nombre'] }}</option>
                @endforeach
            </select>
        </div>
    @else
            @if ($clases != null)
                <input type="hidden" name="clase" id="clase"
                    value="{{ $clases[0]['id'] }}">
            @else
                <select class="form-control" id="clase" name="clase" required>
                    <option value="" disabled selected>Sin servicio disponible
                    </option>
                </select>
            @endif
    @endif 
```

# Actualizacion de envio de email
Se implemento una nueva variable al momento de enviar un correo email desde el formulario de contacto en conjunto al recapchat.

Requerimientos:
- Deberas de actualizar la siguiente funcion graciasEmail() desde el SitioWebController.php ``` public function graciasEmail(Request $request){} ``` .

# Módulo de pasarela de pagos por medio de Paypal.
Daniel Dev(pendiente)
Disponible en civitatis(la prueba solo se realiza llegando al modal del pago en paypal, sin embargo no deberas de DAR CLICK EN PAGAR AHORA), experiencias y hoteleria, transportacion (en proceso de verificacion).

- Verificar la terminal Paypal en Modo Pruebas

- Pruebas permitidas en: 
    - Experiencias.
    - Hoteleria.

- Pruebas no permitidas completas en:
    - Civitatis.
# 

--------
9/3/2024

Se implementa el cartel de sandbox para mostrarse en caso de que sandbox este activo