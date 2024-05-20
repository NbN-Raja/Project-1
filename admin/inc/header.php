<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <div class="container-fluid mt-2">
        <div class="row  text-black">

            <div>
                <h5> <?php
                        // Start the session

                        session_start();
                        // Get the username from the session
                        $username = $_SESSION['Name'];
                        // Use the username as needed
                        echo  $username;

                        ?></h5>
            </div>

            <div class="col-11 my-auto">
                <center>
                    <h3> <small>-Welcome To Admin Panel-</small> </h3>
                </center>
            </div>
        </div>
    </div>