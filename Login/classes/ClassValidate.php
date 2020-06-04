<?php

namespace Classes;

use Models\ClassCadastro;
use Models\ClassLogin;
use Classes\ClassPassword;
use Classes\ClassSessions;
use Classes\ClassMail;
use ZxcvbnPhp\Zxcvbn;


class ClassValidate
{
    private $erro=[];
    private $tentativas;
    private $cadastro;
    private $password;
    private $login;
    private $session;
    private $mail;

    public function __construct()
    {
        $this->cadastro = new ClassCadastro;
        $this->password = new ClassPassword;
        $this->login = new ClassLogin;
        $this->session = new ClassSessions;
        $this->mail = new ClassMail;
    }

    // Validar se os campos desejados foram preenchidos
    public function validateFields($par)
    {
        $i = 0;

        foreach ($par as $key => $values){
            if(empty($values)){
                $i++;
            }
        }

        if($i==0){
            return true;
        }else{
            $this->setErro("Preencha todos os dados!"); 
            return false;
        }
    }

    // Validação de email
    public function validateEmail($par)
    {
        if(\filter_var($par, FILTER_VALIDATE_EMAIL)){
            return true;
        }else{
            $this->setErro("Email Inválido!");
            return false;
        }
    }

    // Validar se o Email já existe no DB (action null para cadastro)
    public function validateIssetEmail($email, $action=null)
    {
        $result = $this->cadastro->getIssetEmail($email);

        if($action==null){
            if ($result > 0){
                $this->setErro("Email já cadastrado!");
                return false;
            }else{
                return true;
            }
        }else{
            if($result > 0){
                return true;
            }else{
                $this->setErro("Email não cadastrado!");
                return false;
            }
        }
    }

    // Validação de Data Nascimento
    public function validateData($par)
    {
        $data = \DateTime::createFromFormat("d/m/Y", $par);
        if(($data) && ($data->format("d/m/Y") == $par)){
            return true;
        }else{
            $this->setErro("Data de Nascimento Inválida!");
            return false;
        }
    }

    // Validação de CPF real
    public function validateCpf($par)
    {
        $cpf = preg_replace('/[^0-9]/', '', (string) $par);
        if (strlen($cpf) != 11){
            $this->setErro("Cpf Inválido!");
            return false;
        }
        for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
            $soma += $cpf{$i} * $j;
            $resto = $soma % 11;
        if ($cpf{9} != ($resto < 2 ? 0 : 11 - $resto)){
            $this->setErro("Cpf Inválido!");
            return false;
        }
        for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
            $soma += $cpf{$i} * $j;
            $resto = $soma % 11;
            return $cpf{10} == ($resto < 2 ? 0 : 11 - $resto);
    }

    // Verificar se a Senha é igual a ConfSenha
    public function validateConfSenha($senha, $senhaConf)
    {
        if ($senha === $senhaConf){
            return true;
        }else{
            $this->setErro("Senha diferente de confirmação!");
            return false;
        }
    }

    // Verificar a força da senha
    public function validateStrongSenha($senha, $par=null)
    {
        $zxcvbn = new Zxcvbn();
        $strength = $zxcvbn->passwordStrength($senha);
        
        if ($par==null){
            if ($strength['score'] >= 2){
                return true;
            }else{
                $this->setErro("Utilize uma senha mais segura!");
            }
        }else{

        }
        
    }

    // Verificar a senha digitada com o hash no DB
    public function validateSenha($email, $senha)
    {
        if ($this->password->verifyHash($email, $senha)){
            return true;
        }else{
            $this->setErro("Usuário ou Senha Inválidos!");
        }
    }

    // Verificar se o captcha está correto
    public function validateCaptcha($captcha, $score=0.5)
    {
        $return = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret="
        .SECRETKEY."&response=$captcha");
        $response = json_decode($return);

        if($response->success == true && $response->score >= $score){
            return true;
        }else{
            $this->setErro("Captcha Inválido! Tente atualizar a página!");
        }
    }

    // Validação Final do cadastro
    public function validateFinalCad($arrVar)
    {
        if (count($this->getErro()) > 0){
            $arrResponse = [
                "retorno" => "erro",
                "erros" => $this->getErro()
            ];
        }else{
            $this->mail->sendMail(
                $arrVar['email'],
                $arrVar['nome'],
                $arrVar['token'],
                "Confirme seu Email!",
                "<strong>Cadastro do site</strong>
                <br>
                Confirme seu email <a href='".DIRPAGE."controllers/controllerConfirmacao/
                {$arrVar['email']}/{$arrVar['token']}'>Clicando Aqui !</a>"
            );
            $arrResponse = [
                "retorno" => "success",
                "erros" => null
            ];
            $this->cadastro->insertCad($arrVar);
        }
        return json_encode($arrResponse);
    }

    // Validação Final de esqueci-minha-senha
    public function validateFinalSen($arrVar)
    {
        if (count($this->getErro()) > 0){
            $arrResponse = [
                "retorno" => "erro",
                "erros" => $this->getErro()
            ];
        }else{
            $this->mail->sendMail(
                $arrVar['email'],
                $arrVar['nome'],
                null,
                "Redefina sua Senha!",
                "<strong>Redefina sua senha!</strong> 
                <a href='".DIRPAGE."redefinicaoSenha/
                {$arrVar['email']}/{$arrVar['token']}'>Clicando Aqui !</a>"
            );

            $this->cadastro->insertConf($arrVar);

            $arrResponse = [
                "retorno" => "success",
                "erros" => null
            ];
        }
        return json_encode($arrResponse);
    }

    // Validação Final de redefinição de senha
    public function validateFinalRedefinirSen($arrVar, $token)
    {
        if (!$this->cadastro->confirmationSen($arrVar['email'], $token)){
            $this->setErro("Token para renovação Inválido!");
        }

        if (count($this->getErro()) > 0){
            $arrResponse = [
                "retorno" => "erro",
                "erros" => $this->getErro()
            ];
        }else{
            $this->login->updateDB(
                "Sistema",
                "senha=?",
                "email=?",
                [
                    $arrVar['hashSenha'],
                    $arrVar['email']
                ]
            );
            $this->cadastro->confirmationDel($arrVar['email']);
            $arrResponse = [
                "retorno" => "success",
                "page" => DIRPAGE."login",
                "erros" => null
            ];
        }
        return json_encode($arrResponse);
    }

    // Validação final do login
    public function validateFinalLogin($email)
    {
        if(count($this->getErro()) > 0){
            $this->login->insertAttempt();
            $arrResponse = [
                "retorno" => "erro",
                "erros" => $this->getErro(),
                "tentativas" => $this->tentativas
            ];
        }else{
            $this->login->deleteAttempt();
            $this->session->setSessions($email);
            $arrResponse = [
                "retorno" => "success",
                "page" => "areaRestrita",
                "tentativas" => $this->tentativas
            ];
        }

        return json_encode($arrResponse);
    }

    // Validação das tentativas
    public function validateAttemptLogin()
    {
        if($this->login->countAttempt() >= 5){
            $this->setErro("Você realizou muitas tentativas!");
            $this->tentativas = true;
            return false;
        }else{
            $this->tentativas = false;
            return true;
        }
    }

    // Método de validação de confirmação de mail
    public function validateUserActive($email)
    {
        $user = $this->login->getDataUser($email);
        if($user != null){
            if($user['data']['status'] == 'Confirmation'){
                if(strtotime($user['data']['dataCriacao']) <= strtotime(date("Y-m-d H:i:s"))-432000){
                    $this->setErro("Ative seu cadastro pelo link no email $email");
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        }
        
    }

    public function getErro()
    {
        return $this->erro;
    }

    public function setErro($erro)
    {
        array_push($this->erro, $erro);
    }
}