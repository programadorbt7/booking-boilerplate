<style>
    h1{
        color:red;
    }

    .lity-con {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
        padding: 10px 10px;
    }

    .imgLity {
        width: 100%;
        height: 306px !important;
        object-fit: contain;
    }

    @media (max-width: 800px) {
        .lity-con {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 450px) {
        .lity-con {
            grid-template-columns: repeat(1, 1fr);
        }
    }
</style>

<div id="galeriaInfoTour" class="lity-hide" style="overflow: scroll; overflow-x: hidden;">
    <div class="lity-con">
        @foreach ($tour['imagenes'] as $imagen)
            <div class="item" style="margin-letf: 10rem">
                <img class="imgLity" style="max-width: 100%; height: auto;" src="{{ $imagen['imagen'] }}"
                    alt="{{ $tour['paquete'][0]['nombre'] }}">
            </div>
        @endforeach
    </div>
</div>