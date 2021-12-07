<?php
use Arena\Helpers\Env;

setcookie('User', NULL, time() - 86400, "/", Env::getDomain(), isset($_SERVER["HTTPS"]), true);
setcookie('ID', NULL, time() - 86400, "/", Env::getDomain(), isset($_SERVER["HTTPS"]), true);
header("Location: ./");
?>