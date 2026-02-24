<?php 
    require '../includes/header.php';
    $taskId = $_GET['task_id'];
    if (empty($taskId) || $taskId <= 0) {
        echo "<p>Invalid task ID. Please go back and try again.</p><p>You will be redirected to the homepage in 3 seconds.</p>
        <p>If you are not redirected, click <a href='../index.php'>here</a>.</p>";
        header("refresh:3;url=../index.php");
        exit;
    }

    //connect to database
    require "../includes/connect.php";

    //delete the task using a prepared statement
    $sql = "DELETE FROM active_tasks WHERE task_id = :taskId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':taskId', $taskId);
    $stmt->execute();
    //close connection
    $pdo = null;
    
    //confirmation message
    echo "<h1>Deleted!</h1>
    <p>The task has been deleted from the database.</p>";
    //redirect to index after 3 seconds
    header("refresh:3;url=../index.php");
