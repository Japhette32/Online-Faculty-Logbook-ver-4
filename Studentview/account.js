// Global variables
let notifications = [];
let currentRegistrationId = null;

// ===== POPUP HANDLERS =====
function showPopup(element, teacher, date, time, reason, status, cancelReason) {
    const registrationId = element.getAttribute('data-registration-id');
    
    // Create a new popup element
    let popup = document.createElement("div");
    popup.classList.add("popup");
    popup.id = "popup";
    
    // Create the close button
    let closeButton = document.createElement("span");
    closeButton.classList.add("close-btn");
    closeButton.innerHTML = "&times;";
    closeButton.onclick = function() {
        closePopup();
    };
    
    // Create the content
    let popupContent = document.createElement("p");
    let statusClass = status.toLowerCase() === "approved" ? "status-approved" : 
                     (status.toLowerCase() === "rejected" || status.toLowerCase() === "cancelled") ? "status-rejected" : "status-pending";
    
    let cancelReasonText = (status.toLowerCase() === "cancelled" && cancelReason) ? 
                         "<br>Cancel Reason: <span class='reason-cancelled'>" + cancelReason + "</span>" : "";
    
    let rejectionReasonText = (status.toLowerCase() === "rejected" && cancelReason) ? 
                         "<br>Rejection Reason: <span class='reason-cancelled'>" + cancelReason + "</span>" : "";
    
    popupContent.innerHTML = "<strong>Teacher:</strong> " + teacher + 
                          "<br><strong>Date:</strong> " + date + 
                          "<br><strong>Time:</strong> " + time + 
                          "<br><strong>Reason:</strong> " + reason + 
                          "<br><strong>Status:</strong> <span class='" + statusClass + "'>" + status + "</span>" + 
                          cancelReasonText + 
                          rejectionReasonText;
    
    // Append the close button and content to the popup
    popup.appendChild(closeButton);
    popup.appendChild(popupContent);
    
    // Create appropriate button container
    let buttonContainer = document.createElement("div");
    buttonContainer.classList.add("button-container");
    
    // Add appropriate buttons based on status
    if (status !== 'Cancelled' && status !== 'Rejected') {
        // For pending or approved consultations - show cancel button
        let cancelButton = document.createElement("button");
        cancelButton.classList.add("cancel-btn");
        cancelButton.innerHTML = "Cancel";
        cancelButton.onclick = function() {
            showCancelReasonModal(registrationId);
            closePopup();
        };
        buttonContainer.appendChild(cancelButton);
        popup.appendChild(buttonContainer);
    }
    else if (status === 'Rejected') {
        // For rejected consultations - show delete button
        let deleteButton = document.createElement("button");
        deleteButton.classList.add("cancel-btn");
        deleteButton.innerHTML = "Delete";
        deleteButton.onclick = function() {
            deleteRejectedConsultation(registrationId);
        };
        buttonContainer.appendChild(deleteButton);
        popup.appendChild(buttonContainer);
    }
    
    // Set the position of the popup near the clicked element
    let rect = element.getBoundingClientRect();
    popup.style.top = (rect.top + window.scrollY) + "px";
    popup.style.left = (rect.left + window.scrollX) + "px";
    
    // Remove old popup if exists
    let oldPopup = document.getElementById("popup");
    if (oldPopup) {
        oldPopup.remove();
    }
    
    // Add the popup to the body
    document.body.appendChild(popup);
    
    // Display the popup with a slight delay to trigger the transition
    setTimeout(function() {
        popup.classList.add("show");
    }, 10);
}

function closePopup() {
    let popup = document.getElementById("popup");
    if (popup) {
        popup.classList.remove("show");
        setTimeout(function() {
            popup.remove();
        }, 300); // Wait for the transition to complete
    }
}

// Function to delete rejected consultations
function deleteRejectedConsultation(registrationId) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "update_status.php?status=DeleteRejected", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Remove the entry from UI
                        const element = document.querySelector('[data-registration-id="' + registrationId + '"]');
                        if (element) {
                            element.remove();
                        }
                        showNotification(response.message);
                        closePopup();
                    } else {
                        showNotification(response.message, true);
                    }
                } catch (e) {
                    console.error('Error parsing response:', e);
                    console.log('Response text:', xhr.responseText);
                    showNotification('An error occurred. Please try again', true);
                }
            } else {
                console.error('Error with request:', xhr.status, xhr.statusText);
                showNotification('An error occurred. Please try again', true);
            }
        }
    };

    xhr.send(JSON.stringify({ registration_id: registrationId }));
}

// Close popups when clicking outside
window.onclick = function(event) {
    const popup = document.getElementById('popup');
    if (popup && event.target === popup) {
        closePopup();
    }
    
    const modal = document.getElementById('cancelReasonModal');
    if (modal && event.target === modal) {
        closeCancelReasonModal();
    }
}

// ===== CANCEL CONSULTATION HANDLERS =====
function showCancelReasonModal(registrationId) {
    currentRegistrationId = registrationId;
    document.getElementById('cancelRegistrationId').value = registrationId;
    const modal = document.getElementById('cancelReasonModal');
    modal.style.display = 'block';
    closePopup(); // Close the details popup
    
    // Add animation class after a small delay to trigger transition
    setTimeout(function() {
        modal.classList.add('show');
    }, 10);
}

function closeCancelReasonModal() {
    const modal = document.getElementById('cancelReasonModal');
    modal.classList.remove('show');
    setTimeout(function() {
        modal.style.display = 'none';
    }, 300);
}

function submitCancelReason(event) {
    event.preventDefault();
    const registrationId = document.getElementById('cancelRegistrationId').value;
    const cancelReason = document.getElementById('cancelReason').value;

    fetch('update_status.php?status=Cancelled', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ registration_id: registrationId, cancelReason: cancelReason })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.message);
            // Notify the teacher about the cancellation
            notifyTeacherCancellation(registrationId, cancelReason);
            closeCancelReasonModal();
            // Optionally, refresh the page or update the UI to reflect the changes
            location.reload();
        } else {
            showNotification(data.message, true);
        }
    });
}

function notifyTeacherCancellation(registrationId, cancelReason) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "notify_teacher.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log('Teacher notified about the cancellation.');
        }
    };

    xhr.send(JSON.stringify({ registration_id: registrationId, cancelReason: cancelReason }));
}

function closeCancelReasonModal() {
    document.getElementById('cancelReasonModal').style.display = 'none';
}

function updateStatus(registrationId, status, cancelReason = '') {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "update_status.php?status=" + status, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    const element = document.querySelector('[data-registration-id="' + registrationId + '"]');
                    if (element) {
                        element.remove();
                    }
                    showNotification(response.message);
                } else {
                    showNotification(response.message, true);
                }
            } catch (e) {
                console.error('Error parsing response:', e);
                console.log('Response text:', xhr.responseText);
                showNotification('An error occurred. Please try again', true);
            }
        } else {
            console.error('Error with request:', xhr.status, xhr.statusText);
            showNotification('An error occurred. Please try again', true);
        }
    };

    let params = "registration_id=" + encodeURIComponent(registrationId);
    if (cancelReason) {
        params += "&cancelReason=" + encodeURIComponent(cancelReason);
    }

    xhr.send(params);
}

// ===== NOTIFICATION SYSTEM =====
function showNotification(message, isError = false) {
    const notification = document.getElementById('notification');
    const notificationMessage = document.getElementById('notificationMessage');
    
    if (!notification || !notificationMessage) {
        console.error('Notification elements not found!');
        return;
    }
    
    // Only show if we have a message
    if (message && message.trim() !== '') {
        notificationMessage.innerHTML = message;
        notification.style.backgroundColor = isError ? 'rgba(244, 67, 54, 0.8)' : 'rgba(12, 194, 18, 0.8)'; 
        notification.classList.add('show');
        console.log('Notification shown:', message);
    } else {
        // Hide notification if message is empty
        notification.classList.remove('show');
        console.log('Notification hidden: empty message');
    }
}

function closeNotification() {
    const notification = document.getElementById('notification');
    if (!notification) return;
    
    notification.classList.remove('show');
    console.log('Notification closed, updating session...');

    // Set variable in JavaScript for immediate effect
    if (typeof hasNewUpdates !== 'undefined') {
        hasNewUpdates = false;
    }
    
    // Make an AJAX request to update the session variable
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "update_session.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                console.log('Session updated:', xhr.responseText);
                // Store in localStorage as a backup mechanism
                localStorage.setItem('notificationClosed', 'true');
                localStorage.setItem('closedTimestamp', Date.now());
            } else {
                console.error('Error updating session:', xhr.status);
            }
        }
    };
    xhr.send("close_notification=true");
}

// ===== PAGE INITIALIZATION =====
document.addEventListener('DOMContentLoaded', function() {
    document.body.classList.add('show');
    
    // Handle hamburger menu
    const hamburger = document.querySelector('.hamburger-menu');
    const navMenu = document.querySelector('.nav ul');
    
    if (hamburger && navMenu) {
        hamburger.addEventListener('click', function() {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
    }
    
    // Check for notifications
    console.log('Initial hasNewUpdates value:', typeof hasNewUpdates !== 'undefined' ? hasNewUpdates : 'undefined');
    console.log('Unseen updates:', unseenUpdates);
    
    // Check URL parameters for notification status
    const urlParams = new URLSearchParams(window.location.search);
    const notificationStatus = urlParams.get('notification');
    
    if (notificationStatus === 'approved') {
        // Show notification for approval from URL parameter
        setTimeout(() => {
            showNotification('Your consultation request has been approved');
        }, 1000);
    } else if (typeof hasNewUpdates !== 'undefined' && hasNewUpdates) {
        // Check for specific types of updates
        if (typeof unseenUpdates !== 'undefined' && unseenUpdates.length > 0) {
            // Get the most recent update
            let latestUpdate = unseenUpdates[0];
            console.log('Latest update status:', latestUpdate.status);
            
            // Customize message based on status
            let message = '';
            if (latestUpdate.status === 'Approved') {
                message = 'Your consultation request has been approved';
            } else if (latestUpdate.status === 'Rejected') {
                message = 'Your consultation request has been rejected';
            } else if (latestUpdate.status === 'Pending') {
                message = 'Your consultation request is pending review';
            } else if (latestUpdate.status === 'Cancelled') {
                message = 'Your consultation request has been cancelled';
            } else {
                message = 'Your schedule has been updated.';
            }
            
            setTimeout(() => {
                showNotification(message);
            }, 100); 
        } else {
            setTimeout(() => {
                showNotification('Your schedule has been updated');
            }, 100);
        }
    }
    
    // Check if there are any approved registrations and show notifications for them
    if (typeof allRegistrations !== 'undefined') {
        const recentlyApproved = allRegistrations.filter(reg => 
            reg.status === 'Approved' && 
            !localStorage.getItem('notified_' + reg.registration_id)
        );
        
        if (recentlyApproved.length > 0) {
            setTimeout(() => {
                showNotification('You have ' + recentlyApproved.length + ' approved consultation(s)!');
                // Mark as notified
                recentlyApproved.forEach(reg => {
                    localStorage.setItem('notified_' + reg.registration_id, 'true');
                });
            }, 1500);
        }
    }
});