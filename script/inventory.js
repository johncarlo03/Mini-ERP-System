document.addEventListener("DOMContentLoaded", function () {
    const submitBtn = document.getElementById("submitBtn");
    const deleteBtn = document.getElementById("deleteBtn");
    const resetBtn = document.getElementById("resetBtn");

    const fileInput = document.getElementById("product_image_upload");
    const existingPathInput = document.getElementById("existing_image_path");
    const imagePreview = document.getElementById("current_image_preview");
    const previewContainer = document.getElementById("image_preview_container");
    
    // --- FILL FORM LOGIC ---
    window.fillForm = function (id, name, description, price, imagePath, qty) {
        document.getElementById("product_id").value = id;
        document.getElementById("item_name").value = name;
        document.getElementById("description").value = description;
        document.getElementById("item_price").value = price;
        document.getElementById("qty").value = qty;
        document.getElementById("delete_product_id").value = id;
        existingPathInput.value = imagePath;

        // Handle Image Preview
        if (imagePath && imagePath !== "null") {
            imagePreview.src = imagePath;
            previewContainer.style.display = "block";
        } else {
            previewContainer.style.display = "none";
        }
        fileInput.value = "";

        submitBtn.textContent = "Update Item";
        submitBtn.classList.remove("bg-blue-600");
        submitBtn.classList.add("bg-indigo-600");

        deleteBtn.hidden = false;
        resetBtn.hidden = false;
    };

    // --- RESET FORM LOGIC ---
    window.resetForm = function () {
        document.getElementById("delete_product_id").value = "";
        document.getElementById("product_id").value = "";
        document.getElementById("item_name").value = "";
        document.getElementById("item_price").value = "";
        document.getElementById("description").value = "";
        document.getElementById("qty").value = "";

        fileInput.value = "";
        existingPathInput.value = "";
        previewContainer.style.display = "none";

        submitBtn.textContent = "Add Item to Stock";
        submitBtn.classList.remove("bg-indigo-600");
        submitBtn.classList.add("bg-blue-600");

        deleteBtn.hidden = true;
        resetBtn.hidden = true;
    };

    window.confirmDelete = function (itemId) {
        Swal.fire({
            title: "Confirm Deletion",
            text: "Are you sure you want to delete this inventory item? This action cannot be undone.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes, Delete It!",
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("delete_product_id").value = itemId;
                Swal.fire({
                    title: "Processing...",
                    text: "Removing item from inventory.",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });

                setTimeout(() => {
                    document.getElementById("deleteForm").submit();
                }, 500);
            }
        });
    };

    if (window.location.search.includes("deleted=1")) {
        Swal.fire({
            icon: "success",
            title: "Deleted!",
            text: "The inventory item has been successfully removed.", // Updated text
            showConfirmButton: false,
            timer: 1500,
        });
    } else if (window.location.search.includes("edited=1")) {
        Swal.fire({
            icon: "success",
            title: "Updated!", // Changed title for clarity
            text: "The inventory item has been successfully updated.", // Updated text
            showConfirmButton: false,
            timer: 1500,
        });
    }

    setTimeout(() => {
        if (window.location.search) {
            window.history.replaceState(null, null, window.location.pathname);
        }
    }, 500);

});