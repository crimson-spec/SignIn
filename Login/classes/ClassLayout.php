<?php

namespace Classes;

class ClassLayout
{

    public static function setHeadRestrita($permition)
    {
        $session = new ClassSessions;
        $session->verifyInsideSession($permition);
    }

    public static function setHead($title, $description, $author = "Matheus")
    {
        $html = "<!DOCTYPE html>\n";
        $html .= "<html lang='pt-br'>\n";
        $html .= "<head>\n";
        $html .= "<meta charset='UTF-8'>\n";
        $html .= "<meta name='viewport' content='width=device-width, initial-scale='>\n";
        $html .= "<meta name='author' content='$author'>\n";
        $html .= "<meta name='format-detection' content='telephone=no'>\n";
        $html .= "<meta name='description' content='$description'>\n";
        $html .= "<title>$title</title>\n";

        //FAVICON
        
        $html .= "<link rel='stylesheet' href='".DIRPAGE."lib/css/style.css'>\n";
        $html .= "</head>\n";
        $html .= "<body>\n";

        echo $html;
    }

    public static function setFooter()
    {
        $html = "<script src='".DIRPAGE."lib/js/zepto.min.js'></script>\n";
        $html .= "<script src='".DIRPAGE."lib/js/vanilla-masker.min.js'></script>\n";
        $html .= "<script src='https://www.google.com/recaptcha/api.js?render=".SITEKEY."'></script>\n";
        $html .= "<script src='".DIRPAGE."lib/js/javascript.js'></script>\n";
        $html .= "</body>\n";
        $html .= "</html>\n";
        echo $html;
    }
}