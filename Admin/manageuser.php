<?php include('header.php');
include('sidebar.php');
include('config.php');
$errors = array();
$sql = "SELECT * FROM users";
$result = mysqli_query($conn, $sql);
if(isset($_POST['add']))
{
	$username = isset($_POST['username']) ? $_POST['username'] : '';
	$email = isset($_POST['email']) ? $_POST['email'] : '';
	$passwords = isset($_POST['passwords']) ? $_POST['passwords'] : '';
	$sql="INSERT INTO users (`username`,`email`,`passwords`) VALUES ('".$username."','".$email."','".$passwords."')";
	if (sizeof($errors) == 0) {
	if ($conn->query($sql) === true) {
		//echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
		$errors[] = array('input' => 'form', 'msg' => $conn->error);
	}
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

			<h3>Content box</h3>

			<ul class="content-box-tabs">
				<li><a href="#tab1" class="default-tab">Manage</a></li> <!-- href must be unique and match the id of target div -->
				<li><a href="#tab2">Add</a></li>
			</ul>

			<div class="clear"></div>

		</div> <!-- End .content-box-header -->

		<div class="content-box-content">

			<div class="tab-content default-tab" id="tab1">
				<!-- This is the target div. id must match the href of this div's tab -->

				<div class="notification attention png_bg">
					<a href="#" class="close"><img src="resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close" /></a>
					<div>
						This is a Content Box. You can put whatever you want in it. By the way, you can close this notification with the top-right cross.
					</div>
				</div>

				<table>

					<thead>
						<tr>
							<th><input class="check-all" type="checkbox" /></th>
							<th>UserId</th>
							<th>UserName</th>
							<th>Email</th>
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
						
						while ($row = mysqli_fetch_array($result)) {
							
						?>
						<tr>
							<td><input type="checkbox" /></td>
							<td><?php echo $row["user_id"]; ?></td>
							<td><a href="#" title="title"><?php echo $row["username"]; ?></a></td>
							<td><?php echo $row["email"]; ?></td>
							<td>
								<!-- Icons -->
								<a href="#" title="Edit" class="edit" data-action="userupdate" data-productid="<?php echo $row["user_id"]; ?>"><img src="resources/images/icons/pencil.png" alt="Edit" /></a>
								<a href="#" title="Delete" class="delete" data-action="userdelete" data-productid="<?php echo $row["user_id"]; ?>"><img src="resources/images/icons/cross.png" alt="Delete" /></a>
							</td>
						</tr>
						<?php
						}
						?>
					</tbody>

				</table>

			</div> <!-- End #tab1 -->

			<div class="tab-content update result" id="tab2">
			

				<form method="post">

					<fieldset>
						<!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->

						<p>
							<label>UserName</label>
							<input class="text-input small-input" type="text" id="small-input" name="username" />
							<!-- <span class="input-notification success png_bg">Successful message</span> -->
							<!-- Classes for input-notification: success, error, information, attention -->
							<br />
						</p>

						<p>
							<label>Email</label>
							<input class="text-input small-input" type="text" id="large-input" name="email" />
						</p>
						
						<p>
							<label>Password</label>
							<input class="text-input small-input" type="password" id="passwords" name="passwords" ><br><br>
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
	<script>
		$('.delete').on("click", function() {

			var productid = $(this).data('productid');
			var action = $(this).data('action');

			$.ajax({
					method: "POST",
					url: "user_action.php",
					data: {
						productid: productid,
						action: action
					}
				})
				.done(function(msg) {
					alert("Data Saved: " + msg);
				});
		});
		$('.edit').on("click", function() {
			

			var productid = $(this).data('productid');
			var action = $(this).data('action');

			$.ajax({
					method: "POST",
					url: "user_action.php",
					data: {
						productid: productid,
						action: action
					}
				})
				.done(function(msg) {
					$('.result').html(msg);
				});

		});
	</script>
	<?php include('footer.php'); ?>