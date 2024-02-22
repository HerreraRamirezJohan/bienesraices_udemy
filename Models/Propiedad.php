<?php

namespace Model;

class Propiedad extends ActiveRecord{
    protected static $table = 'propertie';

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
        $this->id = $args['id'] ?? null;
        $this->title = $args['title'] ?? '';
        $this->price = $args['price'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->description = $args['description'] ?? '';
        $this->rooms = $args['rooms'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->parking = $args['parking'] ?? '';
        $this->id_seller = $args['id_seller'] ?? '';
        $this->created_at = $args['created_at'] ?? '';
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
}