document.addEventListener('DOMContentLoaded', () => {
    const editButtons = document.querySelectorAll('.edit-btn1');
    const deleteButtons = document.querySelectorAll('.delete-btn1');
    const editModal = document.getElementById('edit-patient-modal');
    const editForm = document.getElementById('edit-patient-form');

    // Edit Patient Modal Functionality
    editButtons.forEach(button => {
        button.addEventListener('click', () => {
            const patientRow = button.closest('tr');
            const patientId = button.dataset.id;
    
            // Populate modal with current patient details
            document.getElementById('edit-patient-id').value = patientId;
            document.getElementById('edit-patient-name').value = patientRow.querySelector('td:nth-child(1)').textContent;
            document.getElementById('edit-patient-age').value = patientRow.querySelector('td:nth-child(2)').textContent;
            document.getElementById('edit-patient-birthday').value = patientRow.querySelector('td:nth-child(3)').textContent;
            document.getElementById('edit-patient-gender').value = patientRow.querySelector('td:nth-child(4)').textContent;
            document.getElementById('edit-patient-email').value = patientRow.querySelector('td:nth-child(5)').textContent;
            document.getElementById('edit-patient-address').value = patientRow.querySelector('td:nth-child(6)').textContent;
            document.getElementById('edit-patient-condition').value = patientRow.querySelector('td:nth-child(7)').textContent;
            document.getElementById('edit-patient-contact').value = patientRow.querySelector('td:nth-child(8)').textContent;
    
            // Show the modal
            editModal.style.display = 'block';
        });
    });
    

    // Close Modal Function
    window.closeEditPatientModal = () => {
        editModal.style.display = 'none';
    };


    editForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Validate inputs before submitting (optional, but recommended)
        const name = document.getElementById('edit-patient-name').value.trim();
        if (!name) {
            alert('Please enter a valid name');
            return;
        }
    
        const formData = new FormData(editForm);
        formData.append('action', 'update_patient');
        
        fetch('../admin-class.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Patient updated successfully!');
                location.reload();  // Reload page to see the updated patient data
            } else {
                alert('Error updating patient: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the patient. Please try again.');
        });
    });
    
    
    // Delete Patient Functionality
    deleteButtons.forEach(button => {
        button.addEventListener('click', () => {
            const patientId = button.dataset.id;
            
            if (confirm('Are you sure you want to delete this patient?')) {
                const formData = new FormData();
                formData.append('action', 'delete_patient');
                formData.append('patient_id', patientId);

                fetch('../admin-class.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Patient deleted successfully!');
                        button.closest('tr').remove(); // Remove the deleted patient row from the table
                    } else {
                        alert('Error deleting patient: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the patient.');
                });
            }
        });
    });

});

document.addEventListener('DOMContentLoaded', () => {
    flatpickr("#patient-birthday", {
        dateFormat: "Y-m-d",  
        maxDate: "today",     
        placeholder: "Select Birthday"  
    });
});