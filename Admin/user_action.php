<?php
require 'config.php';
if (!empty($_POST['action'])) {
    switch ($_POST['action']) {
        case "userdelete":
            echo ($_POST['productid']);
            $query = "SELECT * FROM users";
            $result = mysqli_query($conn, $query);

            if (isset($_POST['productid'])) {
                if ($result->num_rows > 0) {
                    foreach ($result as $row) {
                        $id = $_POST['productid'];
                        if ($row['user_id'] == $id) {
                            $sql = "DELETE FROM users WHERE user_id=$id";
                            $result = mysqli_query($conn, $sql);

                            header("Location:manageuser.php");
                        }
                    }
                }
            }
            break;
        case "userupdate":
            $errors = array();
            if (sizeof($errors) == 0) {
                $sql = "SELECT * FROM users where `user_id` = '" . $_POST["productid"] . "'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // output data of each row
                    while ($row = $result->fetch_assoc()) {
                        $userdata = array(
                            'user_id' => $row['user_id'],
                            'username' => $row['username'], 'passwords' => $row['passwords'], 'email' => $row['email']
                        );
                    }
                } else {
                    $errors[] = array('input' => 'form', 'msg' => $conn->error);
                }
            }
            if (isset($_POST['update'])) {
                echo "<script>alert('hi')</script>";
                $sql = "UPDATE users 
                SET `username`='$_POST[username]' , `email`='$_POST[email]'
                WHERE `user_id`='". $_POST["productid"] ."'";
                if ($conn->query($sql) === true) {
                    echo "Record updated successfully";
                    header("Location: manageuser.php");
                } else {
                    echo "Error updating record: " . $conn->error;
                }

                $conn->close();
            }


            break;
    }
}
?>
<form method="post">

    <fieldset>
        <!-- Set class to "column-left" or "column-right" on fieldsets to divide the form into columns -->

        <p>
            <label>UserName</label>
            <input class="text-input small-input" type="text" id="small-input" name="username" value="<?php echo $userdata['username']; ?>" />
            <!-- <span class="input-notification success png_bg">Successful message</span> -->
            <!-- Classes for input-notification: success, error, information, attention -->
            <br />
        </p>

        <p>
            <label>Email</label>
            <input class="text-input small-input" type="text" id="large-input" name="email" value="<?php echo $userdata['email']; ?>" />
        </p>
        <p>
            <input class="button" type="submit" name="update" value="update" />
        </p>

    </fieldset>

    <div class="clear"></div><!-- End .clear -->

</form>