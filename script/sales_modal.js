const modal = document.getElementById('itemModal');
const itemDisplay = document.getElementById('selected_item_display');
const itemHiddenId = document.getElementById('item_id_hidden');
const itemPriceHidden = document.getElementById('item_price_hidden');

// --- Modal Controls ---
function openItemModal() {
    modal.classList.remove('hidden');
    modal.classList.add('flex'); // Add flex to center content
}

function closeItemModal() {
    modal.classList.remove('flex');
    modal.classList.add('hidden');
}

// --- Item Selection Logic ---
window.selectItem = function(id, name, price) {
    // 1. Populate the hidden fields in the main form
    itemHiddenId.value = id;
    itemPriceHidden.value = price; // This is crucial for backend calculation
    
    // 2. Update the display field with the chosen item's name and price
    const formattedPrice = new Intl.NumberFormat('en-PH', { 
        style: 'currency', 
        currency: 'PHP' 
    }).format(price);
    
    itemDisplay.value = `${name} (${formattedPrice})`;
    
    // 3. Close the modal
    closeItemModal();
};

// Optional: Close modal if user clicks outside of it
modal.addEventListener('click', function(e) {
    if (e.target === modal) {
        closeItemModal();
    }
});

// Add sales_modal.js to your <head>
// <script src="../../script/sales_modal.js" defer></script>