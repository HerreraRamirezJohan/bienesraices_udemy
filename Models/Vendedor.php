<?php
namespace Model;

class Vendedor extends ActiveRecord{
    protected static $table = 'seller';

    protected static $columnsDB = [
        'id',
        'name', 
        'lastname', 
        'phone',
    ];

    public $id;
    public $name;
    public $lastname;
    public $phone;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->name = $args['name'] ?? null;
        $this->lastname = $args['lastname'] ?? null;
        $this->phone = $args['phone'] ?? null;
    }

    public function validar(){
        if(!$this->name)
            self::$errores["name"] = "Debes añadir un nombre";
        if(!$this->lastname)
            self::$errores["lastname"] = "Debes añadir un apellido";
        if(!$this->phone)
            self::$errores["phone"] = "Debes añadir un número telefonico";
        if(!preg_match('/^[0-9]{10}$/', $this->phone))
            self::$errores["formato"] = "El formato del telefono es invalido";
        return self::$errores;
    }
}