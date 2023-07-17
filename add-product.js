
class Product {
  constructor() {
    this.attributeInputContainer = document.getElementById("attribute-input-container");
  }

  renderAttributes() {
 
    this.attributeInputContainer.innerHTML = "";

   
    const attributes = this.getAttributes();
    attributes.forEach(attribute => {
      const { label, placeholder, type, name } = attribute;
      const inputElement = document.createElement("input");
      inputElement.placeholder = placeholder;
      inputElement.type = type;
      inputElement.required = true;
      inputElement.name = name;

      const labelElement = document.createElement("label");
      labelElement.textContent = label;

      this.attributeInputContainer.appendChild(labelElement);
      this.attributeInputContainer.appendChild(inputElement);
    });
  }

  getAttributes() {

    return [];
  }
}

class DVDProduct extends Product {
  getAttributes() {
    return [
      {

        name:"sizeInput",
        label: "Size (in MB):",
        placeholder: "eg. 700 MB",
        type: "number"
        
      }
    ];
  }
}

class BookProduct extends Product {
  getAttributes() {
    return [
      {
        name: "weightInput",
        label: "Weight (in Kg):",
        placeholder: "eg. 2 KG",
        type: "number"
      }
    ];
  }
}

class FurnitureProduct extends Product {
  getAttributes() {
    return [
      {
        name : "heightInput",
        label: "Height (CM):",
        placeholder: "eg. 24 CM",
        type: "number"
      },
      {
        
        label: "Width (CM):",
        name : "widthInput",
        placeholder: "eg. 45 CM",
        type: "number"
      },
      {
        name : "lengthInput",
        label: "Length (CM):",
        placeholder: "eg. 15 CM",
        type: "number"
      }
    ];
  }
}

// Event listener for product type change
const typeSwitcher = document.getElementById("productType");
let currentProduct;

typeSwitcher.addEventListener("change", () => {
  const selectedOption = typeSwitcher.options[typeSwitcher.selectedIndex].value;


  if (selectedOption === "DVD") {
    currentProduct = new DVDProduct();
  } else if (selectedOption === "Book") {
    currentProduct = new BookProduct();
  } else if (selectedOption === "Furniture") {
    currentProduct = new FurnitureProduct();
  }
  currentProduct.renderAttributes();
});

document.getElementById("cancelButton").onclick = function () {location.href = "product_list.php";};
