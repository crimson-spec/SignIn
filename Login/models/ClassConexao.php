<?php

namespace Models;

abstract class ClassConexao
{
    protected function conectaDB(){
        try{
            $connection = new \PDO(
                "mysql:host=".HOST.";dbname=".DBNAME,
                USER,
                PASSWD
            );

            return $connection;
        }catch(\PDOException $exception){
            return $exception->getMessage();
        }
    }
}