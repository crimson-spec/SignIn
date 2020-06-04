<?php

$email=\Traits\TraitParseUrl::parseUrl(2);
$token=\Traits\TraitParseUrl::parseUrl(3);

$confirmation = new Models\ClassCadastro;

if($confirmation->confirmationCad($email, $token)){
    echo "
        <script>
            alert('Cadastro confirmado com sucesso!');
            window.location.href='".DIRPAGE."login';
        </script>
    ";
}else{
    echo "
        <script>
            alert('Não foi possivel confirmar seus dados!');
            window.location.href='".DIRPAGE."';
        </script>
    ";
}