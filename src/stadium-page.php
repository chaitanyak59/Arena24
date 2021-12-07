<?php
namespace Arena;
use Arena\Database\Stadiums;

$is_success = false;
$validationerrors = ["name" => NULL, "location" => NULL, "phone_number" => NUll, "max_bookings" => NULL, "db_error" => NULL];
$name = $location = $phone_number = '';
$max_bookings = NULL;
if (isset($_POST['submit'])) {
    $name = htmlspecialchars($_POST['name']);
    $location = htmlspecialchars($_POST['location']);
    $phone_number = htmlspecialchars($_POST['phone_number']);
    $max_bookings = (int)htmlspecialchars($_POST['max_bookings']);

    if (empty($name) || !preg_match('/^[a-zA-Z\s]+$/', $name)) {
        $validationerrors["name"] = "Stadium Name cannot be empty/invalid";
    }
    if (empty($location) || strlen($location) < 3 || !preg_match('/^[a-zA-Z\s]+$/', $location)) {
        $validationerrors["name"] = "Invalid Location";
    }
    if (empty($phone_number) || strlen($phone_number) < 10) {
        $validationerrors["phone_number"] = "Invalid Phone Number";
    }
    if (empty(htmlspecialchars($_POST['max_bookings'])) || $max_bookings > 50) {
        $validationerrors["max_bookings"] = "Invalid Max Bookings entered";
    }
    //NO Errors Save to DB
    if (!array_filter($validationerrors)) {
        $status = Stadiums::registerStadium($name, $location, $phone_number, $max_bookings);
        if($status == "Success") {
            $is_success = true;
        } else {
            $validationerrors["db_error"] = "Failed to Register Stadium:[$status]";
        }
    }
}

?>
<main>
    <div class="container">
        <h3>Register Your Arena</h3>
        <?php if ($is_success) : ?>
            <div class="row">
                <h5 class="col s12"><blockquote>Status: Stadium Registered Successfully</blockquote></h5>
                <div class="col s6">
                    <a href="index.php" class="btn-small waves-effect waves-light blue-grey darken-4">Go to Home</a>
                </div>
            </div>
        <?php else : ?>
            <div class="row">
                <span class="helper-text"><?php echo $validationerrors["db_error"] ?></span>
                <form class="grey lighten-5 col s12" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="row">
                        <div class="input-field col s12">
                            <input value="<?php echo $name ?>" id="name" name="name" type="text" class="validate" required>
                            <label class="active" for="name">Name</label>
                            <span class="helper-text"><?php echo $validationerrors["name"] ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input value="<?php echo $location ?>" id="location" name="location" type="text" class="validate" required>
                            <label class="active" for="location">Location</label>
                            <span class="helper-text"><?php echo $validationerrors["location"] ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="phone_number" id="phone_number" type="number" class="validate" minlength=10 maxlength=15>
                            <label class="active" for="phone_number">Phone Number</label>
                            <span class="helper-text"><?php echo $validationerrors["phone_number"] ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="max_bookings" id="max_bookings" type="number" class="validate" min=1 max=50 maxlength="2">
                            <label class="active" for="max_bookings">Maximum Available Bookings</label>
                            <span class="helper-text"><?php echo $validationerrors["max_bookings"] ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <input type="submit" name="submit" value="Register Stadium" id="submit" class="btn blue-grey darken-4" />
                        </div>
                        <div class="col s6">
                            <input type="reset" value="Reset" id="reset" class="btn blue-grey darken-4" />
                        </div>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</main>