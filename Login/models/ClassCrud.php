<?php

namespace Models;

class ClassCrud extends ClassConexao
{
    private $crud;

    private function prepareExecute($query, $exec){
        $this->crud = $this->conectaDB()->prepare($query);
        $this->crud->execute($exec);
    }

    public function insertDB($table, $values, $exec)
    {
        $this->prepareExecute("INSERT INTO {$table} VALUES ({$values})", $exec);
        return $this->crud;
    }

    public function selectDB($fields, $table, $where, $exec)
    {
        if (empty($where)){
            $this->prepareExecute("SELECT {$fields} FROM {$table}", $exec);
        }else{
            $this->prepareExecute("SELECT {$fields} FROM {$table} WHERE {$where}", $exec);
        }
        return $this->crud;
    }

    public function updateDB($table, $values, $where, $exec)
    {
        $this->prepareExecute("UPDATE {$table} SET {$values} WHERE {$where}", $exec);
        return $this->crud;
    }

    public function deleteDB($table, $where, $exec)
    {
        $this->prepareExecute("DELETE FROM {$table} WHERE {$where}", $exec);
        return $this->crud;
    }
}