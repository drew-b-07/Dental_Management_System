        // CALENDAR
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure calendar element exists
            var calendarEl = document.getElementById('calendar');
            if (!calendarEl) {
                console.error('Calendar element not found');
                return;
            }

            // Initialize FullCalendar
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 'auto',
                contentHeight: 'auto',
                expandRows: true,
                aspectRatio: 1.35,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                },
                events: {
                    url: '../fetch-appointments.php',
                    method: 'GET',
                    failure: function(errorObj) {
                        console.error('Event fetch error:', errorObj);
                        alert('There was an error while fetching appointments.');
                    }
                },
                eventColor: '#3788d8',
                eventTextColor: 'white',
                eventDisplay: 'block',
                dayMaxEvents: true,
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: true
                },
                eventClick: function(info) {
                    info.jsEvent.preventDefault();

                    const encodedName = encodeURIComponent(info.event.title);
                    fetch(`../get-appointment-details.php?name=${encodedName}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Failed to fetch appointment details');
                            }
                            return response.json();
                        })
                        .then(appointmentDetails => {
                            const modalBody = document.getElementById('appointmentDetails');
                            modalBody.innerHTML = `
                                <p><strong>Name:</strong> ${appointmentDetails.fullname || 'N/A'}</p>
                                <p><strong>Appointment:</strong> ${appointmentDetails.pref_appointment || 'N/A'}</p>
                                <p><strong>Phone Number:</strong> ${appointmentDetails.phone_number || 'N/A'}</p>
                                <p><strong>Additional Information:</strong> ${appointmentDetails.additional_info || 'No additional information'}</p>
                                <input type="hidden" id="appointmentId" value="${appointmentDetails.id}">
                            `;

                            const appointmentModal = new bootstrap.Modal(document.getElementById('appointmentModal'));
                            appointmentModal.show();
                        })
                        .catch(error => {
                            const modalBody = document.getElementById('appointmentDetails');
                            modalBody.innerHTML = `
                                <div class="alert alert-danger">
                                    <p>Unable to retrieve appointment details.</p>
                                    <p>Error: ${error.message}</p>
                                </div>
                            `;
                            const appointmentModal = new bootstrap.Modal(document.getElementById('appointmentModal'));
                            appointmentModal.show();
                        });
                },
                viewDidMount: function(view) {
                    calendar.updateSize();
                },
                eventContent: function(arg) {
                    return {
                        html: `
                            <div class="fc-event-main">
                                <div class="fc-event-time">${arg.timeText}</div>
                                <div class="fc-event-title">${arg.event.title}</div>
                            </div>
                        `
                    };
                },
                windowResize: function(view) {
                    calendar.updateSize();
                }
            });

            calendar.render();

            setTimeout(() => {
                calendar.updateSize();
            }, 100);

            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function() {
                    if (this.dataset.section === 'appointments') {
                        setTimeout(() => {
                            calendar.updateSize();
                        }, 50);
                    }
                });
            });
        });

        // USER PART
        document.addEventListener('DOMContentLoaded', function() {
            // Handle edit buttons in the user section
            const editButtons = document.querySelectorAll('#settings .edit-btn');
            const editModal = document.getElementById('edit-user-modal');
            const editPatientModal = document.getElementById('edit-patient-modal');

            editButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Close patient modal if it's open
                    if (editPatientModal) {
                        editPatientModal.style.display = 'none';
                    }

                    const userId = this.getAttribute('data-id');
                    const row = this.closest('tr');
                    
                    // Populate modal with current row data
                    document.getElementById('edit-user-id').value = userId;
                    document.getElementById('edit-user-name').value = row.cells[0].textContent.trim();
                    document.getElementById('edit-user-email').value = row.cells[1].textContent.trim();
                    document.getElementById('edit-user-username').value = row.cells[2].textContent.trim();
                    document.getElementById('edit-user-verify-status').value = row.cells[5].textContent.trim().toLowerCase();

                    // Show the modal
                    const userEditModal = new bootstrap.Modal(editModal);
                    userEditModal.show();
                });
            });

            // Close Modal Function
            window.closeEditUserModal = () => {
                editModal.style.display = 'none';
            };

            // Handle form submission
            const editForm = document.getElementById('edit-user-form');
            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                formData.append('action', 'update_user');
                
                fetch('../admin-class.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('User updated successfully');
                        location.reload();
                        
                        const userId = document.getElementById('edit-user-id').value;
                        const row = document.querySelector(`button[data-id="${userId}"]`).closest('tr');
                        
                        row.cells[0].textContent = formData.get('fullname');
                        row.cells[1].textContent = formData.get('email');
                        row.cells[2].textContent = formData.get('username');
                        row.cells[5].textContent = formData.get('verify_status').charAt(0).toUpperCase() + formData.get('verify_status').slice(1);

                        // Close the modal
                        const userEditModal = bootstrap.Modal.getInstance(editModal);
                        userEditModal.hide();
                    } else {
                        alert('Error updating patient: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the patient. Please try again.');
                });
            });

            // Optional: Handle delete buttons in the user section
            const deleteButtons = document.querySelectorAll('#settings .delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const userId = this.getAttribute('data-id');
                    
                    if (confirm('Are you sure you want to delete this user?')) {
                        const formData = new FormData();
                        formData.append('action', 'delete_user');
                        formData.append('user_id', userId);

                        fetch('../admin-class.php', {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('User deleted successfully!');
                                button.closest('tr').remove(); // Remove the deleted user row from the table
                            } else {
                                alert('Error deleting user: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while deleting the user.');
                        });
                    }
                });
            });
        });

        // MARK AS DONE
        document.getElementById('markDoneBtn').addEventListener('click', function() {
            const appointmentId = document.getElementById('appointmentId').value;
            
            if (!appointmentId) {
                alert('No appointment selected');
                return;
            }

            // Use AJAX to mark the appointment as done
            fetch('../main.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=markdone&id=${appointmentId}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Appointment marked as done successfully');
                    // Reload the page or update the calendar
                    location.reload();
                } else {
                    alert('Failed to mark appointment as done');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while marking the appointment as done');
            });
        });

        // PASSWORD
        document.addEventListener('DOMContentLoaded', function() {
            const editForm = document.getElementById('edit-user-form');
            const passwordInput = document.getElementById('edit-user-password');

            editForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Create FormData object
                const formData = new FormData(this);
                
                if (passwordInput.value.trim() === '') {
                    formData.delete('password');
                }
                
                formData.append('action', 'update_user');
                
                const submitButton = this.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.textContent = 'Updating...';

                fetch('../admin-class.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    
                    if (data.success) {
                        alert('User updated successfully');
                        location.reload();
                    } else {
                        alert(data.message || 'Error updating user');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the user');
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Update User';
                });
            });

            // Password validation
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                if (password && password.length < 6) {
                    this.setCustomValidity('Password must be at least 6 characters long');
                } else {
                    this.setCustomValidity('');
                }
            });
        });