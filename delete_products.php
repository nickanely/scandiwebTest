<?php
@include 'config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  if (isset($_POST['deleteSkus'])) {

    $deleteSkus = $_POST['deleteSkus'];

    foreach ($deleteSkus as $sku) {

      $deleteQuery = "DELETE FROM products WHERE sku = '$sku'";
      mysqli_query($conn, $deleteQuery);
    }

  
    header("Location: product_list.php");
    exit();
  }

}
?>
