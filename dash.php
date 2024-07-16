<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <meta charset="UTF-8" />
  <title>Dashboard</title>
  <link rel="stylesheet" href="da.css" />
  <!-- Font Awesome Cdn Link -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"/>
  <style>
    /* Your existing CSS styles here */

  </style>
</head>
<body>
  <aside class="sidebar">
    <div class="sidebar-header">
      <img src="images/me2.png" alt="logo" />
      <h2>Dashboard</h2>
    </div>
    <ul class="sidebar-links">
      <h4>
        <span>Main Menu</span>
        <div class="menu-separator"></div>
      </h4>
      <li>
        <a href="#" id="home-link">
          <i class="fas fa-home"></i>
          <span class="nav-item">Home</span>
        </a>
      </li>
      <li>
        <a href="#" id="forms-link">
          <i class="fas fa-tasks"></i>
          <span class="nav-item">Forms</span>
        </a>
      </li>
      <h4>
        <span>Account</span>
        <div class="menu-separator"></div>
      </h4>
      <li>
        <a href="#" id="profile-link">
          <i class="fas fa-user"></i>
          <span class="nav-item">Profile</span>
        </a>
      </li>
      <li>
        <a href="logout.php" class="logout">
          <i class="fas fa-sign-out-alt"></i>
          <span class="nav-item">Log out</span>
        </a>
      </li>
    </ul>
  </aside>

  <div class="container">
  <section class="main" id="main">
  
  <h2>My status</h2>
  <div class="grid-container">
    <div class="box">
      <h3>Visitors</h3>
      <p id="visitor-count">Loading..</p>
      
    </div>
    <div class="box">
      <h3>Download CV Click</h3>
      <p id="download-count">Loading...</p>
    </div>
  </div>
</section>


    <section class="main" id="profile" style="display: none;">
      <h1>Profile Section</h1>
      <p>Your profile section content goes here.</p>
    </section>

    <section class="main" id="forms" style="display: none;">
      <h1 style="text-align: left; margin-left: 25px; margin-top: 20px;">My Form</h1>
      <div class="table-container">
        <table class="table" id="forms-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Message</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <!-- Table rows will be dynamically added here -->
          </tbody>
        </table>
      </div>
    </section>
  </div>

  <!-- Link to your JavaScript file -->
  <script src="dash.js"></script>

  <script>
    $(document).ready(function() {
      // Function to fetch visitor count from server
      function fetchVisitorCount() {
        $.ajax({
          url: 'fetch_visitor_count.php',
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              // Update the visitor count in the DOM
              $('#visitor-count').text(response.count);
            } else {
              console.error('Error fetching visitor count:', response.message);
              $('#visitor-count').text('Error');
            }
          },
          error: function(xhr, status, error) {
            console.error('Error fetching visitor count:', error);
            $('#visitor-count').text('Error');
          }
        });
      }

      // Initial fetch of visitor count when page loads
      fetchVisitorCount();

      // Interval to periodically fetch visitor count (every 5 seconds for example)
      setInterval(fetchVisitorCount, 5000); // Adjust interval as needed
    });
  </script>

  <script>
    $(document).ready(function() {
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

      // Initial fetch of download count when page loads
      fetchDownloadCount();

      // Interval to periodically fetch download count (every 5 seconds for example)
      setInterval(fetchDownloadCount, 5000); // Adjust interval as needed
    });
  </script>
</body>
</html>
