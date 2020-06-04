<?php

namespace Classes;

use Models\ClassLogin;

class ClassPassword
{
    private $db;

    public function __construct()
    {
        $this->db = new ClassLogin;
    }

    // Criar o Hash da senha para salvar no DB
    public function passwordHash($senha)
    {
        return password_hash($senha, PASSWORD_DEFAULT);
    }

    // Verificar se o hash corresponde ao DB
    public function verifyHash($email, $senha)
    {
        $hashDB = $this->db->getDataUser($email);
        if (is_array($hashDB)){
            return password_verify($senha, $hashDB['data']['senha']);
        }else{
            return null;
        }
        
    }
}