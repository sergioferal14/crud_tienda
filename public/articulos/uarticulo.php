<?php

if(!isset($_GET['id'])){
    header("Location:index.php");
    die();
}
$id=$_GET['id'];
session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Src\{Articulos, Categorias};
$esteArticulo=(new Articulos)->read($id);

$categorias = (new Categorias)->devolverCategorias();

function hayError($n,$p){
  $error=false;
  if(strlen($n)==0){
    $error=true;
    $_SESSION['error_nombre']="Rellene el campo nombre";
  }
  if(strlen($p)==0){
    $error=true;
    $_SESSION['error_precio']="Rellene el campo precio";
  }
  return $error;

}

if(isset($_POST['btnUpdate'])){
  $nombre=trim(ucwords($_POST['nombre']));
  $precio=trim($_POST['precio']);
  $categoria_id=$_POST['categoria_id'];
  if(!hayError($nombre,$precio)){
    (new Articulos)->setnombre($nombre)
        ->setPrecio($precio)
        ->setCategoria_id($categoria_id)
        ->update($id);
        $_SESSION['mensaje']="Articulo actualizado correctamente";
            header("Location:index.php");
            die();
  }else{
    header("Location:{$_SERVER['PHP_SELF']}?id=$id");
  }
}else{



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
  <title>Actualizar Articulo</title>
</head>

<body style="background-color: coral">
  <h3 class="text-center">EditarArticulo nº(<?php echo $esteArticulo->id; ?>)</h3>
  <div class="container mt-2">
    <div class="bg-secondary p-4 text-white rounded shadow-lg m-auto" style="width: 40rem;">
      <form action="<?php echo $_SERVER['PHP_SELF']."?id=$id"; ?>" name="articulo" method="POST">

        <div class="mb-3">
          <label for="t" class="form-label">nombre:</label>
          <input type="text" class="form-control" name="nombre" id="n" value="<?php echo $esteArticulo->nombre; ?>">
        </div>
        <?php
                    if(isset($_SESSION['error_nombre'])){
                        echo <<<TEXTO
                        <div class="mt-2 text-danger fw-bold" style="font-size:small">
                        {$_SESSION['error_nombre']}</div>
                        TEXTO;
                        unset($_SESSION['error_nombre']);
                    }
                    ?>
        <div class="mb-3">
          <label for="s" class="form-label">Precio:</label>
          <textarea class="form-control" id="p" name="precio" rows="3"><?php echo $esteArticulo->precio; ?></textarea>
        </div>
        <?php
                    if(isset($_SESSION['error_precio'])){
                        echo <<<TEXTO
                        <div class="mt-2 text-danger fw-bold" style="font-size:small">
                        {$_SESSION['error_precio']}</div>
                        TEXTO;
                        unset($_SESSION['error_precio']);
                    }
                    ?>
        <div class="mt-2">
          <label for="c" class="form-label">Categoria:</label>
          <select class="form-select" name="categoria_id">
            <?php
            foreach ($categorias as $item) {
                if($item->id == $esteArticulo->categoria_id){
              echo "<option value='{$item->id}' selected>{$item->nombre}</option>";
            }else{
                echo "<option value='{$item->id}'>{$item->nombre}</option>";
            }
            }
            ?>
          </select>
        </div>
        <button type="submit" name="btnUpdate" class="btn btn-primary mt-3"><i class="fas fa-plus"></i>Actualizar</button>
          <button type="reset" class="btn btn-primary mt-3"><i class="fas fa-broom"></i>Limpiar</button>
        <div class="mt-2">
          <a href="index.php" class="btn btn-primary">
            <i class="fa fa-backward"></i> Volver</a>
        </div>
      </form>
    </div>
  </div>
</body>

</html>
<?php } ?>