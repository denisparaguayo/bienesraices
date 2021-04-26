<?php

namespace App;

class ActiveRecord{
    //BAse de datos
    protected static $bd;
    protected static $columnasDB = [];
    protected static $tabla = '';

    //Errores

    protected static $errores = [];


   

    //definir la conexión  la BD
    public static function setBD($database)
    {
        self::$bd = $database;
    }
    

    public function guardar(){
        if(!is_null( ($this->id) )){
            //ACtualizar
            $this->actualizar();
        } else{
            //crear nuevo registro
            $this->crear();
            
        }

    }

    public function crear() {

        //sanitizar los datos
        $atributos = $this->sanitizarAtributos();       

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        $resultado = self::$bd->query($query); 
        //*Mensaje de Exito 
        if ($resultado) {
            //redireccionar al usuario después de que se valido su entrada
            header('Location: /admin?resultado=1');
        }

        
    }

    public function actualizar(){
        //sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];

        foreach($atributos as $key => $value){
            
            $valores [] = "{$key}='{$value}'";            
        }

        $query = " UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores );
        $query .= " WHERE id = '" . self::$bd->escape_string($this->id) . "' ";
        $query .= " LIMIT 1"; 

        $resultado = self::$bd->query($query);
        
        return $resultado;
      
        if ($resultado) {
            //redireccionar al usuario después de que se valido su entrada
             header('Location: /admin?resultado=2');
         }
    }

    public function eliminar(){
        
        //Elimina el registro
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$bd->escape_string($this->id) . " LIMIT 1" ; 
        $resultado = self::$bd->query($query);
        if ($resultado) {

            $this->borrarImagen();
            header('location: /admin?resultado=3');
        }
    }


    //identificar y unir los atributos de la bd
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    //Sanitizar los Atributos
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
        if ( !is_null ( ($this->id) )){
            $this->borrarImagen();
        }
        //Asignar al Atributo el nombre de la Imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    //Eliminar la Imagen
    public function borrarImagen(){
    //comprobar si existe el archivo
             $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
            if($existeArchivo){
            unlink(CARPETA_IMAGENES . $this->imagen);
         }

    }

    //Validación
    public static function getErrores()
    {   
        return static::$errores;
    }
    
    public function validar()
    {              
        static::$errores = [];
        return static::$errores;
    }

    //Lista Todas los Registros
    public static function all(){
        
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);
        return $resultado;
        
    }

    //Busca un Registro por su ID

    public static function find( $id ){
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id}";

        $resultado = self::consultarSQL( $query ) ;

        return array_shift ( $resultado );
    }

    public static function consultarSQL($query){
        //Consultar la Base de Datos
        $resultado = self::$bd->query($query);

        //Recorrer los Resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array [] = static::crearObjeto($registro);
        }
        
        //Liberar la Memoria
        $resultado->free();

        //Retornar los Resultados
        return $array;

    }

    public static function crearObjeto($registro){
        $objeto = new static;
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