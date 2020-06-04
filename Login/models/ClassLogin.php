<?php

namespace Models;

use Traits\TraitGetIp;

class ClassLogin extends ClassCrud
{
    private $trait;
    private $dateNow;

    public function __construct()
    {
        $this->trait = TraitGetIp::getUserIp(); 
        $this->dateNow = date("Y-m-d H:i:s");
    }

    // Retorna os dados do usuário
    public function getDataUser($email)
    {
        $data = $this->selectDB(
            "*",
            "Sistema",
            "email=?",
            [
                $email
            ]
        );

        $var1 = $data->fetch(\PDO::FETCH_ASSOC);
        $var2 = $data->rowCount();
        
        if ($var1 != null && $var2 != null){
            return $arrData = [
                "data" => $var1,
                "rows" => $var2
            ];
        }else{
            return null;
        }
    }

    // INSERI AS TENTATIVAS NO DB
    public function insertAttempt()
    {
        if($this->countAttempt() < 5){
            $this->insertDB(
                "attempt",
                "?,?,?",
                [
                    null,
                    $this->trait,
                    $this->dateNow
                ]
            );
        }
    }

    // CONTAGEM DE TENTATIVAS
    public function countAttempt()
    {
        $count = $this->selectDB(
            "*",
            "attempt",
            "ip=?",
            [
                $this->trait
            ]
        );

        $row = 0;

        while ($f = $count->fetch(\PDO::FETCH_ASSOC)){
            if (strtotime($f['date']) > strtotime($this->dateNow)-1200){
                $row++;
            }
        }

        return $row;

    }

    // DELETA AS TENTATIVAS
    public function deleteAttempt()
    {
        $this->deleteDB(
            "attempt",
            "ip=?",
            [
                $this->trait
            ]
            );
    }
}