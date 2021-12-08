<header>
<!-- Check Logged In or not -->
<ul id="dropdown-account" class="dropdown-content" >
    <?php if ($loggedInUser == NULL) : ?>
        <li><a href="login.php" class="black-text">Login</a></li>
        <li><a href="create-account.php" class="black-text">Signup</a></li>
    <?php else : ?>
        <li><a href="my-bookings.php" class="black-text">My Bookings</a></li>
        <li><a href="logout.php" class="black-text">Logout</a></li>
    <?php endif; ?>
</ul>

<ul class="sidenav" id="sm-menu" appears="mobile">
    <li class="active"><a href="#">Home</a></li>
    <li><a href="#" class="">About</a></li>
    <!-- Check Logged In or not -->
    <?php if ($loggedInUser == NULL) : ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="create-account.php">Signup</a></li>
    <?php else : ?>
        <li><a href="stadiums-list.php">Find Arena</a></li>
        <li><a href="my-bookings.php" class="black-text">My Bookings</a></li>
        <li><a href="logout.php" class="black-text">Logout</a></li>
    <?php endif; ?>
</ul>
    <nav>
        <div class="nav-wrapper blue-grey darken-4 z-depth-5">
            <a href="#" class="sidenav-trigger" data-target="sm-menu"><i class="material-icons">menu</i></a>
            <a href="./" class="brand-logo">Arena24</a>
            <ul class="right hide-on-med-and-down" appears="desktop">
                <li class="active"><a href="">Home</a></li>
                <li><a href="#" class="">About</a></li>
                <!-- Check Logged In or not -->
                <?php if ($loggedInUser == NULL) : ?>
                    <li><a class="dropdown-trigger" href="#!" data-target="dropdown-account">Account<i class="material-icons right">arrow_drop_down</i></a></li>
                <?php else : ?>
                    <?php if ($isSuperAdmin) : ?> <li><a href="create-stadium.php" class="">Register Arena</a></li> <?php endif; ?>
                    <li><a href="stadiums-list.php">Find Arena</a></li>
                    <li><a class="dropdown-trigger" href="#!" data-target="dropdown-account"><?php echo "Hi, $loggedInUser" ?><i class="material-icons right">arrow_drop_down</i></a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>
</header>