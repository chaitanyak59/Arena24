<?php
namespace Database;

class Stadium {
    private static function getConn(): mysqli {
        return Connection::getConnection();
    }

    public static function createUserAccount(string $name, string $email, string $password): string {
        $conn = self::getConn();

        //Create Hash of the Password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $SQL = "INSERT INTO users(name, email, hash, is_activated) VALUES(?, ?, ?, true)";
        $stmt = $conn->prepare($SQL);
        if (!$stmt) {
            return "Failed"; //TODO
        }
        $stmt->bind_param("sss", $name, $email, $passwordHash);
        $stmt->execute();
        $stmt->close();
        return "Success"; //TODO
     }
}

?>