<?php
require "includes/connect.php";
require "includes/header.php";

$error = "";

//if the user is already logged in, redirect them to the controls page
if (isset($_SESSION['username'])) {
    header("Location: ./controls.php");
    exit;
}

// Check if the form was submitted using POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // reCAPTCHA validation
    $recaptchaSecret = '6Lc52q0sAAAAAIrTXwjPcZt5lB3pMOzabNOdPIdV';
    $recaptchaToken = $_POST['g-recaptcha-response'] ?? '';
    
    $recaptchaResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptchaSecret}&response={$recaptchaToken}");
    $recaptchaData = json_decode($recaptchaResponse, true);

    if (!$recaptchaData['success'] || $recaptchaData['score'] < 0.5) {
        $errors[] = "reCAPTCHA verification failed. Please try again.";
    }

    $usernameOrEmail = trim($_POST['username_or_email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($usernameOrEmail === '' || $password === '') {
        $error = "Username/email and password are required.";
    } else {
        $sql = "SELECT user_id, username, email, password, profile_image
                FROM task_users
                WHERE username = :login OR email = :login
                LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':login', $usernameOrEmail);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            session_regenerate_id(true);

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['profile_image_path'] = $user['profile_image'] ?? './profiles/default.jpg';

            header("Location: ./controls.php");
            exit;
        } else {
            $error = "Invalid credentials. Please try again.";
        }
    }
}
?>

<main class="container mt-4">
    <h2>Login</h2>

    <?php if ($error !== ""): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="post" class="mt-3" id="login-form">
        <label for="username_or_email" class="form-label">Username or Email</label>
        <input
            type="text"
            id="username_or_email"
            name="username_or_email"
            class="form-control mb-3"
            required
        >

        <label for="password" class="form-label">Password</label>
        <input
            type="password"
            id="password"
            name="password"
            class="form-control mb-4"
            required
        >

       <button class="g-recaptcha btn btn-primary"
            data-sitekey="6Lc52q0sAAAAAAWnq8PbAmWmXuA2LZ4Ma9fhJ8Bx"
            data-callback="onSubmit"
            data-action="submit">Login
        </button>
        <a href="./register.php" class="btn btn-secondary">Create Account</a>
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <script>
            function onSubmit(token) {
                document.getElementById("login-form").submit();
            }
        </script>
    </form>
</main>
