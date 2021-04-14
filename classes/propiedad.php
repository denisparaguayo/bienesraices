<?php

namespace App;

use finfo;

class Propiedad
{

    //BAse de datos
    protected static $bd;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

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

    //definir la conexión  la BD
    public static function setBD($database)
    {
        self::$bd = $database;
    }

    public function __construct($argc = [])
    {
        $this->id = $argc['id'] ?? '';
        $this->titulo = $argc['titulo'] ?? '';
        $this->precio = $argc['precio'] ?? '';
        $this->imagen = $argc['imagen'] ?? '';
        $this->descripcion = $argc['descripcion'] ?? '';
        $this->habitaciones = $argc['habitaciones'] ?? '';
        $this->wc = $argc['wc'] ?? '';
        $this->estacionamiento = $argc['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $argc['vendedorId'] ?? 1;
    }

    public function guardar(){
        if(isset($this->id)){
            //ACtualizar
            $this->actualizar();
        } else{
            //crear nuevo registro
            $this->crear();
        }

    }

    public function crear(){

        //sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO propiedades ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$bd->query($query);
        return $resultado;
    }

    public function actualizar(){
        //sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value){
            
        }
    }

    //identificar y unir los atributos de la bd
    public function atributos()
    {
        $atributos = [];
        foreach (self::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$bd->escape_string($value);
        }
        return $sanitizado;
    }

    // Subida de Archivos
    public function setImagen($imagen){
        //Elimina la Imagen Previa si no hay ID
        if (isset($this->id)) {
            //comprobar si existe el archivo
            $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
            if($existeArchivo){
                unlink(CARPETA_IMAGENES . $this->imagen);
            }
        }


        //Asignar al Atributo el nombre de la Imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    //Validación
    public static function getErrores()
    {
        return self::$errores;
    }

    public function validar()
    {
        if (!$this->titulo) {
            self::$errores[] = "Debes agregar un Titulo de Propiedad &#9888;";
        }

        if (!$this->precio) {
            self::$errores[] = "Debes agregar un Precio a la  Propiedad &#9888;";
        }

        if (strlen($this->descripcion) < 30) {
            self::$errores[] = "La Descripcion es Obligatoria y debe tenes como mínimo 30 caracteres &#9888;";
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

        if (!$this->imagen) {
            self::$errores[] = 'La Imagen es Obligatoria &#9888;';
        }      

        return self::$errores;
    }

    //Lista Todas los Registros
    public static function all(){
        
        $query = "SELECT * FROM propiedades";
        $resultado = self::consultarSQL($query);
        return $resultado;
        
    }

    //Busca un Registro por su ID

    public static function find($id){
        $query = "SELECT * FROM propiedades WHERE id = ${id}";

        $resultado = self::consultarSQL($query);

        return array_shift ( $resultado );
    }

    public static function consultarSQL($query){
        //Consultar la Base de Datos
        $resultado = self::$bd->query($query);

        //Recorrer los Resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array [] = self::crearObjeto($registro);
        }
        
        //Liberar la Memoria
        $resultado->free();

        //Retornar los Resultados
        return $array;

    }

    public static function crearObjeto($registro){
        $objeto = new self;
        foreach($registro as $key=> $value){
            if(property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // sincroniza el objeto en memoria con los cambios realizado por el usuario

    public function sincronizar($argc = []){
        foreach ($argc as $key => $value){
            if (property_exists ($this, $key ) && !is_null($value) ){
                
                $this-> $key = $value;

            }
        }
    }
}
