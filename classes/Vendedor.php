<?php

namespace App;

class vendedor extends ActiveRecord {

    protected static $tabla = 'vendedores';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono'];
    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($argc = [])
    {
        $this->id = $argc['id'] ?? null;
        $this->nombre = $argc['nombre'] ?? '';
        $this->apellido = $argc['apellido'] ?? '';
        $this->telefono = $argc['telefono'] ?? '';
        
    }

    public function validar()
    {
        if (!$this->nombre) {
            self::$errores[] = "El Nombre es Obligatorio &#9888;";
        }
        if (!$this->apellido) {
            self::$errores[] = "El Apellido es Obligatorio &#9888;";
        }
        if (!$this->telefono) {
            self::$errores[] = "El Telefono es Obligatorio &#9888;";
        }

        if (!preg_match('/[0-9]{10}/', $this->telefono)) {
            self::$errores[] = "El Telefono solo debe Contener Número de Celular &#9888;";
        }

        return self::$errores;
    }
}