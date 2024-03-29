<?php
namespace Arena\Database;

use \mysqli;

class Stadiums {
    private static function getConn(): ?mysqli {
        return Connection::getConnection();
    }

    public static function registerStadium(string $name,
            string $location,
            string $phone_number,
            int $max_bookings
    ): string {
        $conn = self::getConn();

        $SQL = "INSERT INTO stadiums(name, location, phone_number, max_bookings, image_src) VALUES(?, ?, ?, ?, NULL)";
        $stmt = $conn->prepare($SQL);
        if (!$stmt) {
            return "Error Database"; //TODO
        }
        $stmt->bind_param("sssi", $name, $location, $phone_number, $max_bookings);
        $stmt->execute();
        $stmt->close();
        return "Success"; //TODO
     }

     public static function getStadiumsList(): array {
        $status = ["db_error" => NULL, "list" => NULL];
        $conn = self::getConn();

        $sql = "SELECT * FROM stadiums WHERE is_active=true and is_deleted=false;";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            $status["db_error"] = "Transaction error";
            return $status;
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        $status["list"] =  $result->fetch_all(MYSQLI_ASSOC);
        return $status;
     }
}
?>