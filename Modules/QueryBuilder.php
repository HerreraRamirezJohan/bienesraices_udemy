<?php
namespace Modules;

class QueryBuilder extends DB{
    protected static $table = '';
    private $select = '*';
    private $where = [];
    private $join = [];

    private $limit = 20000;
    private $param = [];
 
    public function __construct($table = null)
    {
        self::$table = $table;
    }

    public static function table($table)
    {
        return new static($table);
    }

    public function select($columns = '*')
    {
        $this->select = is_array($columns) ? implode(', ', $columns) : $columns;
        return $this;
    }

    public function where($column, $operator, $value){
        $this->param[$column] = $value; 
        $this->where[] = "$column $operator :$column";
        return $this;
    }

    public function join($table, $first, $operator, $second){
        $join = "INNER JOIN $table ON " . static::$table .".". $first . " $operator " . $table.".".$second . " ";
        $this->join [] = $join;

        return $this;
    }
    public function limit($limit){
        $this->limit = $limit;
        return $this;
    }

    public function get()
    {
        return DB::execute($this->createQuery(),$this->param);
    }

    public function toSql()
    {
        debug($this->createQuery());
    }

    private function createQuery(){
        $this->query = "SELECT TOP($this->limit) $this->select FROM " .  static::$table;

        if (!empty($this->join)) {
            $this->query .= ' ' . implode(' ', $this->join);
        }

        if (!empty($this->where)) {
            $this->query .= ' WHERE ' . implode(' AND ', $this->where);
        }

        return $this->query;
    }
}