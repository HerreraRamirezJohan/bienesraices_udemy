<?php
namespace Modules;

use PDO;

class DB{
    protected static $db = [];
    protected static $dbSelected = '';

    public static function setDB($database, $connectionKey)
    {
        self::$db[$connectionKey] = $database;
    }

    protected static function execute($query, $params = [])
    {
        $connectionKey = self::$dbSelected;

        try {
            $stmt = self::$db[$connectionKey]->prepare($query);

            foreach ($params as $key => $value) {
                $stmt->bindParam($key, $value, PDO::PARAM_STR);
            }

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            debug($th->getMessage());
        }
    }

    public function setDbSelected($connectionKey){
        self::$dbSelected = $connectionKey;
        return $this;
    }
}