const modal = document.getElementById("itemModal");
const itemDisplay = document.getElementById("selected_item_display");
const itemHiddenId = document.getElementById("item_id_hidden");
const itemPriceHidden = document.getElementById("item_price_hidden");

// --- Modal Controls ---
function openItemModal() {
  modal.classList.remove("hidden");
  modal.classList.add("flex"); // Add flex to center content
}

function closeItemModal() {
  modal.classList.remove("flex");
  modal.classList.add("hidden");
}

// --- Item Selection Logic ---
window.selectItem = function (id, name, price) {
  // 1. Populate the hidden fields in the main form
  itemHiddenId.value = id;
  itemPriceHidden.value = price; // This is crucial for backend calculation

  // 2. Update the display field with the chosen item's name and price
  const formattedPrice = new Intl.NumberFormat("en-PH", {
    style: "currency",
    currency: "PHP",
  }).format(price);

  itemDisplay.value = `${name} (${formattedPrice})`;

  // 3. Close the modal
  closeItemModal();
};

// Optional: Close modal if user clicks outside of it
modal.addEventListener("click", function (e) {
  if (e.target === modal) {
    closeItemModal();
  }
});

const customerEditModal = document.getElementById("customerEditModal");
const customerEditForm = document.getElementById("customer_edit_form");

// --- Modal Controls ---
function openEditCustomerModal() {
  customerEditModal.classList.remove("hidden");
  customerEditModal.classList.add("flex");
  // Ensure form is hidden upon opening
  customerEditForm.classList.add("hidden");
  document.getElementById("edit_customer_select").value = ""; // Reset dropdown selection
}

function closeEditCustomerModal() {
  customerEditModal.classList.remove("flex");
  customerEditModal.classList.add("hidden");
}

// --- Detail Loading Function ---
window.loadCustomerDetails = function (customerId) {
  if (!customerId) {
    customerEditForm.classList.add("hidden");
    return;
  }

  // Find the selected option element using the ID
  const select = document.getElementById("edit_customer_select");
  const selectedOption = select.querySelector(`option[value="${customerId}"]`);

  if (selectedOption) {
    // Read data directly from the HTML data attributes
    const name = selectedOption.dataset.name;
    const phone = selectedOption.dataset.phone;
    // Populate the hidden ID and input fields
    document.getElementById("edit_customer_id").value = customerId;
    document.getElementById("edit_customer_name").value = name;
    document.getElementById("edit_customer_phone").value = phone;

    // Show the form
    customerEditForm.classList.remove("hidden");
  }
};

window.confirmDelete = function (customerId) {
    Swal.fire({
      title: "Confirm Deletion",
      text: "Are you sure you want to delete this customer? This action cannot be undone.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#dc3545",
      cancelButtonColor: "#6c757d",
      confirmButtonText: "Yes",
    }).then((result) => {
      if (result.isConfirmed) {
        document.getElementById("delete_customer_id").value = customerId;
        Swal.fire({
          title: "Processing...",
          text: "Removing customer.",
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          },
        });

        setTimeout(() => {
          document.getElementById("deleteCustomerForm").submit();
        }, 500);
      }
    });
  };

  if (window.location.search.includes("deleted=1")) {
    Swal.fire({
      icon: "success",
      title: "Deleted!",
      text: "The customer has been successfully removed.", // Updated text
      showConfirmButton: false,
      timer: 1500,
    });
  } else if (window.location.search.includes("edited=1")) {
    Swal.fire({
      icon: "success",
      title: "Updated!", // Changed title for clarity
      text: "The customer has been successfully updated.", // Updated text
      showConfirmButton: false,
      timer: 1500,
    });
  }

  setTimeout(() => {
    if (window.location.search) {
      window.history.replaceState(null, null, window.location.pathname);
    }
  }, 500);
