<?php
namespace Modules;

use PDO;

class DB{
    protected static $db;

    public static function setDB($dbConnection)
    {
        self::$db = $dbConnection;
    }

    protected static function execute($query, $params = [])
    {
        try {
            $stmt = self::$db->prepare($query);

            foreach ($params as $key => $value) {
                $stmt->bindParam($key, $value, PDO::PARAM_STR);
            }

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\Throwable $th) {
            debug($th->getMessage());
        }
    }
}