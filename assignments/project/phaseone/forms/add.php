<form action='forms/processAdd.php' method='post'>

    <label for='taskName'>Task name</label>
    <input type='text' id='taskName' name='taskName' class='form-control'>
    <label for='taskPriority'>select Task priority (low, medium, high)</label>
    <select id='taskPriority' name='taskPriority' class='form-select'>
        <option value='low'>Low</option>
        <option value='medium'>Medium</option>
        <option value='high'>High</option>
    </select>
    <label for='taskTIme'>Time spent on task (in minutes)</label>
    <input type='number' id='taskTime' name='taskTime' class='form-control'>

    <button type="submit" class="btn btn-primary">Update Info</button>
</form>

<?php


?>