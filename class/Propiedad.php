<?php

namespace App;

class Propiedad {
    // BASE DE DATOS
    protected static $db;
    protected static $columnsDB = [
        'id',
        'title', 
        'price', 
        'imagen', 
        'description',
        'rooms',
        'wc',
        'parking',
        'id_seller'
    ];
    //Errores
    protected static $errores = [];

    public $id;
    public $title;
    public $price;
    public $imagen;
    public $description;
    public $rooms;
    public $wc;
    public $parking;
    public $id_seller;
    public $created_at;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->title = $args['title'] ?? '';
        $this->price = $args['price'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->description = $args['description'] ?? '';
        $this->rooms = $args['rooms'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->parking = $args['parking'] ?? '';
        $this->id_seller = $args['seller'] ?? '';
        $this->created_at = $args['created_at'] ?? '';
    }

    public function guardar() : bool {
        try {

            //Sanitizar los datos
            $atributos = $this->sanitizarAtributos();

            $query = "INSERT INTO propertie (";
            $query .= join(', ', array_keys($atributos));
            $query .= " ) VALUES ('";
            $query .= join("','", array_values($atributos));
            $query .= "')";

            self::$db->query($query);
        } catch (\Throwable $th) {
            echo "Error: " . $th->getMessage();
            return false;
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
        foreach (self::$columnsDB as $columna) {
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
        return self::$errores;
    }

    //Subida de archivos
    public function setImagen($imagen){
        if($imagen)
            $this->imagen = $imagen;
    }

    public function validar(){
        if(!$this->title)
            self::$errores["title"] = "Debes añadir un titulo";
        if(!$this->price)
            self::$errores["price"] = "Debes añadir un precio";
        if(!$this->description)
            self::$errores["description"] = "Debes añadir un descripción";
        if(strlen($this->description) < 30)
            self::$errores["description-len"] = "La descripcion debe ser de 30 caracteres";
        if(!$this->rooms)
            self::$errores["rooms"] = "Debes añadir una habitación";
        if(!$this->wc)
            self::$errores["wc"] = "Debes añadir un wc";
        if(!$this->parking)
            self::$errores["parking"] = "Debes añadir un estacionamiento";
        if(!$this->id_seller)
            self::$errores["seller"] = "Debes añadir un vendedor";
        if(!$this->imagen)
            self::$errores["imagen"] = "Debes añadir un una imagen";

        return self::$errores;
    }

    public static function all(){
        $query = "SELECT * FROM propertie";

        return self::consultarSQL($query);
    }

    public static function consultarSQL($query){
        $resultado = self::$db->query($query);

        $array = [];

        while($registro = $resultado->fetch_assoc()){
            $array [] = self::crearObjeto($registro);
        }

        $resultado->free();

        return $array;
    }

    protected static function crearObjeto($registro){
        $objeto = new self;
        foreach ($registro as $key => $value) {
            if(property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }
}