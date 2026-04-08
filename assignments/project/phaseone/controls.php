<?php 
    require 'includes/header.php';
?>

<form action="" method="post">
    <legend>What would you like to do today?</legend>
    <fieldset id='options'>
        <input type="radio" id="add" name="menuMode" value="add" onchange="this.form.submit();" >
        <label for="add">Create task</label><br>   
        <input type="radio" id="display" name="menuMode" value="display" onchange="this.form.submit();">
        <label for="display">Display tasks</label>
    </fieldset>
</form>

<?php
//If a value is selected, attach the corresponding form to the page
    if (isset($_POST['menuMode'])) {
        if ($_POST['menuMode'] == 'add') {
            require 'forms/add.php';
        }
        elseif ($_POST['menuMode'] == 'display') {
            require 'forms/display.php';
        }
    }



?>
</body>
</html>