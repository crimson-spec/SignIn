<?php

/**
 * CAMINHOS ABSOLUTOS
 */

 $pastaInterna = "";
define('DIRPAGE', "http://{$_SERVER['HTTP_HOST']}/Login/{$pastaInterna}");
(substr($_SERVER['DOCUMENT_ROOT'], -1) == "/")?$barra="":$barra="/";
define('DIRREQ', "{$_SERVER['DOCUMENT_ROOT']}{$barra}Login/{$pastaInterna}");

/**
 * ATALHOS
 */

define('DIRIMG', DIRREQ."img/");
define('DIRCSS', DIRREQ."lib/css/");
define('DIRJS', DIRREQ."lib/js/");

/**
 * DADOS DE ACESSO AO DB
 */

define('HOST', "localhost");
define('DBNAME', "test");
define('USER', "root");
define('PASSWD', "");

/**
 * OUTRAS INFORMAÇÕES (GOOGLE CAPTCHA)
 */

define('SITEKEY',"6Lf1a_oUAAAAAJXPQbSVe55HM8uaKUG3z29_mNfB");
define('SECRETKEY', "6Lf1a_oUAAAAAHIXC_YmUFBJg0uWGlA_gfsyNTis");
define('DOMAIN', $_SERVER['HTTP_HOST']);

/**
 * CONSTANTRES DE EMAIL
 */

define('HOSTMAIL', 'smtp.sendgrid.net');
define('USERMAIL', 'apikey');
define('PASSMAIL', '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');