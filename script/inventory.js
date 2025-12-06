document.addEventListener("DOMContentLoaded", function () {
  const submitBtn = document.getElementById("submitBtn");
  const deleteBtn = document.getElementById("deleteBtn");
  const resetBtn = document.getElementById("resetBtn");

  window.fillForm = function (id, name, description, qty) {
    document.getElementById("product_id").value = id;
    document.getElementById("item_name").value = name;
    document.getElementById("description").value = description;
    // document.getElementById('product-price').value = price;
    document.getElementById("qty").value = qty;
    document.getElementById("delete_product_id").value = id;

    submitBtn.textContent = "Update Item";
    submitBtn.classList.remove("bg-blue-600");
    submitBtn.classList.add("bg-indigo-600");

    deleteBtn.hidden = false;
    resetBtn.hidden = false;
  };

  window.resetForm = function () {
    document.getElementById("delete_product_id").value = "";
    document.getElementById("product_id").value = "";
    document.getElementById("item_name").value = "";
    document.getElementById("description").value = "";
    document.getElementById("qty").value = "";

    submitBtn.textContent = "Add Item to Stock";
    submitBtn.classList.remove("bg-indigo-600");
    submitBtn.classList.add("bg-blue-600");

    deleteBtn.hidden = true;
    resetBtn.hidden = true;
  };
});
