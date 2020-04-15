<!DOCTYPE html>

<!-- Template used from https://www.w3schools.com/bootstrap4/tryit.asp?filename=trybs_template1 -->

<html lang="en">
<head>

    <title>Potify Music</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="custom-theme-colours.css">
    <link rel="stylesheet" href="stylesheet.css">

    <!-- Link to font awesome icon library where all icons used are taken from. -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>

    <?php
    require( "db_connection.php" );
    ?>


</head>
<body>

<?php
//test_input function is taken from https://www.w3schools.com/php/php_comments.asp

//Variables for holding form contents and
$emailErr = $passwordErr = $passwordMatchErr = $packageErr = $termsErr = "";
$email = $password = $passwordMatch = $package = $terms = "";

$success = true;

if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {

    // Check if the email field is empty, if so, deny the request
    if ( empty( $_POST[ "email" ] ) ) {
        $emailErr = ( "Email address is required." );
        $success = false;
    } // Check if the email is already in use, if so, deny the request and set the email variable
    elseif ( check_email( $connection, $_POST[ "email" ] ) == true ) {
        $emailErr = ( "Email address is already in use!" );
        $success = false;
        $email = test_input( $_POST[ "email" ] );
    } // Success case
    else {
        $email = test_input( $_POST[ "email" ] );
    }

    // Check if the password field is empty, if so, deny the request
    if ( empty( $_POST[ "password" ] ) ) {
        $passwordErr = ( "Password is required." );
        $success = false;
    } // Check if the passwords match, if not then deny the request
    elseif ( strlen( $_POST[ "password" ] ) < 5 ) {
        $passwordErr = ( "Password must be longer than 5 characters!" );
        $success = false;
    } // Success case
    else {
        $password = htmlspecialchars( $_POST[ "password" ] );
    }

    // Check if the confirm password field is empty, if so, deny the request
    if ( !empty( $_POST[ "password_conf" ] ) ) {

        //Check if the passwords match, if they don't then set success variable to false
        if ( $_POST[ "password" ] == $_POST[ "password_conf" ] ) {
            $passwordMatch = htmlspecialchars( $_POST[ "password_conf" ] );
        } else {
            $success = false;
        }
    }

    //Check that a package was chosen, if the default option is still selected deny the request
    if ( $_POST[ "package" ] == "default" ) {
        $packageErr = ( "Please select a package." );
        $success = false;
    } //Success case
    else {
        $package = test_input( $_POST[ "package" ] );
    }

    //Check the the terms and conditions were accepted, if not then deny the request
    if ( empty( $_POST[ "terms" ] ) ) {
        $termsErr = ( "Please accept the terms and conditions." );
        $success = false;
    } else {
        $terms = test_input( $_POST[ "terms" ] );
    }

    //Check for successful submission
    if ( $success ) {

        //Insert new user's details into login table
        $newID = mysqli_query( $connection, "SELECT MAX(id) FROM login" );
        $newIDNum = mysqli_fetch_row( $newID )[ 0 ] + 1;

        //Hash the password using PHPs password hash function
        //At time of writing the hashing algorithm used is bcrypt
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO login VALUES ($newIDNum, '$email', '$password', '$package')";
        $query = htmlspecialchars( $query );

        mysqli_query( $connection, $query );

        //Start a new session and redirect user
        session_start();

        $_SESSION[ "username" ] = $email;

        header( "Location: music-list.php" );


    }

}

/**
 * Takes an input and removes slashes, whitespace, and also runs 'htmlSpecialChars' on the
 * input to avoid any exploitation of the form
 *
 * @param data     the data to be cleansed
 * @return string   the cleansed data
 */
function test_input( $data )
{
    $data = trim( $data );
    $data = stripslashes( $data );
    $data = htmlspecialchars( $data );
    return $data;
}

/**
 * Searches the database for an email that matches the input, if it exists it will return true
 *
 * @param connection   the mysqli database object
 * @param email        the email address to search for
 * @return bool         true if email si in database, false otherwise
 */
function check_email( $connection, $email )
{
    $query = "SELECT username FROM login WHERE username = '$email'";
    $result = mysqli_query( $connection, $query );

    if ( mysqli_num_rows( $result ) > 0 ) {
        return true;
    } else {
        return false;
    }
}

?>

<div class="container-fluid">

    <nav class="navbar fixed-top navbar-expand-sm bg-primary navbar-dark">

        <div class="container w-1200">

            <a href="index.php" class="navbar-brand">
                <img src="images/Potify_Logo.png" alt="Potify icon">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse" id="collapsibleNavbar">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item float-right">
                        <a class="nav-link px-4" href="offers.php">Go Premium</a>
                    </li>

                    <li class="nav-item float-right">
                        <a class="nav-link border-left px-4 py-0 my-2" href="register.php">Register</a>
                    </li>

                    <li class="nav-item float-right">
                        <a class="nav-link px-4 active" href="login.php">Login</a>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
</div>

<br><br><br><br><br>

<!-- Used some small snipets of code from https://www.w3schools.com/php/php_form_required.asp for form -->

<div class="container-fluid">

    <div class="container w-1200 text-center" style="height:78vh;">

        <span class="display-3">Sign up</span> <br>
        <span class="text-muted">Already a member? Login <a href="login.php">here</a></span>

        <form method="post" action="<?php echo htmlspecialchars( $_SERVER[ "PHP_SELF" ] ); ?>">
            <div class="form-group w-500 mx-auto my-5">

                <span class="text-danger"><?php echo $emailErr; ?></span>
                <input type="email" class="form-control my-2" placeholder="Email address" value="<?php echo $email; ?>"
                       name="email"/>

                <span class="text-danger"><?php echo $passwordErr; ?></span>
                <span class="text-danger"><?php echo $passwordMatchErr; ?></span>
                <input type="password" class="form-control my-2" placeholder="Password"
                       name="password"/>
                <input type="password" class="form-control my-2" placeholder="Confirm password"
                       name="password_conf"/>

                <span class="text-danger"><?php echo $packageErr; ?></span>
                <select class="form-control" name="package">
                    <option value="default"
                            default <?php echo( $package == "default" ? "selected='selected'" : null ); ?>>Choose
                        Package
                    </option>
                    <option value="silver" <?php echo( $package == "silver" ? "selected='selected'" : null ); ?>>Silver
                    </option>
                    <option value="gold" <?php echo( $package == "gold" ? "selected='selected'" : null ); ?>>Gold
                    </option>
                    <option value="platinum" <?php echo( $package == "platinum" ? "selected='selected'" : null ); ?>>
                        Platinum
                    </option>
                    <option value="family" <?php echo( $package == "family" ? "selected='selected'" : null ); ?>>Family
                    </option>
                </select>

                <br>

                <span class="text-danger"><?php echo $termsErr; ?></span>
                <label class="form-check-label">
                    <input type="checkbox" class="form-check-input" name="terms">I accept the <a href="#">terms and
                        conditions</a>.
                </label>
                <br>

                <input type="submit" name="submit" value="Submit" class="btn btn-secondary mt-5 font"/>

            </div>
        </form>
    </div>
</div>

<div class="container-fluid" style="height: 10vh;">
    <div class="row text-center text-white bg-primary justify-content-center pt-3" style="height: 100%;">
        <div class="col w-1200 justify-content-center">
            <i class="fab fa-twitter fa-4x px-4"></i>
            <i class="fab fa-facebook fa-4x px-4"></i>
            <i class="fab fa-instagram fa-4x px-4"></i>
        </div>
    </div>
</div>

</body>
</html>
