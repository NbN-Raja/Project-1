<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Login</title>
    <style>
    .img {
        background-image: url('img/blue.jpg');
        background-size: cover;
        height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: white;
    }

    .form-container {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
    }

    .form-box {
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        background-color: #f9f9f9;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .form-box h3 {
        margin-bottom: 20px;
    }

    .form-box form {
        max-width: 300px;
        margin: 0 auto;
    }

    .field {
        margin-bottom: 20px;
    }

    .field label {
        display: block;
        margin-bottom: 5px;
    }

    .field input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .btn {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color: #007bff;
        color: white;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .links {
        margin-top: 15px;
        text-align: center;
    }

    .links a {
        color: #007bff;
        text-decoration: none;
    }

    .links a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-container">
            <div class="box form-box">
                <?php
                include("admin/inc/config.php");

                if (isset($_POST['submit'])) {
                    $name = $_POST['Name'];
                    $password = $_POST['Password'];

                    $query = "SELECT * FROM users WHERE name='" . $name . "' AND password='" . $password . "'";
                    $result = mysqli_query($db, $query);

                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();

                        session_start();
                        $_SESSION['user_role'] = $row['user_role'];
                        $_SESSION['Name'] = $row['Name'];
                        $_SESSION['user_id'] = $row['id'];

                        if ($row['user_role'] == "Admin") {
                            $_SESSION['key'] = "AdminKey";
                            echo "<script> location.assign('admin/adminhome.php?homepage=1'); </script>";
                        } else {
                            $_SESSION['key'] = "VotersKey";
                            echo "<script> location.assign('voters/home.php'); </script>";
                        }
                        exit;
                    } else {
                        echo "<p>Invalid username or password.</p>";
                    }
                }
                ?>

                <div class="form-box">
                    <form action="" method="post">
                        <h3>Login</h3>
                        <div class="field input">
                            <label for="Name">Name</label>
                            <input type="text" name="Name" id="Name" autocomplete="off" required>
                        </div>

                        <div class="field input">
                            <label for="Password">Password</label>
                            <input type="Password" name="Password" id="Password" autocomplete="off" required>
                        </div>

                        <div class="field">
                            <input type="submit" class="btn" name="submit" value="Login">
                        </div>

                        <div class="links">
                            Not registered? <a href="register.php">Register</a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div class="">
            <h1>Online Voting System</h1>
            <p>Your voice your vote</p>
        </div>
    </div>
</body>

</html>