<?php 
    //connect to database
    require "./includes/connect.php";

    // Get all orders (newest first)
    $sql = "SELECT * FROM active_tasks ORDER BY task_priority DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $tasks = $stmt->fetchAll();

    //close connection
    $pdo = null;
?>

<h2>Orders (Admin)</h2>

<?php if (empty($tasks)){
    echo "<p>No Tasks yet.</p>";} ?>

<div class="table-responsive">
    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
            <th>Task #</th>
            <th>Task</th>
            <th>Task priority</th>
            <th>Time spent on task</th>

            <th>Created</th>
            <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($tasks as $task): ?>
                <tr>
                <td><?= htmlspecialchars($task['task_id']); ?></td>
                <td><?= htmlspecialchars($task['task_name']); ?></td>
                <td><?= htmlspecialchars($task['task_priority']); ?></td>
                <td><?= htmlspecialchars($task['task_time']); ?></td>
                <td><?= htmlspecialchars($task['task_date']); ?></td>
                <td>
                    <a
                    class="btn btn-sm btn-warning"
                    href="update.php?id=<?= urlencode($task['task_id']); ?>">
                    Update
                    </a>
            </br>
                    <a
                    class="btn btn-sm btn-danger mt-2"
                    href="forms/delete.php?task_id=<?= urlencode($task['task_id']); ?>"
                    onclick="return confirm('Are you sure you want to delete this order?');">
                    Delete
                    </a>
                </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>