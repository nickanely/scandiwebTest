<?php
@include 'config.php';
  $select = mysqli_query($conn, "SELECT * FROM products");
  
  

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product List</title>
  <link rel="stylesheet" href="product_list.css">
</head>
<body>

  <header>
    <h1>Product List</h1>
    <button id="add-product-btn">ADD</button>
    <form id="product-list-form" method="post" action="delete_products.php">
    <button id="delete-product-btn">MASS DELETE</button>
    
    
      
  </header>
  <hr>
  <div class="display-product">

  <?php while($row = mysqli_fetch_assoc($select)){ ?>
    <div class="product-box">
    <input type="checkbox" class="delete-checkbox" name="deleteSkus[]" value="<?php echo $row['sku']; ?>">
      <h3><?php echo $row['sku']?></h3>
      <p><?php echo $row['name']?></p>
      <span><?php echo $row['price']?>$</span>
      <p>
      <?php
      if ($row['attribute_name'] === 'DVD') {
        echo 'Size: ' . $row['size'] . 'MB';
      } elseif ($row['attribute_name'] === 'Book') {
        echo 'Weight: ' . $row['weight'] . 'KG';
      } elseif ($row['attribute_name'] === 'Furniture') {
        echo 'Dimensions: ' . $row['width'] . 'x' . $row['height'] . 'x' . $row['length'];
      }
      ?>
      </p>
    </div>

  <?php } ?>
    
    
  </div>
</form>
  <script src="product_list.js"></script>
</body>
</html>