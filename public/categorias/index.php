<?php
session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Src\Categorias;

(new Categorias)->generarCategorias(10);
$datosCategorias = (new Categorias)->readAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Categorias</title>
</head>

<body style="background-color: silver;">
    <h3 class="text-center">Gestion Categorias</h3>
    <div class="container mt-2">
    <?php
                    if(isset($_SESSION['mensaje'])){
                        echo <<<TEXTO
                        <div class="alert alert-primary" role="alert">
                        {$_SESSION['mensaje']}</div>
                        TEXTO;
                        unset($_SESSION['mensaje']);
                    }
                    ?>
        <a href="ccategoria.php" class="btn btn-primary"><i class="fas fa-clipboard-list"></i>Añadir Categoria</a>
        <a href="../articulos/" class="btn btn-success"><i class="fas fa-shopping-cart"></i>Gestionar Articulos</a>
        <table class="table table-dark table striped mt-3">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Funciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while($fila=$datosCategorias->fetch(PDO::FETCH_OBJ)){
                echo <<< TEXTO
                <tr>
                    <th scope="row">{$fila->id}</th>
                    <td>{$fila->nombre}</td>
                    <td>{$fila->descripcion}</td>
                    <td>
                    <form name='s' action='bcategoria.php' method="POST">
                    <input type="hidden" name="id" value="{$fila->id}">
                    <a href="ucategoria.php?id={$fila->id}" class="btn btn-warning"><i class="fas fa-edit" ></i>Editar</a>
                    <button type="submit" class="btn btn-danger mt-2" onclick="return confirm('¿Desea borrar la categoria?')"><i class="fas fa-trash"></i>Borrar</button>
                    </form>
                    </td>
                </tr>
                TEXTO;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>