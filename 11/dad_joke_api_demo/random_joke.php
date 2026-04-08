<?php
// ============================================
// Dad Joke API Demo - Random Joke Version
// Instructor File for COMP1006
// ============================================
// This page shows how to:
// 1. send a request to an external API
// 2. ask for JSON data using request headers
// 3. convert JSON into a PHP array
// 4. display the returned joke on the page

// Initialize the joke variable
$joke = "";
// Check if the form has been submitted
if (isset($_POST['get_joke'])) {
    // Use header options to specify that we want JSON data
    $options = [
        "http" => [
            "method" => "GET",
            "header" => "Accept: application/json\r\n". 
            "User-Agent: Dad Joke Demo\r\n"
        ]
    ];
    //Convert the options array into a stream context
    $context = stream_context_create($options);
    // Send a GET request to the API and get the response
    $response = file_get_contents("https://icanhazdadjoke.com/", false, $context);
    if ($response === false) {
        // Handle the error if the API request fails
        $joke = "Sorry, couldn't fetch a joke at this time.";
    } else {
        // Convert the JSON response into a PHP array
        $data = json_decode($response, true);
        // Extract the joke from the data array
        $joke = $data['joke'];
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dad Joke Generator</title>
</head>
<body>

    <h1>Dad Joke Generator</h1>
    <p>Click the button to load a random dad joke from an API.</p>

    <!--
        This form submits back to the same page.
        When the button is clicked, PHP sends a request to the API.
    -->
    <form method="post">
        <button type="submit" name="get_joke">Get a Joke</button>
    </form>

    <?php if ($joke != ""): ?>
        <!-- htmlspecialchars() protects the page by escaping special characters. -->
        <p><strong>Joke:</strong> <?php echo htmlspecialchars($joke); ?></p>
    <?php endif; ?>

</body>
</html>
