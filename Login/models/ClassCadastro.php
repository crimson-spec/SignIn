<?php

namespace Models;

class ClassCadastro extends ClassCrud
{

    // Realizará a inserção no banco de dados
    public function insertCad($arrVar)
    {
        $this->insertDB(
            "Sistema",
            "?,?,?,?,?,?,?,?,?",
            [
                0,
                $arrVar['nome'],
                $arrVar['email'],
                $arrVar['hashSenha'],
                $arrVar['dataNasc'],
                $arrVar['cpf'],
                $arrVar['dataCreate'],
                'User',
                'Confirmation'
            ]
        );

        $this->insertConf($arrVar);
        
    }

    public function insertConf($arrVar)
    {
        $this->insertDB(
            "confirmation",
            "?,?,?",
            [
                0,
                $arrVar['email'],
                $arrVar['token']
            ]
        );
    }

    // Verificar diretamente no banco se o email está cadastrado
    public function getIssetEmail($email)
    {
        $consult = $this->selectDB(
            "*",
            "Sistema",
            "email=?",
            [
                $email
            ]
        );
        return $consult->rowCount();
    }

    // Verificar a confirmação de cadastro pelo email
    public function confirmationCad($email, $token)
    {
        $consult = $this->selectDB(
            "*",
            "confirmation",
            "email=? and token=?",
            [
                $email,
                $token
            ]
            );
            if($consult->rowCount() > 0){
                $this->confirmationDel($email);
                $this->confirmationUpdate($email);
                    return true;
                }else{
                    return false;
                }
    }

    public function confirmationSen($email, $token)
    {
        $consult = $this->selectDB(
            "*",
            "confirmation",
            "email=? and token=?",
            [
                $email,
                $token
            ]
            );
            if($consult->rowCount() > 0){
                    return true;
                }else{
                    return false;
                }
    }

    public function confirmationUpdate($email)
    {
        $this->updateDB(
            "Sistema",
            "status=?",
            "email=?",
            [
                "Active",
                $email
            ]
            );
    }

    public function confirmationDel($email)
    {
        $this->deleteDB(
            "confirmation",
            "email=?",
            [
                $email
            ]
        );
    }
}