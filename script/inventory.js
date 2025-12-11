document.addEventListener("DOMContentLoaded", function () {
  const submitBtn = document.getElementById("submitBtn");
  const deleteBtn = document.getElementById("deleteBtn");
  const resetBtn = document.getElementById("resetBtn");

  // New DOM elements
  const fileInput = document.getElementById("product_image_upload");
  const existingPathInput = document.getElementById("existing_image_path");
  const imagePreview = document.getElementById("current_image_preview");
  const previewContainer = document.getElementById("image_preview_container");

  // --- FILL FORM FUNCTION (FIXED) ---
  window.fillForm = function (id, name, description, price, imagePath, qty) {
    document.getElementById("product_id").value = id;
    document.getElementById("item_name").value = name;
    document.getElementById("description").value = description;
    document.getElementById("item_price").value = price;
    document.getElementById("qty").value = qty;
    document.getElementById("delete_product_id").value = id;

    // FIX 1: Set the hidden path input (for PHP update logic)
    existingPathInput.value = imagePath;

    // FIX 2: Handle Image Preview
    if (imagePath && imagePath !== "null") {
      // Check if a path exists
      imagePreview.src = imagePath;
      previewContainer.style.display = "block";
    } else {
      previewContainer.style.display = "none";
    }

    // FIX 3: Clear file input for security (user must select new file if they want change)
    fileInput.value = "";

    submitBtn.textContent = "Update Item";
    submitBtn.classList.remove("bg-blue-600");
    submitBtn.classList.add("bg-indigo-600");

    deleteBtn.hidden = false;
    resetBtn.hidden = false;
  };

  // --- RESET FORM FUNCTION (CLEANED UP) ---
  window.resetForm = function () {
    document.getElementById("delete_product_id").value = "";
    document.getElementById("product_id").value = "";
    document.getElementById("item_name").value = "";
    document.getElementById("item_price").value = "";
    document.getElementById("description").value = "";
    document.getElementById("qty").value = "";

    // Reset image paths and hide preview
    fileInput.value = "";
    existingPathInput.value = "";
    previewContainer.style.display = "none";

    submitBtn.textContent = "Add Item to Stock";
    submitBtn.classList.remove("bg-indigo-600");
    submitBtn.classList.add("bg-blue-600");

    deleteBtn.hidden = true;
    resetBtn.hidden = true;
  };

  // ... rest of your JavaScript (confirmDelete, sidebar, etc.) ...
});
