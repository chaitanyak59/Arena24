<?php
namespace Arena;
use Arena\Database\Users;
use Arena\Helpers\Mail;

$is_success = false;
$validationerrors = ["name" => NULL, "email" => NULL, "password" => NUll, "db_error" => NULL];
$name = $email = $password = '';
if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST['email']);
    $name = htmlspecialchars($_POST['name']);
    $password = htmlspecialchars($_POST['password']);
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid Email Address ";
        $validationerrors["email"] = $message;
    }
    if (empty($name) || strlen($name) < 3 || !preg_match('/^[a-zA-Z\s]+$/', $name)) {
        $validationerrors["name"] = "Invalid Account Name";
    }
    if (empty($password) || strlen($password) < 6) {
        $validationerrors["password"] = "Password should be minimum 6 characters";
    }
    //NO Errors Save to DB
    if (!array_filter($validationerrors)) {
        $status = Users::createUserAccount($name, $email, $password);
        if($status == "Success") {
            $is_success = true;
            Mail::notifyUserCreated($email, $name);
        } else {
            $validationerrors["db_error"] = "Failed to Create Account:[$status]";
        }
    }
}

?>
<main>
    <div class="container">
        <h3>Create Arena Account</h3>
        <?php if ($is_success) : ?>
            <div class="row">
                <h5 class="col s12"><blockquote>Status: Account Created Successfully</blockquote></h5>
                <p class="col s12">Confirmation email will be sent shortly.<sup><b style="color:blue">(Check spam if not received)</b></sup></p>
                <div class="col s6"> <a href="login.php" class="btn-small waves-effect waves-light blue-grey darken-4 white-text">Login</a></div>
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
                            <input value="<?php echo $email ?>" id="email" name="email" type="email" class="validate" required>
                            <label class="active" for="email">Email</label>
                            <span class="helper-text" data-success="Email validated"><?php echo $validationerrors["email"] ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="password" id="password" type="password" class="validate" min=6>
                            <label class="active" for="password">Password</label>
                            <span class="helper-text"><?php echo $validationerrors["password"] ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6">
                            <input type="submit" name="submit" value="Create Account" id="submit" class="btn blue-grey darken-4" />
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