$(document).ready(function() {
  // Function to fetch and display forms
  function fetchForms() {
      $.ajax({
          url: 'dashbored.php',
          type: 'GET',
          dataType: 'json',
          success: function(response) {
              if (response.success) {
                  displayForms(response.forms);
              } else {
                  console.error('Error fetching forms:', response.message);
              }
          },
          error: function(xhr, status, error) {
              console.error('Error fetching forms:', error);
          }
      });
  }

  // Function to display forms in the table
  function displayForms(forms) {
      var tableBody = $('#forms-table tbody');
      tableBody.empty(); // Clear existing rows
      
      forms.forEach(function(form) {
          var row = `<tr data-id="${form.id}">
                      <td>${form.id}</td>
                      <td>${form.name}</td>
                      <td>${form.email}</td>
                      <td>${form.message}</td>
                      <td>
                          <button class='btn btn-danger btn-sm delete-btn'>Delete</button>
                      </td>
                  </tr>`;
          tableBody.append(row);
      });

      // Attach click event to delete buttons
      $('.delete-btn').click(function() {
          var id = $(this).closest('tr').data('id');
          confirmDelete(id); // Call confirmDelete function with ID
      });
  }

  // Function to show confirmation dialog before deleting
  function confirmDelete(id) {
      if (confirm('Are you sure you want to delete this record?')) {
          deleteForm(id);
      }
  }

  // Function to delete a form entry
  function deleteForm(id) {
      $.ajax({
          url: 'dashbored.php',
          type: 'POST',
          data: { action: 'delete', delete_id: id },
          dataType: 'json',
          success: function(response) {
              if (response.success) {
                  // Remove deleted row from the table
                  $('#forms-table tbody').find(`tr[data-id="${id}"]`).remove();
                  alert('Form entry deleted and archived successfully!');
              } else {
                  console.error('Error deleting form:', response.message);
              }
          },
          error: function(xhr, status, error) {
              console.error('Error deleting form:', error);
          }
      });
  }

  // Function to fetch download count from server
  function fetchDownloadCount() {
      $.ajax({
          url: 'fetch_download_count.php',
          type: 'GET',
          dataType: 'json',
          success: function(response) {
              if (response.success) {
                  // Update the download count in the DOM
                  $('#download-count').text(response.count);
              } else {
                  console.error('Error fetching download count:', response.message);
                  $('#download-count').text('Error');
              }
          },
          error: function(xhr, status, error) {
              console.error('Error fetching download count:', error);
              $('#download-count').text('Error');
          }
      });
  }

  // Function to update download count
  function updateDownloadCount() {
      $.ajax({
          url: 'insert_download_count.php',
          type: 'POST',
          dataType: 'json',
          success: function(response) {
              if (!response.success) {
                  console.error('Error updating download count:', response.message);
              }
          },
          error: function(xhr, status, error) {
              console.error('Error updating download count:', error);
          }
      });
  }

  // Initial fetch of forms and download count when the page loads
  fetchForms();
  fetchDownloadCount();

  // Interval to periodically fetch forms and download count (every 5 seconds for example)
  setInterval(function() {
      fetchForms();
      fetchDownloadCount();
  }, 5000); // Adjust interval as needed

  // Click event handler for the download button (if you have one)
  $('#download-button').click(function() {
      updateDownloadCount();
  });

  // Click event handlers for navigation links
  $('#home-link').click(function(e) {
      e.preventDefault();
      $('.main').hide();
      $('#main').show();
  });

  $('#profile-link').click(function(e) {
      e.preventDefault();
      $('.main').hide();
      $('#profile').show();
  });

  $('#forms-link').click(function(e) {
      e.preventDefault();
      $('.main').hide();
      $('#forms').show();
      fetchForms(); // Refresh forms when navigating to Forms section
  });
});