<?php
    session_start();
    require dirname(__DIR__,2)."/vendor/autoload.php";
    use Src\Categorias;

    if(!isset($_GET['id'])){
        header("Location:index.php");
    }
    
    $id=$_GET['id'];
    $datosCategoria=(new Categorias)->read($id);

    function hayError($n,$d){
        $error=false;
        if(strlen($n)==0){
            $_SESSION['error_nombre']="Rellene el campo nombre!!!";
            $error=true;
        }
        if(strlen($d)==0){
            $_SESSION['error_descripcion']="Rellene el campo descripcion!!!";
            $error=true;
        }
        
        return $error;
    }

    if(isset($_POST['btnUpdate'])){
        //Procesamos el formulario
        $nombre=trim(ucwords($_POST['nombre']));
        $descripcion=trim(ucwords($_POST['descripcion']));
        
        if(!hayError($nombre,$descripcion)){
            (new Categorias)->setNombre($nombre)
            ->setDescripcion($descripcion)
            ->setId($id)
            ->update();
            $_SESSION['mensaje']="Categoria actualizada correctamente";
            header("Location:index.php");
            die();

        }
        header("Location:{$_SERVER['PHP_SELF']}?id=$id");
    }else{

    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Editar Categoria</title>
</head>

<body style="background-color: coral">
    <h3 class="text-center">Editar Categoria</h3>
    <div class="container mt-2">
        <form action="<?php echo $_SERVER['PHP_SELF']."?id=$id"; ?>" name="categoria" method="POST">
            <div class="bg-secondary p-4 text-white rounded shadow-lg m-auto" style="width: 40rem;">
                <div class="form-group">
                    <label for="n">Nombre Categoria</label>
                    <input type="text" class="form-control" id="n" value="<?php echo $datosCategoria->nombre ?>" name="nombre">
                    <?php
                    if(isset($_SESSION['error_nombre'])){
                        echo <<<TEXTO
                        <div class="mt-2 text-danger fw-bold" style="font-size:small">
                        {$_SESSION['error_nombre']}</div>
                        TEXTO;
                        unset($_SESSION['error_nombre']);
                    }
                    ?>
                </div>
                <div class="form-group">
                    <label for="a">Descripcion Categoria</label>
                    <input type="text" class="form-control" id="a" value="<?php echo $datosCategoria->descripcion ?>" name="descripcion" >
                    <?php
                    if(isset($_SESSION['error_descripcion'])){
                        echo <<<TEXTO
                        <div class="mt-2 text-danger fw-bold" style="font-size:small">
                        {$_SESSION['error_descripcion']}</div>
                        TEXTO;
                        unset($_SESSION['error_descripcion']);
                    }
                    ?>
                </div>
            <button type="submit" name="btnUpdate" class="btn btn-success mt-3"><i class="fas fa-plus mr-1"></i>Crear</button>
            <button type="reset" class="btn btn-warning mt-3"><i class="fas fa-broom mr-1"></i>Limpiar</button>
            <a href="index.php" class="btn btn-primary mt-3"><i class="fas fa-backward mr-1"></i>Volver</a>
            </div>
            
        </form>
    </div>
</body>

</html>
<?php }  ?> 