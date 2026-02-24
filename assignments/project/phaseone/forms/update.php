
<?php 
    require '../includes/header.php';

    //Grab and ensure task_id is valid
    $taskId = $_GET['task_id'];
    if (empty($taskId) || $taskId < 0) {
        echo "<p>Invalid task ID. Please go back and try again.</p><p>You will be redirected to the homepage in 3 seconds.</p>
        <p>If you are not redirected, click <a href='../index.php'>here</a>.</p>";
        header("refresh:3;url=../index.php");
        exit;
    }

    //connect to database
    require "../includes/connect.php";

    //get the task info using a prepared statement
    $sql = "SELECT * FROM active_tasks WHERE task_id = :taskId LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':taskId', $taskId);
    $stmt->execute();
    $tasks = $stmt->fetch();
    $pdo = null;

  ?>
  <!-- Display the update form, pre-filled with current task data -->
  <h1>Update Task #<?= htmlspecialchars($tasks['task_id']); ?></h1>
<form action='processUpdate.php?task_id=<?= urlencode($tasks['task_id']); ?>' method='post'>
    <fieldset>
        <legend>Task details</legend>
        <label for='taskName'>Task name</label>
        <input type='text' id='taskName' name='taskName' class='form-control' value='<?= htmlspecialchars($tasks['task_name']); ?>' required>
        <label for='taskPriority'>select Task priority (low, medium, high)</label>
        <select id='taskPriority' name='taskPriority' class='form-select' required>
            <!-- ?if and :else statements to set selected option based on current task priority -->
             <!-- < ?= Condition ? do_if_true : do_if_false ; ?> -->
            <option value='low' <?= $tasks['task_priority'] == 'low' ? 'selected' : ''; ?>>Low</option>
            <option value='medium' <?= $tasks['task_priority'] == 'medium' ? 'selected' : ''; ?>>Medium</option>
            <option value='high' <?= $tasks['task_priority'] == 'high' ? 'selected' : ''; ?>>High</option>
        </select>
        <label for='taskTIme'>Time spent on task (in minutes)</label>
        <input type='number' id='taskTime' name='taskTime' class='form-control' value='<?= htmlspecialchars($tasks['task_time']); ?>' required min='1'>
    </fieldset>
    <button type='submit' class='btn btn-primary'>Update Info</button>
    <a href="../index.php" class='btn'>Back to homepage</button>
    <a href="processDelete.php?task_id=<?= urlencode($tasks['task_id']); ?>" class='btn btn-danger' onclick="return confirm('Are you sure you want to delete this order?');">Delete Task</button>
</form>
</body>
</html>
