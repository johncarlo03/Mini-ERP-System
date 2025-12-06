
document.addEventListener('DOMContentLoaded', function() {
    const submitBtn = document.getElementById('submitBtn');
    const resetBtn = document.getElementById('resetBtn');
    const deleteBtn = document.getElementById('deleteBtn');
    const pwInput = document.getElementById('pw');
    const rpwInput = document.getElementById('rpw');

    window.fillForm = function(id, name, email, role) {
        document.getElementById('id').value = id;
        document.getElementById('name').value = name;
        document.getElementById('email').value = email;
        document.getElementById('role').value = role;
        document.getElementById('delete_user_id').value = id;

        submitBtn.textContent = 'Update Staff Account';
        submitBtn.classList.remove('bg-blue-600');
        submitBtn.classList.add('bg-indigo-600');

        deleteBtn.hidden = false;
        resetBtn.hidden = false;
        
        pwInput.required = false;
        rpwInput.required = false;
        pwInput.placeholder = "Password (Leave blank to keep existing)";
    }

    window.resetForm = function() {
        document.getElementById('id').value = '';
        document.getElementById('name').value = '';
        document.getElementById('email').value = '';
        document.getElementById('role').value = '';
        document.getElementById('delete_user_id').value = '';

        submitBtn.textContent = 'Create Staff Account';
        submitBtn.classList.remove('bg-indigo-600');
        submitBtn.classList.add('bg-blue-600');
        
        deleteBtn.hidden = true;
        resetBtn.hidden = true;
        
        pwInput.required = true;
        rpwInput.required = true;
        pwInput.placeholder = "Password";
    }
});