const addProductButton = document.getElementById('add-product-btn');

addProductButton.addEventListener('click', () => { window.location.href = 'add_product.php';});


const deleteProductButton = document.getElementById('delete-product-btn');

deleteProductButton.addEventListener('click', () => {
  const productListForm = document.getElementById('product-list-form');

  const deleteCheckboxes = document.querySelectorAll('.delete-checkbox');


  let isAnyChecked = false;
  deleteCheckboxes.forEach(checkbox => {
    if (checkbox.checked) {
      isAnyChecked = true;
    }
  });

  if (!isAnyChecked) {
    event.preventDefault(); 
    // alert('Please select at least one product to delete.');

    
  }
 
});