

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


<?php
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
                // Build the file name and move it to the uploads directory
                // get the file extension
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                // create a unique file name so uploaded files don't overwrite each other
                $safeFilename = uniqid('image_', true) . '.' . strtolower($extension);
                //Build the full server path where the file will be stored
                $destination = __DIR__ . '/uploads/' . $safeFilename;
                //Check if the file uploaded successfully and move it to the destination
                if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                    // Save the relative path to the image for storing in the database
                    $imagePath = 'image stored in uploads directory successfully.';
                } else {
                    $errors[] = 'Failed to move uploaded image.';
                }
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
        echo '</br><div class="alert alert-success"><h3>Image uploaded successfully!</h3></div>';
    endif;


    // Display all uploaded images https://www.tutorialspoint.com/article/get-all-the-images-from-a-folder-in-php
    $uploads = glob(__DIR__ . '/uploads/*.{jpg,jpeg,png,webp}', GLOB_BRACE);
    if (!empty($uploads)) {
        echo '<h2 class="mt-5">Uploaded Images:</h2><div class="row">';
        foreach ($uploads as $image) {
            $relativePath = 'uploads/' . basename($image);
            echo '<div style="max-width: 30vw; max-height: 40vh; margin: 10px; justify-content: center;">';
            echo '<img src="' . htmlspecialchars($relativePath) . '">';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<p>No images uploaded yet.</p>';
    }




?>

