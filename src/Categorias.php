<?php

namespace Src;
use PDO;
use Faker;
use PDOException;

class Categorias extends Conexion{
    private $id,$nombre,$descripcion;

    public function __construct()
    {
        parent::__construct();
    }

    //-------------------CRUD---------------------

    public function create(){
        $q="insert into categorias(nombre,descripcion) values(:n,:d)";
        $stmt=parent::$conexion->prepare($q);
        try{
            $stmt->execute([
                ':n'=>$this->nombre,
                ':d'=>$this->descripcion
            ]);
        }catch(PDOException $ex){
            die("Error al crear la categoria.".$ex->getMessage());
        }
        parent::$conexion = null;
    }

    public function read($id){
        $q = "select * from categorias where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':i' => $id
            ]);
        }catch(PDOException $ex){
            die("Error al leer la categoria:");
        }
        parent::$conexion=null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function update(){
        $q = "update categorias set nombre=:n, descripcion=:d where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':d'=>$this->descripcion,
                ':i' => $this->id
            ]);
        } catch (PDOException $ex) {
            die("Error al actualizar la categoria: " . $ex->getMessage());
        }
        parent::$conexion = null;
    }
    
    public function delete($id){
        $q = "delete from categorias where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':i' => $id
            ]);
        } catch (PDOException $ex) {
            die("Error al borrar la categoria: " . $ex->getMessage());
        }
        parent::$conexion = null;
    }
    //------------OTROS METODOS----------------
    public function readAll()
    {
        $q = "select * from categorias";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al recuperar todas las categorias: " . $ex->getMessage());
        }
        parent::$conexion = null; //cerramos la conexion
        return $stmt;
    }
    
    public function generarCategorias($cant){

        if (!$this->hayCategorias()) {
            $faker = Faker\Factory::create('es_ES');
            for ($i = 0; $i < $cant; $i++) {
                $nombre = $faker->word();
                $descripcion = $faker->text(200);
                (new Categorias)->setNombre($nombre)
                    ->setDescripcion($descripcion)
                    ->create();
            }
        }
    }
    public function hayCategorias()
    {
        $q = "select * from categorias";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al recuperar todas las categorias: " . $ex->getMessage());
        }
        return $stmt->rowCount();
    }

    public function devolverId()
    {
        $q = "select id from categorias order by id";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error en el metodo devolver id: " . $ex->getMessage());
        }
        $id = [];
        while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
            $id[] = $fila->id;
        }
        parent::$conexion = null;
        return $id;
    }

    public function devolverCategorias()
    {
        $q = "select nombre, id from categorias";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("error en devolverCategorias: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
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
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */ 
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of descripcion
     */ 
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set the value of descripcion
     *
     * @return  self
     */ 
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }
}