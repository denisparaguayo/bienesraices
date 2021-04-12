<?php

namespace App;

class Propiedad {

    //BAse de datos
    protected static $bd;
    protected static $columnasDB = ['id','titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

    //Errores

    protected static $errores = [];




    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

    //defiir la conexion  la BD
    public static function setBD($database){
        self::$bd = $database;
    }

    public function __construct($argc = [])
    {
        $this->id = $argc['id'] ?? '';
        $this->titulo = $argc['titulo'] ?? '';
        $this->precio = $argc['precio'] ?? '';
        $this->imagen = $argc['imagen'] ?? 'imagen.jpg';
        $this->descripcion = $argc['descripcion'] ?? '';
        $this->habitaciones = $argc['habitaciones'] ?? '';
        $this->wc = $argc['wc'] ?? '';
        $this->estacionamiento = $argc['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $argc['vendedorId'] ?? '';
    }

    public function guardar(){
        //sanitizar los datos

        $atributos = $this->sanitizarAtributos();



      // Insertar en la base de datos
      $query = " INSERT INTO propiedades ( ";
      $query .= join(', ', array_keys($atributos));
      $query .= " ) VALUES (' ";
      $query .= join("', '", array_values($atributos));
      $query .= " ') ";

      $resultado = self::$bd->query($query);

     
    }

    //identificar y unir los atributos de la bd
    public function atributos(){
        $atributos = [];
        foreach(self::$columnasDB as $columna){
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos(){
        $atributos = $this->atributos();
       $sanitizado = [];
       foreach ($atributos as $key => $value){
           $sanitizado[$key] = self::$bd->escape_string($value);
       }
       return $sanitizado;
    }

    //Validación
    public static function getErrores(){
        return self::$errores;
    }

    public function validar(){
        if (!$this->titulo) {
            self::$errores[] = "Debes agregar un Titulo de Propiedad &#9888;";
        }
    
        if (!$this->precio) {
            self::$errores[] = "Debes agregar un Precio a la  Propiedad &#9888;";
        }
    
        if (strlen($this->descripcion) < 50) {
            self::$errores[] = "La Descripcion es Obligatoria y debe tenes como mínimo 50 caracteres &#9888;";
        }
    
        if (!$this->habitaciones) {
            self::$errores[] = "Debes agregar la cantidad de Habitaciones &#9888;";
        }
    
        if (!$this->wc) {
            self::$errores[] = "Debes agregar la cantidad de BaÑOs &#9888;";
        }
    
        if (!$this->estacionamiento) {
            self::$errores[] = "Debes agregar los lugares de estacionamiento &#9888;";
        }
    
        if (!$this->vendedorId) {
            self::$errores[] = "Debes seleccionar un Vendedor &#9888;";
        }
    
        // if (!$this->imagen['name'] || $imagen['error']) {
        //     self::$errores[] = 'La Imagen es Obligatoria &#9888;';
        // } 

        // //validar por peso 100 kb    
        // $medida = 1000 * 1000;    
        // if ($$this->imagen['size'] > $medida) {
        //     self::$errores[] = 'La imagen es muy pesada &#9888;';
        // }

        return self::$errores;
    }





    
}