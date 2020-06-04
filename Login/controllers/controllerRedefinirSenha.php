<?php

    $validate = new Classes\ClassValidate;

    $validate->validateFields($_POST);
    $validate->validateConfSenha($senha, $senhaConf);
    $validate->validateStrongSenha($senha);

    echo $validate->validateFinalRedefinirSen($arrVar, $_POST['token']);