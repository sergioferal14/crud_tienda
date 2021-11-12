<?php

namespace Src;
use PDO;
use Faker;
use PDOException;

class Articulos extends Conexion{
    private $id,$nombre,$precio,$categoria_id;

    public function __construct()
    {
        parent::__construct();
    }

    //-------------------CRUD---------------------

    public function create(){
        $q="insert into articulos(nombre,precio,categoria_id) values(:n,:p,:ci)";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':p'=>$this->precio,
                ':ci'=>$this->categoria_id
            ]);
        }catch(PDOException $ex){
            die("Error al crear el articulo ".$ex->getMessage());
        }
    }

    public function read($id){
        $q = "select * from articulos";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':i' => $id
            ]);
        }catch(PDOException $ex){
            die("Error al leer el articulo:".$ex->getMessage());
        }
        parent::$conexion=null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function update($id){
        $q = "update articulos set nombre=:n, precio=:p , categoria_id=:ci where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':p'=>$this->precio,
                ':ci' => $this->categoria_id,
                ':i' =>$id
            ]);
        } catch (PDOException $ex) {
            die("Error al actualizar el articulo: " . $ex->getMessage());
        }
    }
    
    public function delete($id){
        $q = "delete from articulos where id=:id";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':id' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error al borrar el articulo: " . $ex->getMessage());
        }
        parent::$conexion = null;
    }
    //------------OTROS METODOS----------------
    public function readAll()
    {
        $q = "select * from articulos";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al devolver todos los articulos: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt;
    }
    
    public function generarArticulos($cant){

        if (!$this->hayArticulos()) {
            $faker = Faker\Factory::create('es_ES');
            $categorias = (new Categorias)->devolverId();
            for ($i = 0; $i < $cant; $i++) {
                $nombre = $faker->word();
                $precio =$faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 5);
                $categoria_id = $categorias[array_rand($categorias, 1)];
                (new Articulos)->setnombre($nombre)
                    ->setPrecio($precio)
                    ->setCategoria_id($categoria_id)
                    ->create();
            }
        }
    }

    public function hayArticulos()
    {
        $q = "select * from articulos";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al comprobar si hay articulos: " . $ex->getMessage());
        }
        $totalArticulos = $stmt->rowCount();
        parent::$conexion = null;
        return ($totalArticulos > 0);
    }

    

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */ 
    public function getnombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setnombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of precio
     */ 
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set the value of precio
     *
     * @return  self
     */ 
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get the value of categoria_id
     */ 
    public function getCategoria_id()
    {
        return $this->categoria_id;
    }

    /**
     * Set the value of categoria_id
     *
     * @return  self
     */ 
    public function setCategoria_id($categoria_id)
    {
        $this->categoria_id = $categoria_id;

        return $this;
    }
}