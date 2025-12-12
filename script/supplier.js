
const supplierEditModal = document.getElementById("supplierEditModal");
const supplierEditForm = document.getElementById("supplier_edit_form");

// --- Modal Controls ---
        function openEditSupplierModal() {
            const modal = document.getElementById('supplierEditModal');
            const modalContent = modal.querySelector('.modal-content-animation');

            modal.style.opacity = '0'; 
            modalContent.style.animation = 'none';
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            void modal.offsetWidth; 
            setTimeout(() => {
                modal.style.opacity = '1';
                modalContent.style.animation = 'slideInUp 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards';
            }, 10);
        }

        function closeEditSupplierModal() {
            const modal = document.getElementById('supplierEditModal');
            const modalContent = modal.querySelector('.modal-content-animation');

            modal.style.opacity = '0';
            modalContent.style.animation = 'none';

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');

                // Reset modal state
                document.getElementById('supplier_edit_form').classList.add('hidden'); 
                document.getElementById('edit_supplier_select').value = "";
            }, 300); 
        }

        function loadSupplierDetails(supplierId) {
            const form = document.getElementById('supplier_edit_form');
            if (supplierId) {
                const select = document.getElementById('edit_supplier_select');
                const selectedOption = select.options[select.selectedIndex];
                
                document.getElementById('edit_supplier_id').value = supplierId;
                document.getElementById('edit_supplier_name').value = selectedOption.getAttribute('data-name');
                document.getElementById('edit_supplier_phone').value = selectedOption.getAttribute('data-phone');
                
                form.classList.remove('hidden');
            } else {
                form.classList.add('hidden');
            }
        }

        window.confirmDelete = function (supplierId) {
        Swal.fire({
            title: "Confirm Deletion",
            text: "Are you sure you want to delete this supplier? This action cannot be undone.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#dc3545",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Yes",
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("delete_supplier_id").value = supplierId;
                Swal.fire({
                    title: "Processing...",
                    text: "Removing supplier .",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    },
                });

                setTimeout(() => {
                    document.getElementById("deleteSupplierForm").submit();
                }, 500);
            }
        });
    };

    if (window.location.search.includes("deleted=1")) {
        Swal.fire({
            icon: "success",
            title: "Deleted!",
            text: "The supplier has been successfully removed.", // Updated text
            showConfirmButton: false,
            timer: 1500,
        });
    } else if (window.location.search.includes("edited=1")) {
        Swal.fire({
            icon: "success",
            title: "Updated!", // Changed title for clarity
            text: "The supplier has been successfully updated.", // Updated text
            showConfirmButton: false,
            timer: 1500,
        });
    }

    setTimeout(() => {
        if (window.location.search) {
            window.history.replaceState(null, null, window.location.pathname);
        }
    }, 500);
