<?php


    //Sanitize taskName input
    $taskName = filter_input(INPUT_POST, 'taskName', FILTER_SANITIZE_SPECIAL_CHARS);;
    $taskPriority = filter_input(INPUT_POST, 'taskPriority', FILTER_SANITIZE_SPECIAL_CHARS);
    $taskTime = filter_input(INPUT_POST, 'taskTime', FILTER_SANITIZE_NUMBER_INT);
    
    //validate taskPriority input
    if (!in_array($taskPriority, ['low', 'medium', 'high'])) {
        echo "<p>Invalid task priority. Please go back and select a valid priority.</p><p>You will be redirected to the homepage in 3 seconds.</p>
        <p>If you are not redirected, click <a href='../index.php'>here</a>.</p>";
        header("refresh:3;url=../index.php");
        exit;
    }
    //make sure taskName is not empty
    if (empty($taskName) || $taskName == '' || $taskName == null) {
        echo "<p>Task name cannot be empty. Please go back and enter a task name.</p><p>You will be redirected to the homepage in 3 seconds.</p>
        <p>If you are not redirected, click <a href='../index.php'>here</a>.</p>";
        header("refresh:3;url=../index.php");
        exit;
    }

    //make sure taskTime is a positive integer
    if ($taskTime <= 0) {
        echo "<p>Task time must be a positive integer. Please go back and enter a valid task time.</p>
        <p>You will be redirected to the homepage in 3 seconds.</p>
        <p>If you are not redirected, click <a href='../index.php'>here</a>.</p>";
        header("refresh:3;url=../index.php");
        exit;
    }

    /* INSERT THE ORDER USING A PREPARED STATEMENT*/
    //connect to database
    require "../includes/connect.php";

    //set up the query used named placeholders
    $sql = "INSERT INTO active_tasks(task_id, task_name, task_priority, task_time) VALUES (null, :taskName, :taskPriority, :taskTime);";
        //task_id will auto increment

    //prepare the query 
    $stmt = $pdo->prepare($sql); 

    //bind parameters
    $stmt->bindParam(':taskName', $taskName); 
    $stmt->bindParam(':taskPriority', $taskPriority); 
    $stmt->bindParam(':taskTime', $taskTime);
    
    //execute the query, matching the placeholder with the data entered by user
    $stmt->execute(); 

    //close connection 
    $pdo = null; 

    //confirmation message
    echo "<h1>Confirmed!</h1>
    <p>Your task has been added to the database.</p>";

    //redirect to index after 3 seconds
    header("refresh:3;url=../index.php");
    ?>
