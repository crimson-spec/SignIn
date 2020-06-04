<?php

$validate = new Classes\ClassValidate;

$validate->validateFields($_POST);
$validate->validateEmail($email);
$validate->validateIssetEmail($email, "senha");
$validate->validateCaptcha($gRecaptchaResponse);
echo $validate->validateFinalSen($arrVar);