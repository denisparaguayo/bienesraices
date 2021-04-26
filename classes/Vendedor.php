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
    
}