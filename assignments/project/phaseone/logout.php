<?php
// logout.php
// ------------------------------------------------------------
// This page logs the user out by destroying their session
// and then redirects them back to the login page.

// Load the auth file so the session starts
require "./includes/auth.php";
//connect to db
require "./includes/connect.php";

//check if delete is set to true in the url, if so delete the account
if (isset($_GET['delete']) && $_GET['delete'] === 'True') {
    $sql = "DELETE FROM task_users WHERE user_id = :user_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
}



// Clear all session variables by replacing the session array with an empty one
$_SESSION = [];

// Unset all session variables currently stored in memory
session_unset();

// Destroy the session completely on the server
session_destroy();

// Redirect the user back to the login page
header("Location: ./index.php");

// Stop the script from executing any further code
exit;