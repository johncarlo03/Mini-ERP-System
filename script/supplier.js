
const supplierEditModal = document.getElementById("supplierEditModal");
const supplierEditForm = document.getElementById("supplier_edit_form");

// --- Modal Controls ---
function openEditSupplierModal() {
  supplierEditModal.classList.remove("hidden");
  supplierEditModal.classList.add("flex");
  // Ensure form is hidden upon opening
  supplierEditForm.classList.add("hidden");
  document.getElementById("edit_supplier_select").value = ""; // Reset dropdown selection
}

function closeEditSupplierModal() {
  supplierEditModal.classList.remove("flex");
  supplierEditModal.classList.add("hidden");
}

// --- Detail Loading Function ---
window.loadSupplierDetails = function (supplierId) {
  if (!supplierId) {
    supplierEditForm.classList.add("hidden");
    return;
  }

  // Find the selected option element using the ID
  const select = document.getElementById("edit_supplier_select");
  const selectedOption = select.querySelector(`option[value="${supplierId}"]`);

  if (selectedOption) {
    // Read data directly from the HTML data attributes
    const name = selectedOption.dataset.name;
    const phone = selectedOption.dataset.phone;
    // Populate the hidden ID and input fields
    document.getElementById("edit_supplier_id").value = supplierId;
    document.getElementById("edit_supplier_name").value = name;
    document.getElementById("edit_supplier_phone").value = phone;

    // Show the form
    supplierEditForm.classList.remove("hidden");
  }
};