<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php
include('../Admin/config.php');

$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);

$count = 0;
//set array
$product_array = array();
//look through query
while ($row = mysqli_fetch_assoc($result)) {
  // add each row returned into an array
  $product_array[] = $row;
  $count++;
}
if (isset($_POST['action'])) {
  switch ($_POST['action']) {
    case "categories":

      $count = 0;
      $product_array = array();
      $category_id = null;
      $cat_name = implode($_POST['categories']);
      $sql = "SELECT category_id FROM categories WHERE cat_name ='" . $cat_name . "'";
      $result = mysqli_query($conn, $sql);
      while ($row = mysqli_fetch_assoc($result)) {
        // add each row returned into an array
        $category_id = $row['category_id'];
      }
      $sql = "SELECT * FROM products WHERE category_id='" . $category_id . "'";
      $result = mysqli_query($conn, $sql);
      while ($row = mysqli_fetch_assoc($result)) {
        // add each row returned into an array
        $product_array[] = $row;
        $count++;
      }
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
      if ($result->num_rows > 0) {
        foreach ($product_array as $row) {
          $output .= '<ul class="aa-product-catg">
        <!-- start single product item -->
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
        </form>
                                             
      </ul>
      <!-- quick view modal -->                  
      <div class="modal fade" id="quick-view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">                      
            <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <div class="row">
                <!-- Modal view slider -->
                <div class="col-md-6 col-sm-6 col-xs-12">                              
                  <div class="aa-product-view-slider">                                
                    <div class="simpleLens-gallery-container" id="demo-1">
                      <div class="simpleLens-container">
                          <div class="simpleLens-big-image-container">
                              <a class="simpleLens-lens-image" data-lens-image="img/view-slider/large/polo-shirt-1.png">
                                  <img src="img/view-slider/medium/polo-shirt-1.png" class="simpleLens-big-image">
                              </a>
                          </div>
                      </div>
                      <div class="simpleLens-thumbnails-container">
                          <a href="#" class="simpleLens-thumbnail-wrapper"
                             data-lens-image="img/view-slider/large/polo-shirt-1.png"
                             data-big-image="img/view-slider/medium/polo-shirt-1.png">
                              <img src="img/view-slider/thumbnail/polo-shirt-1.png">
                          </a>                                    
                          <a href="#" class="simpleLens-thumbnail-wrapper"
                             data-lens-image="img/view-slider/large/polo-shirt-3.png"
                             data-big-image="img/view-slider/medium/polo-shirt-3.png">
                              <img src="img/view-slider/thumbnail/polo-shirt-3.png">
                          </a>

                          <a href="#" class="simpleLens-thumbnail-wrapper"
                             data-lens-image="img/view-slider/large/polo-shirt-4.png"
                             data-big-image="img/view-slider/medium/polo-shirt-4.png">
                              <img src="img/view-slider/thumbnail/polo-shirt-4.png">
                          </a>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal view content -->
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="aa-product-view-content model">
                    
            </div>                        
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div>';
        }
      } else {
        $output = "<h3>No Product Found";
      }
      echo $output;
      break;
  }
}

?>
<ul class="aa-product-catg">
  <!-- start single product item -->
  <?php foreach ($product_array as $key => $value) { ?>
    <form action="product.php?action=add&product_id=<?php echo $product_array[$key]["product_id"]; ?>">
      <li>
        <figure>
          <a class="aa-product-img" href="#"><img src="../Admin/resources/images/productimage/<?php echo $product_array[$key]["product_image"]; ?>" alt="polo shirt img"></a>
          <a class="aa-add-card-btn add" href="#" data-action="add" data-productid="<?php echo $product_array[$key]["product_id"]; ?>" name="add-to-cart"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
          <figcaption>
            <h4 class="aa-product-title"><a href="#"><?php echo $product_array[$key]["product_name"]; ?></a></h4>
            <span class="aa-product-price">$<?php echo $product_array[$key]["product_price"]; ?></span>
            <p class="aa-product-descrip"><?php echo $product_array[$key]["long_desc"]; ?></p>
          </figcaption>
        </figure>
        <div class="aa-product-hvr-content">
          <a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>
          <a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>
          <a href="#" data-toggle2="tooltip" class="quick" data-placement="top" data-productid="<?php echo $product_array[$key]["product_id"]; ?>" title="Quick View" data-action="quick" data-toggle="modal" data-target="#quick-view-modal"><span class="fa fa-search"></span></a>
        </div>
        <!-- product badge -->
        <span class="aa-badge aa-sale" href="#">SALE!</span>
      </li>
    <?php } ?>
    </form>

</ul>
<!-- quick view modal -->
<div class="modal fade" id="quick-view-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <div class="row">
          <!-- Modal view slider -->
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="aa-product-view-slider">
              <div class="simpleLens-gallery-container" id="demo-1">
                <div class="simpleLens-container">
                  <div class="simpleLens-big-image-container">
                    <a class="simpleLens-lens-image" data-lens-image="img/view-slider/large/polo-shirt-1.png">
                      <img src="img/view-slider/medium/polo-shirt-1.png" class="simpleLens-big-image">
                    </a>
                  </div>
                </div>
                <div class="simpleLens-thumbnails-container">
                  <a href="#" class="simpleLens-thumbnail-wrapper" data-lens-image="img/view-slider/large/polo-shirt-1.png" data-big-image="img/view-slider/medium/polo-shirt-1.png">
                    <img src="img/view-slider/thumbnail/polo-shirt-1.png">
                  </a>
                  <a href="#" class="simpleLens-thumbnail-wrapper" data-lens-image="img/view-slider/large/polo-shirt-3.png" data-big-image="img/view-slider/medium/polo-shirt-3.png">
                    <img src="img/view-slider/thumbnail/polo-shirt-3.png">
                  </a>

                  <a href="#" class="simpleLens-thumbnail-wrapper" data-lens-image="img/view-slider/large/polo-shirt-4.png" data-big-image="img/view-slider/medium/polo-shirt-4.png">
                    <img src="img/view-slider/thumbnail/polo-shirt-4.png">
                  </a>
                </div>
              </div>
            </div>
          </div>
          <!-- Modal view content -->
          <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="aa-product-view-content model">

            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div>
      <script>
        $('.quick').click(function() {

          var productid = $(this).data('productid');
          $.ajax({
              method: "POST",
              url: "model.php",
              data: {
                productid: productid
              }
            })
            .done(function(msg) {
              $('.model').html(msg);
            });


        });
      </script>
      <?php  ?>