<?php

namespace Arena;

use Arena\{
    Database\Users,
    Helpers\Env
};

$is_success = false;
$validationerrors = ["email" => NULL, "password" => NULL, "db_error" => NULL];
$name = $email = $password = '';
if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid Email Address ";
        $validationerrors["email"] = $message;
    }
    if (empty($password) || strlen($password) < 6) {
        $validationerrors["password"] = "Invalid Password";
    }
    //NO Errors Save to DB
    if (!array_filter($validationerrors)) {
        $status = Users::authenticateUser($email, $password);
        if ($status["db_error"]) {
            $validationerrors["db_error"] = "Failed To Login: " . $status["db_error"];
        } else {
            if ($status["is_valid"]) {
                setcookie('User', $status['name'], time()+86400, "/", Env::getDomain(), Env::useHTTPS(), true);
                setcookie('ID', $status['id'], time()+86400, "/", Env::getDomain(), Env::useHTTPS(), true);
                $is_success = true;
                header("Location: ./");
            } else {
                $validationerrors["db_error"] = "User credentials are incorrect";
            }
        }
    }
}

?>
<main>
    <div class="container">
        <h3>Login to Arena</h3>
        <div class="row">
            <span class="helper-text"><?php echo $validationerrors["db_error"] ?></span>
            <form class="grey lighten-5 col s12" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="row">
                    <div class="input-field col s12">
                        <input value="<?php echo $email ?>" id="email" name="email" type="email" class="validate" required>
                        <label class="active" for="email">Email</label>
                        <span class="helper-text" data-success="Email validated"><?php echo $validationerrors["email"] ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input name="password" id="password" type="password" class="validate">
                        <label class="active" for="password">Password</label>
                        <span class="helper-text"><?php echo $validationerrors["password"] ?></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col s6">
                        <input type="submit" name="submit" value="Login" id="submit" class="btn blue-grey darken-4" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>