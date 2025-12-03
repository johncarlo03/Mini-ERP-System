 function fillForm(id, name, description, qty) {
    document.getElementById('product_id').value = id;
    document.getElementById('item_name').value = name;
    document.getElementById('description').value = description;
    // document.getElementById('product-price').value = price;
    document.getElementById('qty').value = qty;
    document.getElementById('delete_product_id').value = id;
    document.getElementById('deleteBtn').disabled = false;
    document.getElementById('resetBtn').disabled = false;
    }

    function resetForm() {
    document.getElementById('delete_product_id').value = '';
    document.getElementById('product_id').value = '';
    document.getElementById('item_name').value = '';
    document.getElementById('description').value = '';
    document.getElementById('qty').value = '';
    document.getElementById('deleteBtn').disabled = true;
    document.getElementById('resetBtn').disabled = true;
    }