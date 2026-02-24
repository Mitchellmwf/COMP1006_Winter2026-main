<form action='forms/processAdd.php' method='post'>
    <legend>Create Task</legend>
    <label for='taskName'>Task name</label>
    <input type='text' id='taskName' name='taskName' class='form-control' require value='test1'>
    <label for='taskPriority'>select Task priority (low, medium, high)</label>
    <select id='taskPriority' name='taskPriority' class='form-select' require>
        <option value='high'>High</option>
        <option value='medium'>Medium</option>
        <option selected value='low'>Low</option>
    </select>
    <label for='taskTIme'>Time spent on task (in minutes)</label>
    <input type='number' id='taskTime' name='taskTime' class='form-control' require value='30' min='1'>

    <button type="submit" class="btn btn-primary">Update Info</button>
</form>

<?php


?>