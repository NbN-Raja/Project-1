<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Register</title>
    <style>

    </style>


    <script>
    // function validateName() {
    //     var nameInput = document.getElementById("Name").value;
    //     var nameError = document.getElementById("nameError");
    //     if (!/^[A-Z][a-z]+(?:\s[A-Z][a-z]+)*$/.test(nameInput)) {
    //         nameError.textContent = "Please enter a valid Name. Start with a capital letter.";
    //         return false;
    //     } else {
    //         nameError.textContent = "";
    //         document.getElementById("Contact").disabled = false;
    //         return true;
    //     }
    // }

    // function validateContact() {
    //     var contactInput = document.getElementById("Contact");
    //     var contactError = document.getElementById("contactError");

    //     // Remove non-digit characters
    //     contactInput.value = contactInput.value.replace(/\D/g, '');

    //     // Trim to 10 digits if necessary
    //     if (contactInput.value.length > 10) {
    //         contactInput.value = contactInput.value.substring(0, 10);
    //     }

    //     // Validate the contact number
    //     if (!/^(98|97)\d{8}$/.test(contactInput.value)) {
    //         contactError.textContent =
    //             "Please enter a valid Contact Number. It should start with 98 or 97 followed by 8 digits.";
    //         document.getElementById("Registration").disabled = true;
    //     } else {
    //         contactError.textContent = "";
    //         document.getElementById("Registration").disabled = false;
    //     }
    // }

    // // Add an event listener to call validateContact on input
    // document.addEventListener("DOMContentLoaded", function() {
    //     document.getElementById("Contact").addEventListener("input", validateContact);
    // });

    // function validateRegistration() {
    //     var RegistrationInput = document.getElementById("Registration").value;
    //     var RegistrationError = document.getElementById("RegistrationError");
    //     var validRegistrationPattern = /^\d[A]-\d{2}-\d{4}$/;
    //     if (!validRegistrationPattern.test(RegistrationInput)) {
    //         RegistrationError.textContent = "Please enter a valid Registration number in the format XA-XX-XXXX.";
    //         document.getElementById("Password").disabled = true;
    //         return false;
    //     } else {
    //         RegistrationError.textContent = "";
    //         document.getElementById("Password").disabled = false;
    //         return true;
    //     }
    // }

    // function validatePassword() {
    //     var passwordInput = document.getElementById("Password").value;
    //     var passwordError = document.getElementById("passwordError");
    //     if (!/^(?=.*\d).{8,}$/.test(passwordInput)) {
    //         passwordError.textContent = "Password must have at least eight characters and one number.";
    //         return false;
    //     } else {
    //         passwordError.textContent = "";
    //         document.getElementById("retypepassword").disabled = false;
    //         return true;
    //     }
    // }
    </script>
</head>

<body>
    <div class="container">
        <div class="box form-box">
            <div class="">
                <h1>Online Voting System</h1>
            </div>
            <?php
            include("admin/inc/config.php");
            $message = '';

            if (isset($_POST['submit'])) {
                $Name = $_POST['Name'];
                $Contact = $_POST['Contact'];
                $Registration_No = $_POST['Registration_No']; // Ensure this matches your HTML form and database column
                $Password = $_POST['Password'];
                $retypepassword = $_POST['retypepassword'];

                if ($Password === $retypepassword) {
                    // SQL to prevent SQL Injection
                    $stmt = $db->prepare("INSERT INTO users(Name, Contact, Registration_No, Password) VALUES(?, ?, ?, ?)");
                    $stmt->bind_param("ssss", $Name, $Contact, $Registration_No, $Password);
                    $stmt->execute();

                    $message = "Registration successful!";
                } else {
                    $message = "Passwords do not match.";
                }
            }
            ?>
            <header>Register</header>
            <form action="" method="post" name="registrationForm">
                <div class="field input">
                    <label for="Name">Name</label>
                    <input type="text" name="Name" id="Name" autocomplete="off" required onkeyup="validateName()">
                    <p id="nameError" style="color: red;"></p>
                </div>

                <div class="field input">
                    <label for="Contact">Contact</label>
                    <input type="text" name="Contact" id="Contact" autocomplete="off" required
                        onkeyup="validateContact()" disabled>
                    <p id="contactError" style="color: red;"></p>
                </div>

                <div class="field input">
                    <label for="Registration">Registration No</label>
                    <input type="text" name="Registration_No" id="Registration" autocomplete="off" required
                        onkeyup="validateRegistration()" disabled>
                    <p id="RegistrationError" style="color: red;"></p>
                </div>

                <div class="field input">
                    <label for="Password">Password</label>
                    <input type="password" name="Password" id="Password" autocomplete="off" required
                        onkeyup="validatePassword()" disabled>
                    <p id="passwordError" style="color: red;"></p>
                </div>

                <div class="field input">
                    <label for="retypepassword">Confirm Password</label>
                    <input type="password" name="retypepassword" id="retypepassword" autocomplete="off" required
                        disabled>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Register">
                </div>
                <?php if (!empty($message)) : ?>
                <p style="color: red;"><?php echo $message; ?></p>
                <?php endif; ?>
                <div class="links">
                    Already registered? <a href="index.php">Login</a>
                </div>
            </form>
        </div>

    </div>
</body>

</html>