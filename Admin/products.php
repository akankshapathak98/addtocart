<?php include('header.php');
include('sidebar.php');
include('config.php');
$errors = array();
$message = '';
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

if (isset($_POST['add'])) {
	$product_name = isset($_POST['product_name']) ? $_POST['product_name'] : '';
	$product_price = isset($_POST['product_price']) ? $_POST['product_price'] : '';
	$category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
	print_r($category_id);

	if (sizeof($errors) == 0) {
		$filename = $_FILES["uploadfile"]["name"];
		$tempname = $_FILES["uploadfile"]["tmp_name"];
		$folder = "resources/images/productimage/" . $filename;
		$sql = 'INSERT INTO products (`product_name`, `product_price`,`product_image`,`category_id`,`short_desc`,`long_desc`)    
        values ("' . $product_name . '", "' . $product_price . '","' . $filename . '",(SELECT `category_id` FROM categories WHERE `category_id` = "' . $category_id . '")
        ,"This Hi-Grip Basketball Is Suitable for practice, normal match and for beginners.","This Hi-Grip Basketball Is Suitable for practice, normal match and for beginners.This Hi-Grip Basketball Is Suitable for practice, normal match and for beginners.")';
		if ($conn->query($sql) === true) {
			//echo "New record created successfully";
		} else {
			// echo "Error: " . $sql . "<br>" . $conn->error;
			$errors[] = array('input' => 'form', 'msg' => $conn->error);
		}
		if (move_uploaded_file($tempname, $folder)) {
		} else {
		}
		$conn->close();
	}
}

?>
<div id="main-content">
	<!-- Main Content Section with everything -->

	<noscript>
		<!-- Show a notification if the user has disabled javascript -->
		<div class="notification error png_bg">
			<div>
				Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
			</div>
		</div>
	</noscript>

	<!-- Page Head -->
	<h2>Welcome John</h2>
	<p id="page-intro">What would you like to do?</p>
	<div class="clear"></div> <!-- End .clear -->

	<div class="content-box">
		<!-- Start Content Box -->

		<div class="content-box-header">

			<h3>Product</h3>

			<ul class="content-box-tabs">
				<li><a href="#tab1" class="default-tab">Manage</a></li> <!-- href must be unique and match the id of target div -->
				<li><a href="#tab2">Add</a></li>
			</ul>

			<div class="clear"></div>

		</div> <!-- End .content-box-header -->

		<div class="content-box-content">

			<div class="tab-content default-tab" id="tab1">
				<!-- This is the target div. id must match the href of this div's tab -->

				<!-- <div class="notification attention png_bg">
							<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
							<div>
								This is a Content Box. You can put whatever you want in it. By the way, you can close this notification with the top-right cross.
							</div>
						</div> -->

				<table>

					<thead>
						<tr>
							<th><input class="check-all" type="checkbox" /></th>

							<th>ProductName</th>
							<th>PruductPrice</th>
							<th>category_id</th>
							<th>ProductImage</th>
							<th>ShortDescription</th>
							<th>LongDescription</th>

							<th>Action</th>
						</tr>

					</thead>

					<tfoot>
						<tr>
							<td colspan="6">
								<div class="bulk-actions align-left">
									<select name="dropdown">
										<option value="option1">Choose an action...</option>
										<option value="option2">Edit</option>
										<option value="option3">Delete</option>
									</select>
									<a class="button" href="#">Apply to selected</a>
								</div>

								<div class="pagination">
									<a href="#" title="First Page">&laquo; First</a><a href="#" title="Previous Page">&laquo; Previous</a>
									<a href="#" class="number" title="1">1</a>
									<a href="#" class="number" title="2">2</a>
									<a href="#" class="number current" title="3">3</a>
									<a href="#" class="number" title="4">4</a>
									<a href="#" title="Next Page">Next &raquo;</a><a href="#" title="Last Page">Last &raquo;</a>
								</div> <!-- End .pagination -->
								<div class="clear"></div>
							</td>
						</tr>
					</tfoot>

					<tbody>
						<?php
						$i = 0;
						while ($row = mysqli_fetch_array($result)) {
							if ($i % 2 == 0) {
								$classname = "evenRow";
							} else {
								$classname = "oddRow";
							}
						?>

							<tr>
								<td><input type="checkbox" /></td>

								<td><?php echo $row["product_name"]; ?></td>
								<td><?php echo $row["product_price"]; ?></td>
								<td><?php echo $row["category_id"]; ?></td>
								<td><img src="resources/images/productimage/<?php echo $row["product_image"]; ?>" height="25px" width="25px"></td>
								<td><?php echo $row["short_desc"]; ?></td>
								<td><?php echo $row["long_desc"]; ?></td>
								<td>
									<!-- Icons -->
									<a href="#" title="Edit"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
									<a href="#" title="Delete"><img src="resources/images/icons/cross.png" alt="Delete" /></a>
								</td>
							</tr>

						<?php
							$i++;
						}
						?>
					</tbody>

				</table>

			</div> <!-- End #tab1 -->

			<div class="tab-content " id="tab2">
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
							<input class="text-input small-input" type="text" id="small-input" name="product_name" />
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
							<input class="text-input small-input" type="text" id="large-input" name="product_price" />
						</p>
						<p>
							<label for="image">ProductImage:</label>
							<input class="text-input small-input" type="file" id="large-input" name="uploadfile" />



						</p>
						<p>
							<label>Category</label>
							<select name="category_id" class="small-input">
								<option value="1">Men</option>
								<option value="2">Women</option>
								<option value="3">Kids</option>
								<option value="4">Electronics</option>
								<option value="5">Sports</option>
							</select>
						</p>
						<p>
							<label>Tags</label>
							<input type="checkbox" name="fashion" /> Fashion
							<input type="checkbox" name="ecommerce" /> Ecommerce
							<input type="checkbox" name="shop" /> Shop
							<input type="checkbox" name="handbag" /> Hand Bag
							<input type="checkbox" name="laptop" /> Laptop
							<input type="checkbox" name="headphone" /> Headphone
						</p>
						<p>
							<label>Description</label>
							<textarea class="text-input textarea wysiwyg" id="textarea" name="textfield" cols="79" rows="15"></textarea>
						</p>
						<p>
							<input class="button" type="submit" name="add" value="Submit" />
						</p>

					</fieldset>

					<div class="clear"></div><!-- End .clear -->

				</form>

			</div> <!-- End #tab2 -->

		</div> <!-- End .content-box-content -->
	</div> <!-- End .content-box -->
	<div class="clear"></div>
	<?php include('footer.php'); ?>