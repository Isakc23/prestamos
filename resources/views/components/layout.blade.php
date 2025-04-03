<!DOCTYPE html>
<html lang="en">
<head>
    <!-- importar las librerías de bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- importar librería de datatables para manipular tablas desde el navegador del usuario-->
    <link href={{ URL::asset('DataTables/datatables.min.css')}} rel="stylesheet"/>
    <script src={{ URL::asset('DataTables/datatables.min.js')}}></script>
    <link href={{URL::asset("assets/style.css")}} rel="stylesheet" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestamos</title>
</head>

<body>
    <div class="row">
        <div class="col-2">
            @component("components.sidebar")
            @endcomponent
</div>
        <div class="col-10">
            <div class="container">
                @section("content") 
                @show
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>