document.addEventListener("DOMContentLoaded", function () {
  const submitBtn = document.getElementById("submitBtn");
  const deleteBtn = document.getElementById("deleteBtn");
  const resetBtn = document.getElementById("resetBtn");

  window.fillForm = function (id, name, description, price, qty) {
    document.getElementById("product_id").value = id;
    document.getElementById("item_name").value = name;
    document.getElementById("description").value = description;

    document.getElementById('item_price').value = price;

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
    document.getElementById('item_price').value = "";
    document.getElementById("description").value = "";
    document.getElementById("qty").value = "";

    submitBtn.textContent = "Add Item to Stock";
    submitBtn.classList.remove("bg-indigo-600");
    submitBtn.classList.add("bg-blue-600");

    deleteBtn.hidden = true;
    resetBtn.hidden = true;
  };

  window.confirmDelete = function (itemId) {
    Swal.fire({
      title: "Are you sure?",
      text: "You won't be able to revert this!",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#3085d6",
      confirmButtonText: "Yes, delete it!",
    }).then((result) => {
      if (result.isConfirmed) {
        // 1. Set the hidden form's ID input value
        document.getElementById("delete_product_id").value = itemId;

        Swal.fire({
          title: "Deleting...",
          text: "The item is being removed.",
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          },
        });

        setTimeout(() => {
          document.getElementById("deleteForm").submit();
        }, 800);
      }
    });
  };

  if (window.location.search.includes("deleted=1")) {
    Swal.fire({
        icon: "success",
        title: "Deleted!",
        text: "The item has been successfully removed.",
        showConfirmButton: false,
        timer: 1500
    });
}

});
