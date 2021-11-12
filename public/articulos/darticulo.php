<?php
if (!isset($_GET['id'])) {
    header("Location:index.php");
    die();
}
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Src\Articulos;

$datosArticulos = (new Articulos)->read($_GET['id']);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- BootStrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Detalle Articulo</title>
</head>

<body style="background-color:silver">
    <h3 class="text-center mt-2">Detalle Articulo nº(<?php echo $datosArticulos->id; ?>)</h3>
    <div class="container mt-2">

        <div class="card mx-auto" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title"><?php echo $datosArticulos->nombre; ?></h5>
                <p class="card-text"><b>Precio: </b><?php echo $datosArticulos->precio; ?>€</p>
                <p class="card-text"><b>Categoria: </b><?php echo $datosArticulos->categoria_id; ?></p>
                <a href="index.php" class="btn btn-primary"><i class="fa fa-backward"></i>Volver</a>
            </div>
        </div>
</body>

</html>