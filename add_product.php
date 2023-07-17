<?php
@include 'config.php';
error_reporting(E_ERROR | E_PARSE);
// Abstract class for the main product logic
abstract class Product {
  
  protected $sku;
  protected $name;
  protected $price;

  protected $product_type;

  public function __construct($sku, $name, $price, $product_type) {
    $this->sku = $sku;
    $this->name = $name;
    $this->price = $price;
    $this->product_type = $product_type;
  }

  abstract public function getAttributes();

  abstract public function save();
}

// DVD product class
class DVD extends Product {
  protected $size;

  public function __construct($sku, $name, $price,$product_type, $size) {
    parent::__construct($sku, $name, $price, $product_type);
    $this->size = $size;
  }

  public function getAttributes() {
    return [
      'Size' => $this->size,
    ];
  }
  public function save() {
    global $conn;

    try{
    $insert = "INSERT INTO products (sku, name, price, attribute_name, size) 
      VALUES ('$this->sku', '$this->name', '$this->price', '$this->product_type', '$this->size')";
    $upload = mysqli_query($conn, $insert);
    if ($upload) {
      $message[] = 'New product added successfully';
    } else {
      $message[] = 'Error adding the product: ' . mysqli_error($conn);
    }
  }catch(Exception $e){
    $message[] = 'An error occurred: ' . $e->getMessage(); 
}
  }

}

// Book product class
class Book extends Product {
  protected $weight;

  public function __construct($sku, $name, $price,$product_type, $weight) {
    parent::__construct($sku, $name, $price,$product_type);
    $this->weight = $weight;
  }

  public function getAttributes() {
    return [
      'Weight' => $this->weight,
    ];
  }

  public function save() {

    try{
    global $conn;
    $insert = "INSERT INTO products (sku, name, price, attribute_name, weight) 
      VALUES ('$this->sku', '$this->name', '$this->price', '$this->product_type', '$this->weight')";
    $upload = mysqli_query($conn, $insert);
    if ($upload) {
      $message[] = 'New product added successfully';
    } else {
      $message[] = 'Error adding the product: ' . mysqli_error($conn);
    }
  }catch(Exception $e){
    $message[] = 'An error occurred: ' . $e->getMessage(); 
}
  }

}
// Furniture product class
class Furniture extends Product {
  protected $height;
  protected $width;
  protected $length;

  public function __construct($sku, $name, $price,$product_type, $height, $width, $length) {
    parent::__construct($sku, $name, $price,$product_type);
    $this->height = $height;
    $this->width = $width;
    $this->length = $length;
  }

  public function getAttributes() {
    return [
      'Height' => $this->height,
      'Width' => $this->width,
      'Length' => $this->length,
    ];
  }

  public function save() {
    global $conn;

    try{
    
    $insert = "INSERT INTO products (sku, name, price, attribute_name, height, width, length) 
      VALUES ('$this->sku', '$this->name', '$this->price', '$this->product_type', '$this->height','$this->width','$this->length')";
    $upload = mysqli_query($conn, $insert);
    if ($upload) {
      $message[] = 'New product added successfully';
    } else {
      $message[] = 'Error adding the product: ' . mysqli_error($conn);
    }
  }catch(Exception $e){
         $message[] = 'An error occurred: ' . $e->getMessage(); 
     }
  }
// }
}

// Usage example
if (isset($_POST['saveButton'])) {
  $product_sku = $_POST['sku'];
  $product_name = $_POST['name'];
  $product_price = $_POST['price'];
  $product_type = $_POST['productType'];

  // Create the appropriate product object based on the selected type
  $product = null;
  $validationErrors = [];

  if ($product_type === 'DVD') {
    $size = $_POST['sizeInput'];

    if (empty($size)) {
      $validationErrors[] = 'Wrong information: Size is required.';
    }

    $product = new DVD($product_sku, $product_name, $product_price, $product_type, $size);
  } elseif ($product_type === 'Book') {
    $weight = $_POST['weightInput'];

    if (empty($weight)) {
      $validationErrors[] = 'Wrong information: Weight is required.';
    }

    $product = new Book($product_sku, $product_name, $product_price, $product_type, $weight);
  } elseif ($product_type === 'Furniture') {
    $height = $_POST['heightInput'];
    $width = $_POST['widthInput'];
    $length = $_POST['lengthInput'];

    if (empty($height) || empty($width) || empty($length)) {
      $validationErrors[] = 'Wrong information: Height, width, and length are required.';
    }

    $product = new Furniture($product_sku, $product_name, $product_price, $product_type, $height, $width, $length);
  } else {
    $validationErrors[] = 'Invalid product type selected.';
  }

  if ($product) {
    if (!empty($validationErrors)) {
      $message[] = 'Validation error(s): ' . implode(', ', $validationErrors);
    } else {
      $attributes = $product->getAttributes();
      $product->save();
      header("Location: product_list.php");
      exit();
    }
  } else {
    $message[] = 'Invalid product type selected.';
  }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="add_product.css">
  <title>ADD PRODUCT</title>
</head>
<header>
  <h1>Product Add</h1>
  <hr>
</header>
<body>
  <?php
  if(isset($message)){
    foreach($message as $message){
      echo '<span class="message">' .$message. '</span>';
    }
  }
  ?>
  <div class="container">
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <div class="element sku">
        <label for="sku">SKU:    </label>
        <input placeholder="SKU" type="text" class="box" name="sku" required>
      </div>

      <div class="element name">
        <label for="name">Name: </label>
        <input placeholder="Name" name="name" type="text"required/>
      </div>

      <div class="element price">
        <label for="price">Price($): </label>
        <input placeholder="Price in $" type="text" name="price"  required>
      </div>

      <div class="element type">
        <label for="productType">Type switcher: </label>
        <select id="productType" name="productType" required>
          <option value="typeSwitcher">Type switcher</option>
          <option id="DVD" name="DVD" value="DVD">DVD</option>
          <option id="Book" name="Book" value="Book">Book</option>
          <option id="Furniture" name="Furniture" value="Furniture">Furniture</option>
        </select>
      </div>

      <div id="attribute-input-container" class="element">
        <p>Provide a Product Type.</p>
      </div>
      <div class="button-container">
        <input type="submit" id="saveButton" name="saveButton" value="Save">
        <button id="cancelButton">Cancel</button>
      </div>
    </form>
  </div>

  <footer>
    <hr>
    <p class="footerP">Scandiweb Test assignment</p>
  </footer>
  <script src="add-product.js"></script>
</body>
</html>
