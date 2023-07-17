<?php
@include 'config.php';
  $select = mysqli_query($conn, "SELECT * FROM products");

// Retrieve the filter values from the request
$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
$categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';
$priceFilter = isset($_GET['price']) ? $_GET['price'] : '';

// Modify the SQL query to incorporate the filter criteria
$selectQuery = "SELECT * FROM products WHERE name LIKE '%$searchQuery%'";

if ($categoryFilter != '') {
  $selectQuery .= " AND attribute_name = '$categoryFilter'";
}

if ($priceFilter != '') {
  $priceRange = explode('-', $priceFilter);
  $minPrice = $priceRange[0];
  $maxPrice = $priceRange[1];
  $selectQuery .= " AND price >= $minPrice AND price <= $maxPrice";
}

// Execute the modified query to retrieve the filtered products
$select = mysqli_query($conn, $selectQuery);

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
    <form id="product-list-form" method="get" action="product_list.php">
    <div class="filter-section">
    <input type="text" id="search-input" name="search" placeholder="Search..." value="<?php echo $searchQuery; ?>">
    <select id="category-filter" name="category">
      <option value="">All Categories</option>
      <option value="DVD"<?php if ($categoryFilter === 'DVD') echo ' selected'; ?>>DVD</option>
      <option value="Book"<?php if ($categoryFilter === 'Book') echo ' selected'; ?>>Book</option>
      <option value="Furniture"<?php if ($categoryFilter === 'Furniture') echo ' selected'; ?>>Furniture</option>
    </select>
    <select id="price-filter" name="price">
      <option value="">All Prices</option>
      <option value="0-50"<?php if ($priceFilter === '0-50') echo ' selected'; ?>>$0 - $50</option>
      <option value="50-100"<?php if ($priceFilter === '50-100') echo ' selected'; ?>>$50 - $100</option>
      <option value="100-10000"<?php if ($priceFilter === '100-10000') echo ' selected'; ?>>$100 - 10000</option>
    </select>
    <button type="submit" id="filter-btn">Filter</button>
  </div>
</form>
  <div class="button-container">
    <button id="add-product-btn">ADD</button>
    <form id="product-list-form" method="post" action="delete_products.php">
    
    <button id="delete-product-btn">MASS DELETE</button>
    </div>
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

<footer>
<hr>
    <p class="footerP">Scandiweb Test assignment</p>
  </footer>
  <script src="product_list.js"></script>
</body>
</html>