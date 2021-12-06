<?php
namespace Arena\Helpers;

class App {
    public static function getWhitelistUrls(): array {
        return array( '127.0.0.1','::1');
    }

   public static function parseDBURL($url_string) {
        $parts = parse_url($url_string);
        $parts['port'] = isset($parts['port']) ? $parts['port'] : 3306;
        return [
            'user'	=> $parts['user'],
            'pass'	=> $parts['pass'],
            'host'	=> $parts['host'],
            'database'	=> substr($parts['path'], 1),
            'port'		=> $parts['port'],
        ];

    }
}

?>