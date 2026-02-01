<?php
require "includes/header.php";

echo "<div style='align-content: center; width 80%; margin: 0px 10% 0px 10%;'>";


// $firstname = $_POST['first_name'];
// $lastname = $_POST['last_name'];
// $phone = $_POST['phone'];
// $address = $_POST['address'];
// $email = $_POST['email'];


//Sanitize the data and validate (Proper email format, phone number format, order amount.) before using in a production environment.
$firstname = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_SPECIAL_CHARS);
$lastname = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_SPECIAL_CHARS);
$phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_SPECIAL_CHARS);
$address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

$items = $_POST['items'];

$errors = [];

if ($firstname === null || $firstname === "") {
    $errors[] = "First name is required.";
}
if ($lastname === null || $lastname === "") {
    $errors[] = "Last name is required.";
}
if ($phone === null || $phone === "") {
    $errors[] = "Phone number is required.";
}
if ($address === null || $address === "") {
    $errors[] = "Address is required.";
}
if ($email === null || $email === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "A valid email address is required.";
}

$itemsOrdered = [];
foreach ($items as $item => $quantity) {
    if (filter_var($quantity, FILTER_VALIDATE_INT) !== false &&  $quantity > 0) {
        $itemsOrdered[$item] = $quantity;
    }
    else if (filter_var($quantity, FILTER_VALIDATE_INT) === false || $quantity < 0) {
        $errors[] = "Invalid quantity for " . $item . ". Please enter a non-negative integer.";
    }
}

if(count($itemsOrdered) === 0){
    $errors[] = "You must order at least one item.";
}


if (count($errors) > 0) {
    echo "<h2>There were errors with your submission:</h2>";
    echo "<ul>";
}
foreach ($errors as $error) {
    echo "<li style='color: red;'>" . $error . "</li>";
}
if (count($errors) > 0) {
    echo "</ul>";
    echo "<p><a href='index.php'>Go back to the order form</a></p>";
    exit;
}


// if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
//     $email = $_POST['email'];
// }
// else{
//     echo "This email address is considered invalid.";
//     $email = "NULL";
// }






echo "<h2>Customer Information:</h2>";
echo "<p>First Name: " . $firstname . "</p>";
echo "<p>Last Name: " . $lastname . "</p>";
echo "<p>Phone Number: " . $phone . "</p>";
echo "<p>Address: " . $address . "</p>";
echo "<p>Email: " . $email . "</p>";



echo "<H2>Thank you for your order!</H2>";
echo "<br>";
echo "</div>";

echo "<main>";
echo "<ul><h2>Items Ordered:</h4>";
    foreach ($_POST['items'] as $item => $quantity) {
        if ($quantity > 0) {
            echo "<li>" . $item . ": " . $quantity . "</li>";
        }
    }
echo "</main></ul>";

require "includes/footer.php";
