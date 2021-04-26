<?php

namespace App;



class Propiedad extends ActiveRecord{

    protected static $tabla = 'propiedades';
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];
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

    public function __construct($argc = [])
    {
        $this->id = $argc['id'] ?? null;
        $this->titulo = $argc['titulo'] ?? '';
        $this->precio = $argc['precio'] ?? '';
        $this->imagen = $argc['imagen'] ?? '';
        $this->descripcion = $argc['descripcion'] ?? '';
        $this->habitaciones = $argc['habitaciones'] ?? '';
        $this->wc = $argc['wc'] ?? '';
        $this->estacionamiento = $argc['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $argc['vendedorId'] ?? '';
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
            self::$errores[] = 'La Imagen de la Propiedad es Obligatoria &#9888;';
        }      

        return self::$errores;
    }
    
}
