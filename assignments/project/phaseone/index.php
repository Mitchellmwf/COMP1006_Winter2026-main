
<?php 
    require "includes/header.php";
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

