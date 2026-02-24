<form action='forms/processUpdate.php' method='post'>
    <legend>Update Task</legend>

<?php 
    //get task id from url



    echo"
    <label for='taskName'>Task name</label>
    <input type='text' id='taskName' name='taskName' class='form-control' default='$taskName'>
    <label for='taskPriority'>select Task priority (low, medium, high)</label>
    <select id='taskPriority' name='taskPriority' class='form-select' default='$taskPriority'>
        <option value='low'>Low</option>
        <option value='medium'>Medium</option>
        <option value='high'>High</option>
    </select>
    <label for='taskTIme'>Time spent on task (in minutes)</label>
    <input type='number' id='taskTime' name='taskTime' class='form-control' default='$taskTime'>

    <button type='submit' class='btn btn-primary'>Update Info</button>";

?> 
</form>