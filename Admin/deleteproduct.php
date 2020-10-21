  
<?php
    include("config.php");

    $query = "SELECT * FROM products";
    $result = mysqli_query($conn, $query);
    
    if(isset($_GET['id']))
    {
        if($result ->num_rows>0)
        {
            foreach($result as $row)
            {
                $id=$_GET['id'];
                if($row['product_id'] == $id)
                {
                    $sql = "DELETE FROM products WHERE product_id=$id";
                    $result = mysqli_query($conn,$sql);
                    
                    header("Location:products.php");
                }
            }
        }
    }
?>