<?php
session_start(); // Ensure session is started
require_once("inc/header.php");
require_once("inc/navigation.php");

// Ensure user is logged in or redirect
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Database connection
$db = mysqli_connect("localhost", "root", "", "project") or die("Connectivity Failed");

// Start the main container
echo '<div class="container my-5">';
echo '<div class="row justify-content-center">';
echo '<div class="col-md-8">';
echo '<div class="card">';
echo '<div class="card-header"><h3 class="text-center">Voters Panel</h3></div>';
echo '<div class="card-body">';

// Get the session user ID
$id = $_SESSION['user_id'];

// Fetch voter data from the database
$queryVoters = "SELECT Name, Contact, Registration_No FROM users WHERE id= '$id'";
$resultVoters = mysqli_query($db, $queryVoters);

// Check if data is found and display it
if (mysqli_num_rows($resultVoters) > 0) {
    while ($voter = mysqli_fetch_assoc($resultVoters)) {
        // Retrieve values
        $name = htmlspecialchars($voter['Name']);
        $contact = htmlspecialchars($voter['Contact']);
        $registrationNo = htmlspecialchars($voter['Registration_No']);

        // Display voter information
        echo '<div class="section mb-3">';
        echo 'User details';
        echo '<div class="mb-2"><strong>Name:</strong> ' . $name . '</div>';
        echo '<div class="mb-2"><strong>Contact:</strong> ' . $contact . '</div>';
        echo '<div class="mb-2"><strong>Registration No:</strong> ' . $registrationNo . '</div>';
        echo '</div>';
    }
} else {
    // Display a message if no data is found
    echo '<p class="text-center">No voter data found.</p>';
}

// Close card body and card
echo '</div>'; // card-body
echo '</div>'; // card
echo '</div>'; // col-md-8
echo '</div>'; // row
echo '</div>'; // container

require_once("inc/footer.php"); // Include the footer