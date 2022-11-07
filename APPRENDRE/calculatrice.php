<?php
  $number1 = $_GET["number1"];
  $number2 = $_GET["number2"];
  $op = $_GET["op"];

//   if(!empty($number1) && !empty($number2) && !empty($number3) && !empty($number4) ){
//     if($choix === "+"){
//         $result1 = $_GET["number1"] + $_GET["number2"];
//       }elseif($choix === "-"){
//         $result2 = $_GET["number1"] - $_GET["number2"];
//       }
//       elseif($choix === "/"){
//         $result3 = $_GET["number1"] / $_GET["number2"];
//       }elseif($choix === "*"){
//         $result4 = $_GET["number1"] * $_GET["number2"];
//     }
//   }

  if(empty($number1)){
     $result = "premier nomber est vide";
  }elseif(empty($number2)){
    $result = "Deuxiem nomber est vide";
 }elseif(empty($op)){
     $result = "Veuillez entrer votre choix";
 }else{
    if($op === "+"){
        $result = $_GET["number1"] + $_GET["number2"];
    }elseif($op === "-"){
        $result = $_GET["number1"] - $_GET["number2"];
    }elseif($op === "/"){
        $result = $_GET["number1"] / $_GET["number2"];
    }elseif($op === "*"){
        $result = $_GET["number1"] * $_GET["number2"];
    }
 }

  ?>
<head>
    <link rel="stylesheet" href="bootstrap.min.css">
</head>
<body>
    <div class="container">
        <form action="calculatrice.php" method="GET" class="form">
            <div>
                <label>Enter Number1 : </label>
                <input type="text" name="number1" class="form-control">
            </div>
            <div>
                <label>Enter Number2 : </label>
                <input type="text" name="number2" class="form-control">
            </div>
            <br>
            <div>
                <label>choix : </label>
                <input type="text" name="op" class="form-control">
            </div>
            <div class="result">
                <?php echo $result ?>
            </div>
            <br>
            <input type="submit" class="btn btn-primary">
        </form>
    </div>


</body>