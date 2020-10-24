<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php
include('../Admin/config.php');

if (isset($_POST['action'])) {
  switch ($_POST['action']) {
    case "categories":
      $count = 0;
      $product_array = array();
      $sql = "SELECT * FROM products WHERE quantity='1'";
      if (isset($_POST['categories'])) {
        $cat_name = implode($_POST['categories']);
        $sql .= "AND category_id=(SELECT category_id FROM categories WHERE cat_name='" . $cat_name . "')";
      }
      $result = mysqli_query($conn, $sql);
      while ($row = mysqli_fetch_assoc($result)) {
        // add each row returned into an array
        $product_array[] = $row;
        $count++;
      }
      $output = '';
      if ($result->num_rows > 0) {
        foreach ($product_array as $key => $value) {
          $output .= ' <form action="product.php?action=add&product_id=' . $product_array[$key]["product_id"] . '">
        <li>
          <figure>
            <a class="aa-product-img" href="#"><img src="../Admin/resources/images/productimage/' . $product_array[$key]["product_image"] . '" alt="polo shirt img"></a>
            <a class="aa-add-card-btn add" href="#" data-action="add" data-productid="' . $product_array[$key]["product_id"] . '" name="add-to-cart"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
            <figcaption>
              <h4 class="aa-product-title"><a href="#">' . $product_array[$key]["product_name"] . '</a></h4>
              <span class="aa-product-price">$' . $product_array[$key]["product_price"] . '</span>
              <p class="aa-product-descrip">' . $product_array[$key]["long_desc"] . '</p>
            </figcaption>
          </figure>
          <div class="aa-product-hvr-content">
            <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
            <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
            <a href="#" data-toggle2="tooltip" class="quick" data-placement="top" data-productid="' . $product_array[$key]["product_id"] . '" title="Quick View" data-action="quick" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search"></span></a>
          </div>
          <!-- product badge -->
          <span class="aa-badge aa-sale" href="#">SALE!</span>
        </li>
      
      </form>';
        }
      } else {
        $output = "<h3>No Product Found</h3>";
      }
      echo $output;

      break;
    case "tags":
      $sql = "SELECT * FROM products WHERE quantity='1'";
      if (isset($_POST['color'])) {
        $color = implode("|", $_POST['color']);
        $sql .= "AND color REGEXP '$color'";
      }
      if (isset($_POST['tags'])) {
        $tags = implode("|", $_POST['tags']);
        $sql .= "AND tag_id REGEXP '$tags'";
      }
      if (isset($_POST['minimum_price'], $_POST['maximum_price']) && !empty($_POST['minimum_price']) && !empty($_POST['maximum_price'])) {

        $sql .= "And product_price BETWEEN '$_POST[minimum_price]' AND '$_POST[maximum_price]'";
      }
      echo ($sql);
      $result = mysqli_query($conn, $sql);
      $output = '';
      $count = 0;
      //set array
      $product_array = array();
      while ($row = $result->fetch_assoc()) {
        $product_array[] = $row;
        $count++;
      }
      $output = '';
      if ($result->num_rows > 0) {
        foreach ($product_array as $row) {
          $output .= '
        <form>
        <li>
          <figure>
            <a class="aa-product-img" href="#"><img src="../Admin/resources/images/productimage/' . $row['product_image'] . '" alt="polo shirt img"></a>
            <a class="aa-add-card-btn add"href="#" data-action="add" data-productid=' . $row['product_id'] . '
             name="add-to-cart"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
            <figcaption>
              <h4 class="aa-product-title"><a href="#">' . $row['product_name'] . '</a></h4>
              <span class="aa-product-price">$' . $row['product_price'] . '</span>
              <p class="aa-product-descrip">"' . $row['long_desc'] . '" </p>
            </figcaption>
          </figure>                         
          <div class="aa-product-hvr-content">
            <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
            <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
            <a href="#" data-toggle2="tooltip"  class="quick" data-placement="top"  data-productid="' . $row['product_id'] . '"
            title="Quick View" data-action="quick" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search"></span></a>                            
          </div>
          <!-- product badge -->
          <span class="aa-badge aa-sale" href="#">SALE!</span>
        </li>
        </form>';
        }
      } else {
        $output = "<h3>No Product Found";
      }
      echo $output;
      break;
  }
}

?>