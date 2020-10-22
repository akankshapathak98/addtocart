<?php 
session_start();
require '../Admin/config.php';
$product_array=array();
$query = mysqli_query($conn, "SELECT * FROM products ORDER BY product_id ASC");
        $count=0;
        //set array
        $product_array=array();
        //look through query
        while ($row = mysqli_fetch_assoc($query)) {
            // add each row returned into an array
            $product_array[]=$row;
            $count++;
        }
if (!empty($_POST['action'])) {
    switch ($_POST['action']) {
        case "add":
            $cartProduct=array();
            if (isset($_POST['productid'])) {
                $pid=$_POST['productid'];
                
                foreach ($product_array as $key => $value) {
                    if ($product_array[$key]['product_id']==$pid) {
                        $cartProduct=array(
                        'product_name'=>$product_array[$key]['product_name'],
                        'product_id'=>$product_array[$key]['product_id'],
                        'quantity'=>$product_array[$key]['quantity'],
                        'product_price'=>$product_array[$key]['product_price'],
                        'image'=>$product_array[$key]['product_image']
                        );
                    }
                }
                if (isset($_SESSION['cart_item']) && !empty($_SESSION['cart_item'])) {
                    $productKey=null;
                    foreach ($_SESSION['cart_item'] as $key => $value) {
                        if ($value['product_id'] == $pid) {
                            $productKey=$key;
                        }
                    }
                    if ($productKey) {
                        $_SESSION["cart_item"][$productKey]["quantity"] +=1;
                    } else {
                        array_push($_SESSION['cart_item'], $cartProduct);
                    }
                } else {
                    $_SESSION['cart_item'][]= $cartProduct;
                }
            }
            
            break;
           
        case "remove":
            if (!empty($_SESSION["cart_item"])) {
                foreach ($_SESSION["cart_item"] as $k => $v) {
                    if ($_POST['productid'] == $v['product_id']) {
                        unset($_SESSION["cart_item"][$k]);
                        header("Refresh:0; url=cart.php");
                    }
                    if (empty($_SESSION["cart_item"])) {
                        unset($_SESSION["cart_item"]);
                    }
                }
            }
            break;
        case "update":
            if (!empty($_SESSION["cart_item"])) {
                foreach ($_SESSION["cart_item"] as $k => $v) {
                        $_SESSION["cart_item"][$k]["quantity"] =$_POST['quantity'][$k];
                    
                }
            }
            break;
        
        case "empty":
            
             unset($_SESSION["cart_item"]);
             header("Location: cart.php");
            break;
    }
}
if (isset($_POST['checkout'])) {


     $cartdata = json_encode($_SESSION["cart_item"]);
     $total_price=$_POST['total_price'];
     
     $sql = 'INSERT INTO orders (`user_id`,`cartdata`,`total`,`status`) 
     VALUES ("1","'.addslashes($cartdata).'","'.$total_price.'","completed")';
     if ($conn->query($sql) === true) {
     } else {
        $errors[] = array ('input'=>'form','msg'=>$conn->error);
        print_r($errors);
     }
     $conn->close();

}
