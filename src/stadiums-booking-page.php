<?php

use Arena\Database\Bookings;
use Arena\Helpers\Mail;

$is_success = false;
if (isset($_GET['userid']) && isset($_GET['stadiumId'])) {
    $userID = (int)$_GET['userid'];
    $stadiumID = (int) $_GET['stadiumId'];
    $status = Bookings::createBooking($userID, $stadiumID);
    if($status["is_valid"]) {
        Mail::notifySpotBooked($status["email"], $status["name"]);
        $is_success = true;
    }
} else {
    header("Location: stadiums-list.php");
    exit();
}

?>
<main>
<div class="container">
        <h3>Arena Booking</h3>
        <?php if ($is_success) : ?>
            <div class="row">
                <h5 class="col s12"><blockquote>Status: Booking Created Successfully</blockquote></h5>
                <p class="col s12">Check your email for more details.</p>
                <div class="col s6"> <a href="bookings.php" class="btn-small waves-effect waves-light blue-grey darken-4 white-text">Your Bookings</a></div>
            </div>
        <?php else : ?>
            <div class="row">
                <h5 class="col s12"><blockquote>Status: Failed to create Booking!, Try again</blockquote></h5>
            </div>
        <?php endif; ?>
    </div>
</main>