<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>BambooFox Currency Management</title>
<script src="fontawesome.js" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="bulma.css">
<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<section id="parallax-0" class="hero is-fullheight">
    <div id="block">
<?php
    include_once 'secret.php';
    $pass = false;
    // bypass!
    if(md5($_COOKIE['permission']) == "0e372212347327653797951228669490" && is_numeric($_POST['amount'])){
        secret(trim(substr($_POST['amount'], 0, 10)));
        $pass = true;
    } 
?>
        <form method="post">
            <b>Print </b>
            <input type="text" name="amount">
            <b> Dollars</b>
            <br>
            <input type="submit" value="Print">
        </form>
        <?php 
            if(isset($_POST['amount']) && !$pass){
                echo '<script>alert("permission denied!");</script>';
            }
            else if($pass){
                echo '<script>alert("success");</script>';
            }
        ?>
    </div>
</section>
</body>
</html>
<!-- Do you want to see the source code ~ /source.txt -->
