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

const filterButton = document.getElementById('filter-btn');
filterButton.addEventListener('click', () => {
  const searchInput = document.getElementById('search-input').value.trim();
  const categoryFilter = document.getElementById('category-filter').value;
  const priceFilter = document.getElementById('price-filter').value;
  
  // Construct the URL with the filter parameters
  let url = 'product_list.php';
  if (searchInput) {
    url += `?search=${encodeURIComponent(searchInput)}`;
  }
  if (categoryFilter) {
    url += `&category=${encodeURIComponent(categoryFilter)}`;
  }
  if (priceFilter) {
    url += `&price=${encodeURIComponent(priceFilter)}`;
  }
  
  // Redirect to the updated URL
  window.location.href = url;
});