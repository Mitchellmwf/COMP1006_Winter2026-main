<!DOCTYPE html>
<html lang="en">
<?php
    if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Tracker </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link href="./styles/main.css" rel="stylesheet">
</head>

<body style="margin: 20px;">
    <header style="margin-bottom: 20px; display: flex; flex-direction: row; border-bottom: 2px solid #999; padding-bottom: 10px;">
        <h1><a href="./index.php" style="color: black;">Time Tracker Pro</a></h1> 
        <?php if (isset($_SESSION['username'])): ?>
            <div style="margin-left: auto; display: flex; align-items: center;">
                <a href="./account.php" ><img src="<?= htmlspecialchars($_SESSION['profile_image_path'] ?? './profiles/default.jpg'); ?>" alt="Profile Settings" style="width: 40px; height: 40px; margin-right: 10px;"></a>
                <a href="./controls.php" class="btn btn-info me-2" style="width: 5em; height: 2.6em;">Admin</a>
                <a href="./logout.php" class="btn btn-danger" style="width: 6em; height: 2.6em;">Log out</a>
            </div>
        <?php else: ?>
            <div style="margin-left: auto;">
                <a href="./login.php" class="btn btn-primary" style="width: 5em; height: 2.6em;">Login</a>
                <a href="./register.php" class="btn btn-secondary ms-2" style="width: 5em; height: 2.6em;">Register</a>
            </div>
        <?php endif; ?>
    </header>
