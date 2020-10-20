<?php
include('../Admin/config.php');
$productid = $_POST['productid'];
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
?>
<?php


foreach ($product_array as $key => $value) {
  if ($value['product_id'] == $productid) {

?>
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
                      <a class="simpleLens-lens-image" data-lens-image="../Admin/resources/images/productimage/<?php echo $product_array[$key]["product_image"]; ?>" alt="polo shirt img">
                        <img src="../Admin/resources/images/productimage/<?php echo $product_array[$key]["product_image"]; ?>" alt="polo shirt img" class="simpleLens-big-image">
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
              <div class="aa-product-view-content">

                <div class="aa-price-block">
                  <span class="aa-product-view-price">$<?php echo $product_array[$key]["product_price"]; ?></span>
                  <p class="aa-product-avilability">Avilability: <span>In stock</span></p>
                </div>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Officiis animi, veritatis quae repudiandae quod nulla porro quidem, itaque quis quaerat!</p>
                <h4></h4>
                <div class="aa-prod-view-size">
                  <a href="#">S</a>
                  <a href="#">M</a>
                  <a href="#">L</a>
                  <a href="#">XL</a>
                </div>
                <div class="aa-prod-quantity">
                  <form action="">
                    <select name="" id="">
                      <option value="0" selected="1">1</option>
                      <option value="1">2</option>
                      <option value="2">3</option>
                      <option value="3">4</option>
                      <option value="4">5</option>
                      <option value="5">6</option>
                    </select>
                  </form>
                  <p class="aa-prod-category">
                    Category: <a href="#">Polo T-Shirt</a>
                  </p>
                </div>
                <div class="aa-prod-view-bottom">
                  <a href="#" class="aa-add-to-cart-btn"><span class="fa fa-shopping-cart"></span>Add To Cart</a>
                  <a href="#" class="aa-add-to-cart-btn">View Details</a>
                </div>
            <?php }
        } ?>
              </div>
            </div>
          </div>
        </div>
      </div><!-- /.modal-content -->
    </div>