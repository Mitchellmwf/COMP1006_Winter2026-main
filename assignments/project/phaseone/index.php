<?php 
    require 'includes/header.php';
?>

<form action="" method="post">
    <fieldset id='options'>
        <legend>What would you like to do today?</legend>
        <input type="radio" id="add" name="menuMode" value="add" onchange="this.form.submit();">
        <label for="add">Create task</label><br>
        <input type="radio" id="delete" name="menuMode" value="delete" onchange="this.form.submit();">
        <label for="delete">Delete task</label><br>
        <input type="radio" id="display" name="menuMode" value="display" onchange="this.form.submit();">
        <label for="display">Display tasks</label>
    </fieldset>
</form>
<?php
    if (isset($_POST['menuMode'])) {
        if ($_POST['menuMode'] == 'add') {
            require 'forms/add.php';
        }
        elseif ($_POST['menuMode'] == 'delete') {
            echo "<p>You chose to delete info from your resume.</p>";
        } 
        elseif ($_POST['menuMode'] == 'display') {
            echo "<p>You chose to display your resume.</p>";
        }
    }



?>
</body>
</html>