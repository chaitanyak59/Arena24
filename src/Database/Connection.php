<?php
namespace Arena\Database;

use \mysqli;
use Arena\{
    Helpers\App,
    Helpers\Env
};

class Connection {
  private static $connection = null;

  public static function getConnection(): ?mysqli {
      if(self::$connection == null) {
          $url = Env::getDBUrl();
          $parsed = App::parseDBURL($url);
          self::$connection = mysqli_connect($parsed['host'], $parsed['user'], $parsed['pass'], $parsed['database'], $parsed['port']);
          if(mysqli_connect_errno() || !self::$connection ) {
            die("Failed to Connect to Database");
          }
      }
      return self::$connection;
  }

  public static function closeConn(): bool {
      if(!self::$connection) {
          return false;
      }
      self::$connection->close();
      self::$connection = null;
      return true;
  }
}
?>