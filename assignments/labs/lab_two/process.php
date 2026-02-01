<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lab 2 </title>
    <!-- <link href="styles/main.css" rel="stylesheet"> -->
</head>

<body>
    <header>
        <h1>Bake It Til You Make It Bakery</h1>
    </header>
<main>
<?php 
    $firstname = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $lastname = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

    $errors = [];

    if ($firstname === null || $firstname === "") {
        $errors[] = "First name is required.";
    }
    if ($lastname === null || $lastname === "") {
        $errors[] = "Last name is required.";
    }
    if ($message === null || $message === "") {
        $errors[] = "A Message is required.";
    }
    if ($email === null || $email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "A valid email address is required.";
    }

    if (count($errors) > 0) {
        echo "<h2>There were some problems with your entries:</h2>";
        echo "<ul>";
    }
    foreach ($errors as $error) {
        echo "<li style='color: red;'>" . $error . "</li>";
    }
    if (count($errors) > 0) {
        echo "</ul>";
        echo "<p><a href='index.php'>Click here to go back</a></p>";
        exit;   
    }

    echo "<h2>Thank you, " . $firstname . " " . $lastname . ", for reaching out to us!</h2>";
    echo "<p>If you don't hear back from us at " . $email . " within 2-3 business days, please feel free to contact us again.</p>";
    echo "<p>A copy has been sent your email for your records.</p>";
    
    date_default_timezone_set('America/Toronto');
    $submissionDetails = "
    Time of Submission: " . date('l jS \of F Y h:i:s A') . "
    Name: " . $firstname . " " . $lastname . "
    Email: " . $email . "
    Message: " . $message;

    echo "<pre>" . $submissionDetails . "</pre>";

    //mail($email, "New Contact Form Submission", $submissionDetails);