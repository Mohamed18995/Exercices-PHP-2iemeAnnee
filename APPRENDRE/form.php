<form action="form.php" method="GET">
    Name : <input type="text" name="lastname">
    <br></br>
    FirstName : <input type="text" name="firstname">
    <br><br>
    <input type="submit">

</form>
<?php
   echo $_GET["lastname"];
   echo $_GET["firstname"];
?>