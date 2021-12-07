<?php
namespace Arena\Helpers;
use Arena\Helpers\App;

class Env {
    public static function getDBUrl(): string {
        if(self::isDev()) {
            return "mysql://chaitanya:123@localhost:3306/arena24";
        } else if(getenv("HEROKU")) {
            return getenv("CLEARDB_DATABASE_URL");
        }
        return "";
    }

    public static function isDev(): bool {
        return in_array($_SERVER['REMOTE_ADDR'], App::getWhitelistUrls());
    }

    //Temporary For Heroku Domains
    public static function getDomain(): string {
      return self::isDev() ? "localhost" : "arena-24.herokuapp.com";
    }
}

?>