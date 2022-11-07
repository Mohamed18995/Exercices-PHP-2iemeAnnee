<?php
$result = $_GET["number1"] + $_GET["number2"];
?>

<body>
    <div class="container">
        <form action="clac.php" method="GET" class="form">
            <div>
                <label>Enter Number1 : </label>
                <input type="text" name="number1" class="form-control">
            </div>
            <div>
                <label>Enter Number2 : </label>
                <input type="text" name="number2" class="form-control">
            </div>
            <br>
            <div class="result">
                <?php echo $result ?>
            </div>
            <br>
            <input type="submit" class="btn btn-primary">
        </form>
    </div>


</body>