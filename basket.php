<?php
session_start();
include("db.php");
$pagename = "Smart Basket";
echo "<link rel=stylesheet type=text/css href=mystylesheet.css>";
echo "<title>".$pagename."</title>";
echo "<body>";

include("headfile.html");
include("detectlogin.php");
echo "<h4>".$pagename."</h4>";

//if the value of the product id to be deleted (which was posted through the hidden field) is set
if (isset($_POST['del_prodid']))
{
//capture the posted product id and assign it to a local variable $delprodid
$delprodid=$_POST['del_prodid'];
//unset the cell of the session for this posted product id variable
unset ($_SESSION['basket'][$delprodid]);
//display a "1 item removed from the basket" message
echo "<p>1 item removed from the basket";
}

// Check if a new product is being added
if (isset($_POST['h_prodid']) && isset($_POST['p_quantity'])) {
    $newprodid = $_POST['h_prodid'];
    $reququantity = $_POST['p_quantity'];

    if (is_numeric($newprodid) && is_numeric($reququantity) && $reququantity > 0) {
        $_SESSION['basket'][$newprodid] = $reququantity; 
        echo "<p>1 item added to basket</p>";
    } else {
        echo "<p>Error: Invalid product or quantity.</p>";
    }
} 



$total = 0;
echo "<p><table id='baskettable'>";
echo "<tr><th>Product Name</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th>Remove Product</th></tr>";

// Check if basket exists and is not empty
if (isset($_SESSION['basket']) && count($_SESSION['basket']) > 0) {
    foreach ($_SESSION['basket'] as $index => $value) {
        if (!is_numeric($index)) continue; // Skip invalid product IDs

        $SQL = "SELECT prodName, prodPicNameSmall, prodPrice FROM product WHERE prodId=" . intval($index);
        $exeSQL = mysqli_query($conn, $SQL);

        if (!$exeSQL) {
            die("<p>SQL Error: " . mysqli_error($conn) . "</p>");
        }

        if ($arrayp = mysqli_fetch_array($exeSQL)) {
            echo "<tr>";
            echo "<td>".$arrayp['prodName']."</td>";
            echo "<td>&pound".number_format($arrayp['prodPrice'],2)."</td>";
            echo "<td style='text-align:center;'>".$value."</td>";

            $subtotal = $arrayp['prodPrice'] * $value;
            echo "<td>&pound".number_format($subtotal,2)."</td>";

            // Add Remove Button
            echo "<td>";
            echo "<form action='basket.php' method='post'>";
            echo "<input type='hidden' name='del_prodid' value='".$index."'>";
            echo "<input type='submit' value='Remove' id='submitbtn'>";
            echo "</form>";
            echo "</td>";

            echo "</tr>";

            $total += $subtotal;
        } else {
            echo "<tr><td colspan='5'>Product not found</td></tr>";
        }
    }
} else {
    echo "<tr><td colspan='5'>Your basket is empty</td></tr>";
}

// Display total
echo "<tr>";
echo "<td colspan=3><b>TOTAL</b></td>";
echo "<td><b>&pound".number_format($total,2)."</b></td>";
echo "<td></td>"; // Empty column for alignment
echo "</tr>";
echo "</table>";

echo "<br><p><a href='clearbasket.php'>CLEAR BASKET</a></p>";

if (isset($_SESSION['userid']))
{
echo "<br><p>To finalize your order: <a href=checkout.php>CHECKOUT</a></p>";
}
else
{
echo "<br><p>New homteq customers: <a href='signup.php'>Sign up</a></p>";
echo "<p>Returning homteq customers: <a href='login.php'>Login</a></p>";
}

include("footfile.html"); 
echo "</body>";
?>
