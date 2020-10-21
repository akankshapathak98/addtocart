<?php
session_start();
require 'config.php';
$message='';
$product_array = array();
$querry = "SELECT * FROM tags ";
$results = mysqli_query($conn, $querry);
$querryy = "SELECT * FROM categories ";
$resultt = mysqli_query($conn, $querryy);
$query = mysqli_query($conn, "SELECT * FROM products ORDER BY product_id ASC");
$count = 0;
//set array
$product_array = array();
//look through query
while ($row = mysqli_fetch_assoc($query)) {
    // add each row returned into an array
    $product_array[] = $row;
    $count++;
}
if (!empty($_POST['action'])) {
    switch ($_POST['action']) {



        case "remove":
            echo ($_POST['productid']);
            $query = "SELECT * FROM products";
            $result = mysqli_query($conn, $query);

            if (isset($_POST['productid'])) {
                if ($result->num_rows > 0) {
                    foreach ($result as $row) {
                        $id = $_POST['productid'];
                        if ($row['product_id'] == $id) {
                            $sql = "DELETE FROM products WHERE product_id=$id";
                            $result = mysqli_query($conn, $sql);

                            header("Location:products.php");
                        }
                    }
                }
            }
            break;
        case "update":
            $errors = array();
            if (sizeof($errors) == 0) {
                $sql = "SELECT * FROM products where product_id = '" . $_POST["productid"] . "' ";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $userdata = array(
                            'product_id' => $row['product_id'],
                            'product_name' => $row['product_name'], 'product_price' => $row['product_price'], 'product_image' => $row['product_image'],'color'=>$row['color'],
                            'category_id'=>$row['category_id'],'tag_id'=>$row['tag_id'],'long_desc'=>$row['long_desc']
                        );
                    }
                } else {
                    $errors[] = array('input' => 'form', 'msg' => $conn->error);
                }
            }
            if (isset($_POST['update'])) {
                $tag_id = isset($_POST['tags']) ? $_POST['tags'] : '';
                $tag_id = implode(",", $_POST['tags']);
                $filename = $_FILES["uploadfile"]["name"];
                $tempname = $_FILES["uploadfile"]["tmp_name"];
                $folder = "resources/images/productimage/" . $filename;
                $sql = "UPDATE products 
    SET `product_name`='$_POST[product_name]' , `product_price`='$_POST[product_price]' , `product_image`='$filename',`color`='$_POST[color]',
    `category_id`='$_POST[category_id]',`tag_id`='addslashes( $tag_id )',`long_desc`='$_POST[long_desc]'
    WHERE `product_id`='" . $_POST["productid"] . "' ";
                if ($conn->query($sql) === true) {
                    echo "Record updated successfully";
                    header("Location: dashboard.php");
                } else {
                    //echo "Error updating record: " . $conn->error;
                }
                if (move_uploaded_file($tempname, $folder)) {
                    $msg = "Image uploaded successfully";
                } else {
                    $msg = "Failed to upload image";
                }
                $conn->close();
            }


            break;
    }
}

?>
<div id="message"><?php echo $message; ?></div>
				<div id="errors">
					<?php if (sizeof($errors) > 0) : ?>
						<ul>
							<?php foreach ($errors as $error) : ?>
								<li><?php echo $error['msg']; ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>

				<form method="post" enctype="multipart/form-data">

					<fieldset>
						<!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->

						<p>
							<label>ProductName</label>
                            <input class="text-input small-input" type="text" id="small-input" name="product_name"
                            value="<?php echo $userdata['product_name']; ?>" />
							<!-- <span class="input-notification success png_bg">Successful message</span> -->
							<!-- Classes for input-notification: success, error, information, attention -->
							<br />
						</p>

						<!-- <p>
									<label></label>
									<input class="text-input medium-input datepicker" type="text" id="medium-input" name="medium-input" /> <span class="input-notification error png_bg">Error message</span>
								</p> -->

						<p>
							<label>ProductPrice</label>
                            <input class="text-input small-input" type="text" id="large-input" name="product_price" 
                            value="<?php echo $userdata['product_price']; ?>"/>
						</p>
						<p>
							<label for="image">ProductImage:</label>
							<input class="text-input small-input" type="file" id="large-input" name="uploadfile" />



						</p>
						<p>
							<label>Color</label>
							<input type="color" id="color" name="color"  value="<?php echo $userdata['color']; ?>"><br><br>
							</p>
						<p>
							<label>Category</label>
							<select name="category_id" class="small-input">
							<?php
						
						while ($row = mysqli_fetch_array($resultt)) {
						
						?>
								<option value="<?php echo $row["category_id"]?>"><?php echo $row["cat_name"]?></option>
								<?php
							
						}
						?>
							</select>
						</p>
						<p>
							<label>Tags</label>
							<?php
						
						while ($row = mysqli_fetch_array($results)) {
							
						?>
								<input type="checkbox" name="tags[]"  value="<?php echo $row["tag_name"]?>"/> <?php echo $row["tag_name"]?>
								<?php
							
						}
						?>
						</p>
						<p>
							<label>Description</label>
                            <textarea class="text-input textarea wysiwyg" id="textarea" name="long_desc" cols="79" rows="15"
                            value="<?php echo $userdata['long_desc']; ?>"></textarea>
						</p>
						<p>
							<input class="button" type="submit" name="add" value="Update" />
						</p>

					</fieldset>

					<div class="clear"></div><!-- End .clear -->

				</form>
