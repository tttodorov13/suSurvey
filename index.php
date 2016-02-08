<?php
    // root dir
    define('ROOT_DIR', './');

    // include the configs
    require_once ROOT_DIR . 'config/config.php';

    // select language
    require_once ROOT_DIR . 'lang/lang.php';
    
    // include the page template
    require_once ROOT_DIR . 'pages/main.php';
?>
