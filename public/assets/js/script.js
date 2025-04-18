/**
 * Global JavaScript file for test-101 application
 */

// Toast initialization for session messages
document.addEventListener('DOMContentLoaded', function () {
  // Initialize success toasts
  const successToast = document.getElementById('successToast');
  if (successToast && successToast.querySelector('.toast-body').textContent.trim()) {
    const bsSuccessToast = new bootstrap.Toast(successToast, {
      animation: true,
      autohide: true,
      delay: 4000
    });
    bsSuccessToast.show();
  }

  // Initialize error toasts
  const errorToast = document.getElementById('errorToast');
  if (errorToast && errorToast.querySelector('.toast-body').textContent.trim()) {
    const bsErrorToast = new bootstrap.Toast(errorToast, {
      animation: true,
      autohide: true,
      delay: 4000
    });
    bsErrorToast.show();
  }

  // Task filters and search functionality
  const taskSearch = document.getElementById('taskSearch');
  if (taskSearch) {
    taskSearch.addEventListener('input', function() {
      const searchTerm = this.value.toLowerCase();
      const taskRows = document.querySelectorAll('.task-row');
      
      taskRows.forEach(row => {
        const taskTitle = row.querySelector('.task-title').textContent.toLowerCase();
        const taskDescription = row.querySelector('.task-description').textContent.toLowerCase();
        
        if (taskTitle.includes(searchTerm) || taskDescription.includes(searchTerm)) {
          row.style.display = '';
        } else {
          row.style.display = 'none';
        }
      });
    });
  }

  // Task status filter
  const statusFilters = document.querySelectorAll('.status-filter');
  if (statusFilters.length > 0) {
    statusFilters.forEach(filter => {
      filter.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Update active filter
        document.querySelectorAll('.status-filter').forEach(f => f.classList.remove('active'));
        this.classList.add('active');
        
        const status = this.dataset.status;
        const taskRows = document.querySelectorAll('.task-row');
        
        taskRows.forEach(row => {
          if (status === 'all' || row.dataset.status === status) {
            row.style.display = '';
          } else {
            row.style.display = 'none';
          }
        });
      });
    });
  }

  // Task deletion confirmation
  const deleteButtons = document.querySelectorAll('.delete-task');
  if (deleteButtons.length > 0) {
    deleteButtons.forEach(button => {
      button.addEventListener('click', function(e) {
        if (!confirm('Are you sure you want to delete this task?')) {
          e.preventDefault();
        }
      });
    });
  }

  // Task completion toggle
  const completeToggles = document.querySelectorAll('.task-complete-toggle');
  if (completeToggles.length > 0) {
    completeToggles.forEach(toggle => {
      toggle.addEventListener('change', function() {
        const form = this.closest('form');
        form.submit();
      });
    });
  }
});

/**
 * Toggle task status between completed and pending
 * @param {number} taskId - The ID of the task
 * @param {HTMLElement} checkbox - The checkbox element
 * @returns {boolean} - Returns false to prevent form submission
 */
function toggleTaskStatus(taskId, checkbox) {
  // Placeholder: Add logic to update task status via AJAX or form submission
  console.log(`Toggling status for task ${taskId}. New checked state: ${checkbox.checked}`);
  // Example: You might want to submit a form or make an AJAX call here
  // const form = checkbox.closest('form');
  // if (form) {
  //   form.submit();
  // }
  return false; // Prevent default form submission if necessary
}

/**
 * Handle click on a task row to toggle its checkbox
 * @param {HTMLElement} row - The task row element
 * @param {number} taskId - The ID of the task
 */
function taskRowClick(row, taskId) {
  const checkbox = row.querySelector('.task-check');
  checkbox.checked = !checkbox.checked;
  toggleTaskStatus(taskId, checkbox);
}

/**
 * Display a toast notification for task actions
 * @param {string} message - The message to display
 * @param {string} type - The type of toast (success or danger)
 * @param {string} taskTitle - The title of the task
 */
function showTaskToast(message, type = 'success', taskTitle = '') {
  const toastContainer = document.getElementById('toastContainer');
  const toastId = 'toast-' + Date.now();
  
  // Create new toast element
  const toastHtml = `
    <div id="${toastId}" class="toast border-dark ${type}" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header bg-white">
        <i class="bi ${type === 'success' ? 'bi-check-circle-fill text-success' : 'bi-exclamation-circle-fill text-danger'} me-2"></i>
        <strong class="me-auto">${type === 'success' ? 'Success' : 'Error'}</strong>
        <small>${taskTitle ? `Task: ${taskTitle.substring(0, 15)}${taskTitle.length > 15 ? '...' : ''}` : ''}</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body">
        ${message}
      </div>
    </div>
  `;
  
  // Add toast to container
  toastContainer.insertAdjacentHTML('beforeend', toastHtml);
  
  // Initialize and show toast
  const toastElement = document.getElementById(toastId);
  const toast = new bootstrap.Toast(toastElement, {
    animation: true,
    autohide: true,
    delay: 4000
  });
  
  toast.show();
  
  // Remove toast from DOM after hidden
  toastElement.addEventListener('hidden.bs.toast', function () {
    toastElement.remove();
  });
}