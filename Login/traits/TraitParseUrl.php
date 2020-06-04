<?php

namespace Traits;

trait TraitParseUrl
{
    public static function parseUrl($par = null)
    {
        $url = explode("/", rtrim($_GET['url'], FILTER_SANITIZE_STRIPPED));
        
        return($par == null)?$url:$url[$par];
    }
}