<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Time Tracker </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <link href="styles/main.css" rel="stylesheet">
</head>

<body style="margin: 20px;">
    <header style="margin-bottom: 20px; display: flex; flex-direction: row; border-bottom: 2px solid #999; padding-bottom: 10px;">
        <h1>Time tracker pro</h1> 
        <?php if (isset($_SESSION['user_id'])): ?>
            <div style="margin-left: auto; display: flex; align-items: center;">
                <span class="me-3">Welcome, <?= htmlspecialchars($_SESSION['username']); ?>!</span>
                <a href="controls.php" class="btn btn-info me-2" style="width: 5em; height: 2.6em;">Admin</a>
                <a href="logout.php" class="btn btn-danger" style="width: 5em; height: 2.6em;">Log out</a>
            </div>
        <?php else: ?>
            <div style="margin-left: auto;">
                <a href="login.php" class="btn btn-primary" style="width: 5em; height: 2.6em;">Login</a>
                <a href="register.php" class="btn btn-secondary ms-2" style="width: 5em; height: 2.6em;">Register</a>
            </div>
        <?php endif; ?>
    </header>
<?php 
    //connect to database
    require "./includes/connect.php";

    // Get all orders (newest first)
    $sql = "SELECT * FROM active_tasks ORDER BY FIELD(task_priority, 'high', 'medium', 'low'), task_date DESC, task_time asc";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $tasks = $stmt->fetchAll();

    //close connection
    $pdo = null;
?>

<?php if (empty($tasks)){
    echo "<p>No Tasks yet.</p>";} 
    exit
    ?>

<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
            <th>Task</th>
            <th>Task priority</th>
            <th>Time spent on task</th>

            <th>Created</th>
            </tr>
        </thead>

        <tbody>
            <!-- Loop through orders and show in table -->
            <?php foreach ($tasks as $task): ?>
                <tr>
                <td><?= htmlspecialchars($task['task_name']); ?></td>
                <td><?= htmlspecialchars($task['task_priority']); ?></td>
                <td><?= htmlspecialchars($task['task_time']); ?></td>
                <td><?= htmlspecialchars($task['task_date']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

