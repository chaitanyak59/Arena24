<?php
namespace Arena\Database;

use \mysqli;

class Users {

 private static function getConn(): mysqli {
     return Connection::getConnection();
 }

 public static function createUserAccount(string $name, string $email, string $password): ?string {
    $conn = self::getConn();

    //Create Hash of the Password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $SQL = "INSERT INTO users(name, email, hash, is_activated) VALUES(?, ?, ?, true)";
    $stmt = $conn->prepare($SQL);
    if (!$stmt) {
        return "Error Database"; //TODO
    }
    $stmt->bind_param("sss", $name, $email, $passwordHash);
    $stmt->execute();
    $stmt->close();
    return "Success"; //TODO
 }


 public static function authenticateUser(string $email, string $password): string {
    $conn = self::getConn();

    $sql = "SELECT id,email,hash FROM users WHERE email=? and is_actived=true and is_deleted=false;";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $user_info =  $result->fetch_assoc();
    if(count($user_info) == 0) {
        return "Failed";
    }
    if(!password_verify($password, $user_info['hash'])) {
        return "Failed";
    } else {
        return "Success";
    }
 }

 public static function updateAccountActive(int $id, string $email): string {
    $conn = self::getConn();

    $sql = "UPDATE stadiums SET is_activated=true WHERE id=? and is_deleted=false";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("is", $id, $email);
    $status = $stmt->execute();
    if(!$stmt) {
        return "Error Database";
    }
    $stmt->close();
    return $status ? "Success" : "Failed";
 }
}
?>
