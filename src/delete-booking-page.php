<?php

use Arena\Database\Bookings;
use Arena\Helpers\Mail;

$is_success = false;
if (isset($_GET['id']) && $_COOKIE['ID']) {
    $user_id = (int)$_COOKIE['ID'];
    $deleteID = (int) $_GET['id'];
    $status = Bookings::deleteBooking($user_id, $deleteID);
    if($status["is_valid"]) {
        Mail::notifySpotCancelled($status["email"], $status["name"]);
        $is_success = true;
    }
} else {
    header("Location: index.php");
    exit();
}

?>
<main>
<div class="container">
        <h3>Arena Booking Cancellation</h3>
        <?php if ($is_success) : ?>
            <div class="row">
                <h5 class="col s12"><blockquote>Status: Booking Cancelled Successfully</blockquote></h5>
                <p class="col s12">Check your email for more details.<sup><b style="color:blue">(Check spam if not received)</b></sup></p>
                <div class="col s6"> <a href="my-bookings.php" class="btn-small waves-effect waves-light blue-grey darken-4 white-text">Your Bookings</a></div>
            </div>
        <?php else : ?>
            <div class="row">
                <h5 class="col s12"><blockquote>Status: Failed to Cancel Booking!, Try again</blockquote></h5>
            </div>
        <?php endif; ?>
    </div>
</main>