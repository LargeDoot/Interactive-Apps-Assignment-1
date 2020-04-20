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
    require( "session.php" );

    //Check if an album_id was submitted, if not the redirect to music list page.
    if ( !isset( $_GET[ "track_id" ] ) ) {

//        header( "Location: music-list.php" );

    }

    ?>

</head>
<body>

<?php

$trackID = $_GET[ "track_id" ];


//Get the tracks
$statement = $connection->prepare( "SELECT * FROM tracks WHERE track_id = ?" );
$statement->bind_param( "s", $trackID );

$statement->execute();

$result = $statement->get_result();

$trackData = $result->fetch_assoc();

//Get the name of the logged in user
$statement = $connection->prepare( "SELECT name FROM login WHERE username = ?" );
$statement->bind_param( "s", $current_user );

$statement->execute();

$result = $statement->get_result();

$nameData = $result->fetch_assoc();
$name = $nameData["name"];


//Code to deal with the review form submission
$comment = "";

if ( $_SERVER[ "REQUEST_METHOD" ] == "POST" ) {

    if ( empty( $_POST[ "comment" ] ) ) {

        $comment = "This user did not leave a comment";

    } else {

        $comment = $_POST[ "comment" ];

    }
    $statement = $connection->prepare( "INSERT INTO reviews VALUES(NULL, ?, ?, ?, ?)" );
    $statement->bind_param( "ssss", $trackID, $name, $comment, $_POST[ "rating" ] );

    $statement->execute();

}


//Get reviews
$statement = $connection->prepare( "SELECT * FROM reviews WHERE track_id = ? ORDER BY `review_id` ASC" );
$statement->bind_param( "s", $trackID );

$statement->execute();

$result = $statement->get_result();
$numReviews = mysqli_num_rows( $result );

//Get average review
if($numReviews > 0) {

    $total = 0;

    while ( $trackReviewsData = $result->fetch_assoc() ) {

        $total += $trackReviewsData["rating"];

    }

    $average = $total/$numReviews;
} else {

    $average = 0;

}



//Get reviews again (reusing the query from before)
$statement->execute();
$result = $statement->get_result();

?>

<div class="container-fluid">

    <nav class="navbar fixed-top navbar-expand-sm bg-primary navbar-dark">

        <div class="container w-1200">

            <a href="welcome.php" class="navbar-brand">
                <img src="images/Potify_Logo.png" alt="Potify icon">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse" id="collapsibleNavbar">

                <ul class="navbar-nav ml-auto">

                    <li class="nav-item float-right">
                        <a class="nav-link px-4" href="music-list.php">Albums</a>
                    </li>

                    <li class="nav-item float-right">
                        <a class="nav-link border-left px-4 py-0 my-2" href="logout.php">Log out</a>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
</div>

<div class="container-fluid text-left bg-primary text-white"
     style="padding-top: 10vh; padding-bottom: 10vh">

    <div class="container mx-auto w-1200">

        <div class="row py-4">

            <div class="col-xl-9 col-lg-10">

                <h1 class="display-2"><?php echo( $trackData[ "name" ] ); ?></h1>

                <button type="button" name="play-button" class="btn btn-secondary mx-2"
                        data-value="<?php echo( $trackData[ "sample" ] ) ?>">▶
                </button>

                A track by <?php echo( $trackData[ "artist" ] ); ?>

                <pre>&#9;&#9;</pre>

                <?php echo("Average review: ");

                for($i = 0; $i < round($average/2); $i ++) {

                    echo("★");

                }

                for($i = 0; $i < (5 - round($average/2)); $i ++) {

                    echo("☆");

                }


                ?>

                </div>

            <div class="col-xl"></div>

        </div>
    </div>
</div>


<div class="container-fluid justify-content-center">

    <div class="container w-1200">

        <div class="row mt-5">

            <!-- Column for track info and review input -->
            <div class="col-lg-6 col-md-10">

                <h4>Track description:</h4>

                <p><?php echo( $trackData[ "description" ] ) ?></p>

                <hr>

                <h4>Write a review</h4>

                <form method="post" action="
                <?php echo htmlspecialchars( $_SERVER[ "PHP_SELF" ] . "?track_id=" . $_GET[ "track_id" ] ); ?>">

                    <div class="form-group">
                        <label for="comment">Comment:</label>
                        <textarea class="form-control mb-3" rows="3" id="comment" name="comment"></textarea>

                        <div class="row">
                            <div class="col-6">
                                <label style="white-space: nowrap;">Rating:
                                    <select class="form-control mb-3" name="rating">
                                        <option>1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                        <option>5</option>
                                        <option>6</option>
                                        <option>7</option>
                                        <option>8</option>
                                        <option>9</option>
                                        <option>10</option>
                                    </select>
                                </label>
                            </div>
                            <div class="col-6">
                                <button type="sumbit" class="btn btn-secondary float-right my-4">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

            <!-- Table for existing reviews -->
            <div class="col-lg-6 col-md-10">

                <table class="table table-hover text-left">
                    <thead>
                    <tr>
                        <th>User</th>
                        <th>Rating</th>
                        <th>Comment</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    while ( $trackReviewsData = $result->fetch_assoc() ) {

                        echo( '
                                <tr>
                                    <td>' . $trackReviewsData[ "name" ] . '</td>
                                    <td>' . $trackReviewsData[ "rating" ] . '</td>
                                    <td>' . $trackReviewsData[ "review" ] . '</td>
                                </tr>
                            ' );

                    }

                    ?>
                    </tbody>
                </table>

                <?php

                if ( $numReviews == 0 ) {

                    echo( 'No one has reviewed this track yet. Why not be the first?' );

                }

                ?>

            </div>
        </div>
    </div>
</div>

<div class="navbar fixed-bottom bg-primary justify-content-center">

    <audio controls id="player" style="width: 80%;">
        <source src="#" type="audio/mpeg">
        Your browser does not support the audio tag.
    </audio>

</div>

<script>

    let playButtonArray = document.getElementsByName("play-button");
    let player = document.getElementById("player");

    playButtonArray.forEach(function (element) {

        element.addEventListener("click", function () {

            player.setAttribute("src", element.getAttribute("data-value"));
            player.play();

        });

    });

</script>

</body>
</html>
