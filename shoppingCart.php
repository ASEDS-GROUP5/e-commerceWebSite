<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Basket</title>
</head>
<style>
    a {
        color: black;
    }
    
    a#logo:link,
    a#logo:visited {
        background-color: rgb(14, 12, 12);
        color: aliceblue;
        width: 20%;
        padding: 10px;
        margin-top: 10px;
        margin-left: 50px;
        font-size: 19px;
        text-decoration: none;
        border-radius: 5px 5px 5px 5px;
    }
    
    a#logo:hover,
    a#logo:active {
        color: rgb(10, 9, 9);
        background-color: snow;
        transition: 0.5s;
    }
    
    a#nav:hover,
    a#nav:active {
        color: lightgrey;
        transition: 0.3s;
    }
    
    a#nav {
        text-decoration: none;
    }
    
    input#q {
        width: 40px;
    }
    
    img#P {
        width: 50px;
        height: 50px;
        border-radius: 5px 5px 5px 5px;
    }
    
    table#t td {
        border: 0px;
    }
    
    table#t {
        border-radius: 5px 5px 5px 5px;
    }
    
    li {
        overflow: hidden;
    }
</style>

<body background="img/signUp-background.jpeg">
    <header class="navbar" style="background-color:rgb(172, 13, 13);text-align:center;">
        <a id="logo" class="col-sm-3" href="" alt="Home"><span class="glyphicon glyphicon-leaf"></span><b> E-SHOP</b></a>
        <nav class="col-sm-4" style="color:rgb(7, 7, 6);padding: 20px;font-size:large;">
            <div class="navbar-header" style="color: mintcream;">
                <a id="nav" href=" ">Home</a> |
                <a id="nav" href=" ">Shop</a> |
                <a id="nav" href=" ">Contact us</a> |
                <a id="nav" href=" ">Help</a>
            </div>
        </nav>
        <div class="col-sm-5" style="padding: 19px;font-size: 20px;">
            <div class="col-sm-4">
                <p style="color: rgb(243, 242, 242);margin-left: 0px;">✔️Connected</p>
            </div>
            <div class="col-sm-4">
                <a id="nav" href="logout.php?deconnexion=true"> <span class="glyphicon glyphicon-log-out"></span><b>Log out</b></a>
            </div>
            <div class="col-sm-4">
                <a id="nav" href=""> <span class="glyphicon glyphicon-shopping-cart"></span><b>Basket</b></a>
            </div>
        </div>
    </header>
    <div class="container">
        <h1 style="text-align: left;margin-left: 20px;color: snow;"><b> Basket </b></h1>
        <hr>
        <br>
        <table id="t" class="table">
            <thead style="background-color: #ff523b;color: snow;border: snow 2px solid;border-radius: 5px 5px 5px 5px;">
                <tr>
                    <th>Remove</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody style="background-color: rgba(255, 250, 250, 0.562);border: snow 2px solid;border-radius: 5px 5px 5px 5px;">
                <?php
                include 'database.php';
                global $db;
                try{
                    $q=$db->prepare("SELECT panier_id,photo,product_name,price FROM panier;");
                    $q->execute();
                    foreach($q as $row){
                        $photo=$row['photo'];
                        $pname=$row['product_name'];
                        $price=$row['price'];
                        $id=$row['panier_id'];
                        echo "
                            <tr>
                                <td><form method='POST' action='remove.php?idbutton=".$id."' ><button id=".$id." type='submit' name='remove' class='btn btn-danger' >
                                <span class='glyphicon glyphicon-remove'></span></button></form>
                                </td>
                                <td><img id='P' src='img/icons/".$photo."' alt=''> ".$pname."</td>
                                <td><form ><input type='number' id='q' name='quantity' value='1'></form></td>
                                <td>".$price." DHS</td>
                            </tr> 
                        ";
                    }
                    $totalP=$db->prepare("SELECT sum(price) FROM panier;");
                    $totalP->execute();
                    $total=$totalP->fetch();
                    
                }catch(PDOException $e){
                    echo $e->getMessage;
                }
                ?>
            </tbody>
        </table>
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: orange;color: snow;"><b>Confirm Order</b></div>
            <div class="panel-body">
                <div class="col-sm-3">
                    <h3> Delivery :</h3> <br><var>10.25 DHS</var>
                </div>
                <div class="col-sm-3">
                    <h3>Total Price:</h3> <br><var><?= $total['sum(price)']+10.25?> DHS</var>
                </div>
                <div class="col-sm-3">
                    <h3>Payment Card :</h3>
                    <ul>
                        <li><input type="radio" name="payment" id="payment1">
                            <label for="payment1">Paypal</label>
                        </li>
                        <li><input type="radio" name="payment" id="payment2">
                            <label for="payment2">Visa Card</label>
                        </li>
                        <li><input type="radio" name="payment" id="payment3">
                            <label for="payment3">Master Card</label>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <?php include 'cart.php'?>
                    <form method="POST" action="cart.php">
                    <button type="submit" name="buy" id="buy" class="btn btn-default" style="background-color:springgreen;color: snow;margin-top: 50px;"><b></b> Buy Now</b></button>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <br>
    <footer class="container" style="background-color:rgb(172, 13, 13);width:100%;border-top: snow solid 3px;">
        <div class="col-sm-6 ">
            <a id="nav" href=" "><b> Our group<br>Learn more about us</b></a>
        </div>
        <div class="col-sm-6 ">
            <h4 style="text-decoration-line: underline;color: snow; "><b>Find us</b></h4>
            <li>
                <a id="nav" href=""><img src="img/icons/Twitter.png " height="25 " width="25 "><b> Twitter</b></a>
            </li>
            <li>
                <a id="nav" href=""><img src="img/icons/facebook.png " height="25 " width="25 " alt=" "><b>Facebook</b></a>
            </li>
            <li>
                <a id="nav" href=""><img src="img/icons/instagram.png " height="25 " width="25 " alt=" "><b>Instagram</b></a>
            </li>

        </div>
    </footer>






</body>

</html>