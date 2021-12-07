<?php
namespace Arena\Database;

use \mysqli;

class Users {

 private static function getConn(): ?mysqli {
     return Connection::getConnection();
 }

 public static function createUserAccount(string $name, string $email, string $password): ?string {
    $conn = self::getConn();

    //Check user account is present
    $user_exists = "SELECT id FROM users WHERE email=? and is_deleted=false;";
    $stmt = $conn->prepare($user_exists);
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_info =  $result->fetch_assoc();
    if(isset($user_info)) {
        return "Account Registered Already"; //TODO
    }

    //Create Hash of the Password
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $SQL = "INSERT INTO users(name, email, hash, is_activated) VALUES(?, ?, ?, true)";
    $stmt = $conn->prepare($SQL);
    if (!$stmt) {
        return "Transaction error"; //TODO
    }
    $stmt->bind_param("sss", $name, $email, $passwordHash);
    $stmt->execute();
    $stmt->close();
    return "Success"; //TODO
 }


 public static function authenticateUser(string $email, string $password): array {
    $status = ["db_error" => NULL, "is_valid" => NULL];
    $conn = self::getConn();

    $sql = "SELECT id,name,hash FROM users WHERE email=? and is_activated=true and is_deleted=false;";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $status["db_error"] = "Transaction error";
        return $status;
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    $user_info =  $result->fetch_assoc();
    if(!isset($user_info)) {
        $status["is_valid"] = false;
        return $status;
    }
    $status["is_valid"] = password_verify($password, $status['hash']) ? true : false;
    $status = array_merge($status,$user_info);
    return $status;
 }

 public static function updateAccountActive(int $id, string $email): string {
    $conn = self::getConn();

    $sql = "UPDATE users SET is_activated=true WHERE id=? and is_deleted=false";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param("is", $id, $email);
    $status = $stmt->execute();
    if(!$stmt) {
        return "Transaction error";
    }
    $stmt->close();
    return $status ? "Success" : "Failed";
 }
}
?>
