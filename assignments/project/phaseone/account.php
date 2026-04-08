<?php 
    require "./includes/auth.php";
    require './includes/header.php';

    // Show success message at top of if successful
    if (isset($_GET['success'])) {
        echo "<div class='alert alert-success'>Account information updated successfully!</div>";
        
    }

?>
<form method="post" enctype="multipart/form-data">
    <legend>Account Settings</legend>
    <label for="profileImage" class="form-label">Profile Image</label>
    <input type="file" id="profileImage" name="profileImage" class="form-control mb-3" accept="image/*">
    <label for="username" class="form-label">Username</label>
    <input type="text" id="username" name="username" class="form-control mb-3" value="<?= htmlspecialchars($_SESSION['username'] ?? ''); ?>" required>
    <label for="email" class="form-label">Email</label>
    <input type="email" id="email" name="email" class="form-control mb-4" value="<?= htmlspecialchars($_SESSION['email'] ?? ''); ?>" required>
    <label for="password" class="form-label mt-4">New Password</label>
    <input type="password" id="password" name="password" class="form-control mb-3" placeholder="Leave blank to keep current password">
    <label for="confirm_password" class="form-label">Confirm New Password</label>
    <input type="password" id="confirm_password" name="confirm_password" class="form-control mb-4">
    <button type="submit" class="btn btn-primary">Update Info</button>
    <a href="./controls.php" class="btn btn-secondary">Back to homepage</a>
    <a href="./logout.php?delete=True" id="delete" class="btn btn-danger ms-2" >Delete Account</a>
    <script>
        // Add a confirmation dialog before deleting the account
        document.querySelector('a#delete').addEventListener('click', function(event) {
            if (!confirm('Are you sure you want to delete your account? This action cannot be undone.')) {
                event.preventDefault();
            }
        });
    </script>
</form>

<?php
    $imagePath = null;
    $errors = [];

    // Check if the form was submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Process the form submission
        require "./includes/connect.php";
        // Retrieve and sanitize the username from the form
        // filter_input helps clean user input
        $username = trim(filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS));

        // Retrieve and sanitize the email address
        $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));

        // Retrieve password fields (no sanitizing because passwords may contain special characters)
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // -----------------------------
        // Server-side Validation
        // -----------------------------

        // Check that a username was entered
        if ($username === '') {
            $errors[] = "Username is required.";
        }

        // Check that an email was entered
        if ($email === '') {
            $errors[] = "Email is required.";
        }
        // Validate the email format
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Email must be a valid email address.";
        }

        // Check that both passwords match if a new password was entered
        if ($password !== '' && $password !== $confirmPassword) {
            $errors[] = "Passwords do not match.";
        }

        // Password min length
        if ($password !== '' && strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters long.";
        }

        // Only check the database if there are no validation errors so far
        if (empty($errors) && ($username !== $_SESSION['username'] || $email !== $_SESSION['email'])) {

            // SQL query to check for existing username or email
            $sql = "SELECT user_id FROM task_users WHERE username = :username OR email = :email";

            // Prepare the SQL statement using PDO
            $stmt = $pdo->prepare($sql);

            // Bind user inputs to the query parameters
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);

            // Execute the query
            $stmt->execute();

            // If a record is returned, the username or email is already in use
            if ($stmt->fetch()) {
                $errors[] = "That username or email is already in use.";
            }
        }
        // Check if a profile image was uploaded
        if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] !== UPLOAD_ERR_NO_FILE ){
            //make sure upload complete successfully
            if ($_FILES['profileImage']['error'] !== UPLOAD_ERR_OK ){
                $errors[] = 'Error uploading image.';
            }
            else {
                //Array to hold allowed file types
                $allowedTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
                //detect the file type of the uploaded image
                $detectedType = mime_content_type($_FILES['profileImage']['tmp_name']);
                // check if the detected file type is in the allowed types array
                if (!in_array($detectedType, $allowedTypes, true)) {
                    $errors[] = 'Invalid image type. Allowed types: JP(E)G, PNG, WEBP.';
                }
                // Limit file size to 20MB
                elseif ($_FILES['profileImage']['size'] > 5 * 1024 * 1024) {
                    $errors[] = 'Image size exceeds 5MB limit.';
                }
                else {
                    // Build the file name and move it to the uploads directory
                    // get the file extension
                    $extension = pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);
                    // create a unique file name so uploaded files don't overwrite each other
                    $safeFilename = uniqid('image_', true) . '.' . strtolower($extension);
                    //Build the full server path where the file will be stored
                    $destination = __DIR__ . '/profiles/' . $safeFilename;
                    //Check if the file uploaded successfully and move it to the destination
                    if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $destination)) {
                        // Save the relative path to the image for storing in the database
                        $imagePath = './profiles/' . $safeFilename;
                    } else {
                        $errors[] = 'Failed to move uploaded image.';
                    }
                }
            }
        }

        // If there are no validation errors, update the account
        if (empty($errors)) {
            // Build the SQL query 
            $sql = "UPDATE task_users SET username = :username, email = :email";

            // Only update the password if a new one was entered
            if ($password !== '') {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $sql .= ", password = :password";
            }
            // Only update the profile image if a new one was uploaded
            if (isset($imagePath)) {
                $sql .= ", profile_image = :profile_image";
            }
            // Update current user only
            $sql .= " WHERE user_id = :user_id";

            // Prepare the SQL statement
            $stmt = $pdo->prepare($sql);

            // Bind the basics
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':user_id', $_SESSION['user_id']);
            // Bind the password parameter if a new password was entered
            if ($password !== '') {
                $stmt->bindParam(':password', $hashedPassword);
            }
            // Bind if a new image was uploaded
            if (isset($imagePath)) {
                $stmt->bindParam(':profile_image', $imagePath);
            }

            // Execute the update query
            $stmt->execute();

            // Update session variables with the new account information
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            if (isset($imagePath)) {
                $_SESSION['profile_image_path'] = $imagePath;
            }
            

            header("Location: ./account.php?success=1");
            exit;
        }
        else {
            // Display errors
            echo "<div class='alert alert-danger' style='margin-top: 1em;'><ul>";
            foreach ($errors as $error) {
                echo "<li>" . htmlspecialchars($error) . "</li>";
            }
            echo "</ul></div>";
        }

    }