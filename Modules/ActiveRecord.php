<?php
namespace Modules;

class ActiveRecord extends QueryBuilder{
    protected static $columsDB = [];
    protected static $table = '';
    protected static $errors = [];

    public function get(){
        $data = parent::get();

        $array = [];
        foreach($data as $key => $value){
            $array [] = static::createObject($value);
        }

        return $array;
    }

    protected static function createObject($args){
        $object = new static;

        foreach ($args as $key => $value) {
            if(property_exists($object, $key)){
                $object->$key = $value;
            }
        }

        return $object;
    }

    public function join($table, $first, $operator, $second){
        debug("[Error: Modules\ActiveRecord] No es posible usar el metodo JOIN en una instancia de Clase.");
    }
}