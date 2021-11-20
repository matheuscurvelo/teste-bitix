<?php

require_once "vendor/autoload.php";

if (isset($_GET['url'])) {
    $url = explode('/',$_GET['url']);

    if ($url[0] === 'api') {
        
        require_once 'api.php';

    } else {

        require_once 'web.php';

    }


} else {
    require_once 'public_html/index.php';
}

