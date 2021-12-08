<?php

// Redirect to Home page if cookie expired

use Arena\Database\Bookings;

if (!$loggedInUser) {
    header("Location: index.php");
    exit();
}
$is_success = false;
$status = Bookings::getUserBookings($userID);
if (!$status["db_error"]) {
    $is_success = true;
}
?>
<header>
    <ul id="dropdown-account" class="dropdown-content">
        <li><a href="my-bookings.php" class="black-text">My Bookings</a></li>
        <li><a href="logout.php" class="black-text">Logout</a></li>
    </ul>

    <ul class="sidenav" id="sm-menu" appears="mobile">
        <li class="active"><a href="index.php">Home</a></li>
        <li><a href="my-bookings.php" class="black-text">My Bookings</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
    <nav>
        <div class="nav-wrapper blue-grey darken-4 z-depth-5">
            <a href="#" class="sidenav-trigger" data-target="sm-menu"><i class="material-icons">menu</i></a>
            <a href="./" class="brand-logo">Arena24</a>
            <ul class="right hide-on-med-and-down" appears="desktop">
                <li class="active"><a href="index.php">Home</a></li>
                <li><a href="stadiums-list.php">Find Arena</a></li>
                <li><a class="dropdown-trigger" href="#!" data-target="dropdown-account"><?php echo "Hi, $loggedInUser" ?><i class="material-icons right">arrow_drop_down</i></a></li>
            </ul>
        </div>
    </nav>
</header>
<main>
    <?php if (!$is_success || !isset($status['bookings']) || (isset($status['bookings']) && count($status['bookings']) == 0)) : ?>
        <div class="row">
                <h5 class="col s12 center-align">No results to display!</h5>
            </div>
    <?php else : ?>
        <table class="striped responsive-table centered">
        <thead>
            <tr>
                <th>Arena Name</th>
                <th>Location</th>
                <th>Phone Number</th>
                <th>Time</th>
                <th>Payment Status</th>
            </tr>
        </thead>

        <tbody>
        <?php foreach ($status['bookings'] as $booking) : ?>
            <tr>
                <td><?php echo $booking['name']?></td>
                <td><?php echo $booking['location']?></td>
                <td><?php echo $booking['phone_number']?></td>
                <td><?php echo $booking['slot']?></td>
                <td class="red-text">Not Paid</td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
        <?php endif; ?>

</main>