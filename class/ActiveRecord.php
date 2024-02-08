<?php

namespace App;

class ActiveRecord{
    // BASE DE DATOS
    protected static $db;
    protected static $columnsDB = [];
    protected static $table = '';
    //Errores
    protected static $errores = [];

    

    

    public function guardar(){
        if($this->id){
            return $this->actualizar();
        }else{
            return $this->crear();
        }
    }
    public function eliminar(){
        $query = "DELETE FROM " . static::$table . " WHERE id = " .  self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if($resultado){
            header('location: /admin?success=3');
        }
    }
    public function crear() : bool {
        try {

            //Sanitizar los datos
            $atributos = $this->sanitizarAtributos();

            $query = "INSERT INTO " . static::$table . " (";
            $query .= join(', ', array_keys($atributos));
            $query .= " ) VALUES ('";
            $query .= join("','", array_values($atributos));
            $query .= "')";

            $result = self::$db->query($query);

            if($result)
                header("Location: /admin?success=1");
        } catch (\Throwable $th) {
            echo "Error: " . $th->getMessage();
            return false;
        }

        return true;
        
    }
    public function actualizar(){
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];

        foreach ($atributos as $key => $value) {
            $valores[] = "$key='$value'";
        }

        $query = "UPDATE " . static::$table . " SET ";
        $query .= join(", ",$valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "'";
        $query .= " LIMIT 1";

        try {
            $result = self::$db->query($query);

        } catch (\Throwable $th) {
            debug($th->getMessage());
        }
        return true;
    }

    //Definir la conexion
    public static function setDB($database) {
        self::$db = $database;
    }

    // Identificar y unir los atributos de la DB
    private function atributos(){
        $atributos = [];
        foreach (static::$columnsDB as $columna) {
            if($columna === 'id') continue; // Ignorar el siguiente codigo del forech y va a la siguiente iteracion
            $atributos[$columna] = $this->$columna;
        }

        return $atributos;
    }
    //Limpiar datos
    private function sanitizarAtributos(){
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value); 
        }

        return $sanitizado;
    }

    //Validacion
    public static function getErrores() : array {
        return static::$errores;
    }

    //Subida de archivos
    public function setImagen($imagen){

        if(isset($this->id)){//detecta si se esta editando un registro
            $existFile = file_exists(CARPETA_IMAGENES . $this->imagen);
            if($existFile){
                unlink(CARPETA_IMAGENES . $this->imagen);
            }
        }

        if($imagen)
            $this->imagen = $imagen;
    }

    public function validar(){
        static::$errores = [];
        return static::$errores;
    }

    public static function all(){
        $query = "SELECT * FROM " . static::$table;

        return self::consultarSQL($query);
    }
    public static function find($id){
        $query = "SELECT * FROM " . static::$table . " where id = $id";
        $result = self::consultarSQL($query);
        return array_shift($result);
    }

    public static function consultarSQL($query){
        $resultado = self::$db->query($query);

        $array = [];

        while($registro = $resultado->fetch_assoc()){
            $array [] = static::crearObjeto($registro);
        }

        $resultado->free();

        return $array;
    }

    protected static function crearObjeto($registro){
        $objeto = new static;
        foreach ($registro as $key => $value) {
            if(property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    //Sincornizar el objeto con los cambios realizados por el usuario
    public function sincronizar($args = []){
        foreach ($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)){
                $this->$key = $value;
            }
        }
    }
}