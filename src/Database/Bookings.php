<?php
namespace Arena\Database;

use \mysqli;

class Bookings {
  private static function getConn(): ?mysqli {
        return Connection::getConnection();
  }

  public static function createBooking(int $userID, int $stadiumID): array {
    $status = ["name" => NULL, "is_valid" => NULL, "email" => NULL];
    $conn = self::getConn();

    //Retrieve User Name
    $user = "SELECT name,email FROM users WHERE id=? and is_deleted=false;";
    $stmt = $conn->prepare($user);
    $stmt->bind_param("i",$userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_info =  $result->fetch_assoc();
    if(!isset($user_info)) {
        $status["is_valid"] = false;
        return $status;
    }

    //Create Booking
    $SQL = "INSERT INTO bookings(user_id,stadium_id) VALUES(?, ?)";
    $stmt = $conn->prepare($SQL);
    if (!$stmt) {
      $status["is_valid"] = false;
      return $status;
    }
    $stmt->bind_param("ii", $userID, $stadiumID);
    $stmt->execute();
    $stmt->close();
    $status = ["name" => $user_info["name"], "is_valid" => true, "email"=>$user_info["email"]];
    return $status;
 }
}
?>