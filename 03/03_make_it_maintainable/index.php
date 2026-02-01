<?php
/* What's the Problem? 
    - PHP logic + HTML in one file
    - Works, but not scalable
    - Repetition will become a problem

    How can we refactor this code so it’s easier to maintain?
*/


?>

<!DOCTYPE html>
<html>
    <head>
        <?php include 'header.php'; ?>
    </head>

    <body>
        <h1>Welcome</h1>
        <ul>
            <?php include 'list.php'; ?>
        </ul>

        <footer>
            <?php include 'footer.php'; ?>
        </footer>
    </body>
</html>
