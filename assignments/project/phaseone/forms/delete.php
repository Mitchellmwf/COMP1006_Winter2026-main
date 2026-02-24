<form>
    <legend>Would you like to delete by id or name?</legend>
    <input type="radio" id="id" name="deleteMode" value="id" onchange="this.form.submit();">
    <label for="id">Delete by id</label><br>
    <input type="radio" id="name" name="deleteMode" value="name" onchange="this.form.submit();">
    <label for="name">Delete by name</label><br>
</form>