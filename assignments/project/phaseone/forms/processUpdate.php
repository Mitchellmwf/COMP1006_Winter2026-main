<?php   
    //Grab and ensure task_id is valid
    $taskId = $_GET['task_id'];
    if (empty($taskId) || $taskId <= 0) {
        echo "<p>Invalid task ID. Please go back and try again.</p><p>You will be redirected to the homepage in 3 seconds.</p>
        <p>If you are not redirected, click <a href='../index.php'>here</a>.</p>";
        header("refresh:3;url=../index.php");
        exit;
    }

    //connect to database
    require "../includes/connect.php";
    //update the task using a prepared statement
    $sql = "UPDATE active_tasks SET task_name = :taskName, task_priority = :taskPriority, task_time = :taskTime WHERE task_id = :taskId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':taskName', $_POST['taskName']);
    $stmt->bindParam(':taskPriority', $_POST['taskPriority']);
    if ($_POST['taskTime'] <= 0) {
        echo "<p>Task time must be a positive integer. Please go back and enter a valid task time.</p>
        <p>You will be redirected to the homepage in 3 seconds.</p>
        <p>If you are not redirected, click <a href='../index.php'>here</a>.</p>";
        header("refresh:3;url=../index.php");
        exit;
    }
    $stmt->bindParam(':taskTime', $_POST['taskTime']);
    $stmt->bindParam(':taskId', $taskId);
    $stmt->execute();
    $pdo = null;

    //confirmation message
    echo "<h1>Updated!</h1>
    <p>The task has been updated in the database.</p>";
    echo "<p>You will be redirected to the homepage in 3 seconds.</p>
    <p>If you are not redirected, click <a href='../index.php'>here</a>.</p>";
    //redirect to index after 3 seconds
    header("refresh:3;url=../index.php");
    ?>