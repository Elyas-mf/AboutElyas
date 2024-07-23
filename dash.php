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
  <link rel="stylesheet" href="https://pyscript.net/releases/2024.7.1/core.css">
  <script type="module" src="https://pyscript.net/releases/2024.7.1/core.js"></script>
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
      <h2>My Status</h2>
      <div class="grid-container">
        <div class="box">
          <h3>Visitors</h3>
          <p id="visitor-count" style="color: white;">Loading..</p>
        </div>
        <div class="box">
          <h3>Download CV Click</h3>
          <p id="download-count" style="color: white;">Loading...</p>
        </div>
        <div class="box_plot">
          <h3>Analysis Plot</h3>
          <img id="analysis-plot" src="" alt="Analysis Plot" style="width: 300%; max-width: 600px;"/>
        </div>
      </div>
    </section>

    <section class="main" id="profile" style="display: none;">
      <h1>Profile</h1>
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

  <script src="dash.js"></script>
  <script>
    $(document).ready(function() {
      // Function to fetch summary counts from the server
      function fetchSummaryCounts() {
        $.ajax({
          url: 'fetch_summary_counts.php',
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              $('#visitor-count').text(response.total_visits);
              $('#download-count').text(response.total_downloads);
            } else {
              console.error('Error fetching summary counts:', response.message);
              $('#visitor-count').text('Error');
              $('#download-count').text('Error');
            }
          },
          error: function(xhr, status, error) {
            console.error('Error fetching summary counts:', error);
            $('#visitor-count').text('Error');
            $('#download-count').text('Error');
          }
        });
      }

      // Function to fetch the plot from the Flask server
      function fetchPlot() {
        $.ajax({
          url: 'http://127.0.0.1:5000/api/time_series',
          type: 'GET',
          dataType: 'json',
          success: function(response) {
            if (response.plot) {
              $('#analysis-plot').attr('src', 'data:image/png;base64,' + response.plot);
            } else {
              console.error('Error fetching plot:', response.message);
            }
          },
          error: function(xhr, status, error) {
            console.error('Error fetching plot:', error);
          }
        });
      }

      // Initial fetch of summary counts and plot when the page loads
      fetchSummaryCounts();
      fetchPlot();

      // Interval to periodically fetch summary counts and plot
      setInterval(fetchSummaryCounts, 5000); // Adjust interval as needed
      setInterval(fetchPlot, 60000); // Fetch the plot every 60 seconds
    });
  </script>
</body>
</html>
