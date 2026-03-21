

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lab 5</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="./styles/main.css" rel="stylesheet">
</head>
<body>
    <h1>Upload File</h1>
    <form method="post" enctype="multipart/form-data" class="mt-3">
        <label for="image">Choose a file to upload:</label>
        <input type="file" name="image" class="form-control mb-4" required>
        <input type="submit" value="Upload" class="btn btn-primary">
    </form>
</body>

<?php
    //This code is a copy of index.php but instead of storing the uploaded image in the uploads directory, 
    // it stores the image as a blob in the database and then displays all images store in it. 






    $errors = [];
     // Check if an image was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE ){
        //make sure upload complete successfully
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK ){
            $errors[] = 'Error uploading image.';
        }
        else {
            //Array to hold allowed file types
            $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
            //detect the file type of the uploaded image
            $detectedType = mime_content_type($_FILES['image']['tmp_name']);
            // check if the detected file type is in the allowed types array
            if (!in_array($detectedType, $allowedTypes, true)) {
                $errors[] = 'Invalid image type. Allowed types: JP(E)G, PNG, WEBP.';
            }
            // Limit file size to 20MB
            elseif ($_FILES['image']['size'] > 20 * 1024 * 1024) {
                $errors[] = 'Image size exceeds 20MB limit.';
            }
            else {
                // If the file is valid, read its contents and prepare it for database storage
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imageData = file_get_contents($_FILES['image']['tmp_name']);
                $safeFilename = uniqid('image_', true) . '.' . strtolower($extension);
                // Connect to the database
                $pdo = new PDO('mysql:host=localhost;dbname=Mitchell200636138', 'Mitchell200636138', 'PdnkSpwQdZ');
                // Prepare and execute the insert statement
                $stmt = $pdo->prepare('INSERT INTO uploads (image_name, image_bin, mime_type) VALUES (:name, :data, :mime_type)');
                $stmt->bindValue(':name', $safeFilename, PDO::PARAM_STR);
                $stmt->bindValue(':data', $imageData, PDO::PARAM_LOB);
                $stmt->bindValue(':mime_type', $extension, PDO::PARAM_STR);
                if ($stmt->execute()) {
                    $imagePath = 'Image stored in database successfully.';
                } else {
                    $errors[] = 'Failed to store image in database.';
                }
                // Close the database connection
                $pdo = null;
            }
        }
    }


    // Display errors if there are any
    if (!empty($errors)):
        echo '</br><div class="alert alert-danger"><h3>Please fix the following:</h3><ul class="mb-0">';
        foreach ($errors as $error) {
            echo '<li>' . htmlspecialchars($error) . '</li>';
        }
        echo '</ul></div>';
    elseif (isset($imagePath)): 
        echo '</br><div class="alert alert-success"><h3>Image uploaded successfully!</h3><p>' . htmlspecialchars($imagePath) . '</p></div>';
    endif;


    // Display all uploaded images store as blob in MySQL database https://stackoverflow.com/questions/2070603/php-recreate-and-display-an-image-from-binary-data
    // Connect to the database
    $pdo = new PDO('mysql:host=localhost;dbname=Mitchell200636138', 'Mitchell200636138', 'PdnkSpwQdZ');
    // Fetch all images from the database
    $stmt = $pdo->query('SELECT image_name, image_bin, mime_type FROM uploads');
    $images = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Display the images
    if (!empty($images)):
        echo '<h2 class="mt-5">Uploaded Images</h2><div class="row">';
        foreach ($images as $image) {
            $base64 = base64_encode($image['image_bin']);
            $src = 'data:image/'. $image["mime_type"] . ';base64,' . $base64;
            echo '<div style="max-width: fit-content; max-height: fit-content; margin: 10px; justify-content: center;">';
            echo '<img src="' . $src . '">';
            echo '</div>';

        }
        echo '</div>';
    endif;
    $pdo = null; // Close the database connection




?>

