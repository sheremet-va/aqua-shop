<?php

class Db
{
    
    public static function getConnection()
    {
        $paramsPath = ROOT . '/config/db_params.php';
        $params = include($paramsPath);
        

        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']};charset=utf8";
        $opt = array(
            // PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_SILENT,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
        $db = new PDO($dsn, $params['user'], $params['password'], $opt);
        
        return $db;
    }

}