<?php

use Arena\Database\Stadiums;
// Redirect to Home page if cookie expired
if (!$loggedInUser) {
    header("Location: index.php");
    exit();
}
$is_success = false;
$status = Stadiums::getStadiumsList();
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
    <h4 class="center gray-text">Available Arenas</h4>
    <?php if (!$is_success) : ?>
        <div class="row">
            <div class="container center-align">
                <h6 class="col s12 red-text">
                    <b>Data Unavailable! Please try again!</b>
                </h6>
            </div>
        </div>
    <?php else : ?>
        <div class="container">
            <div class="row">
                <?php foreach ($status['list'] as $stadium) : ?>
                    <div class="col s12 m6">
                        <div class="card z-depth-3">
                            <div class="card-image">
                                <img loading="lazy" src="src/<?php echo $stadium['image_src'] ?>" style="height:220px">
                                <span class="card-title"><?php echo $stadium['name'] ?></span>
                            </div>
                            <div class="card-content">
                                <p class="left-align">
                                    Location: <?php echo $stadium['location'] ?><br>
                                    Number: <?php echo $stadium['phone_number'] ?>
                                </p>
                                <div class="divider"></div>
                                <p style="position: relative;top: 100%;transform: translateY(100%);display:block;font-size:small">
                                    <b>Available:</b> BasketBall, Tennis, Badminton, Cricket
                                </p>
                            </div>
                            <div class="card-action">
                                <a href="stadium-book.php?userid=<?php echo $userID?>&stadiumId=<?php echo $stadium['id']?>" class="blue-text">Book</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</main>