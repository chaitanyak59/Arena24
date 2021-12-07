<?php
    require_once realpath("vendor/autoload.php");

    //Load ENV if Exists
    $dotenv = \Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
    $dotenv->safeLoad();

    include_once "src/templates/header.php";
    include_once "src/stadiums-list-page.php";
    include_once "src/templates/footer.php";
?>