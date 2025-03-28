<?php
session_start();
if (!isset($_SESSION["user_id"])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rolsa Technologies - Account</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <nav>
      <ul class="navbar">
        <li><a href="index.html">Home</a></li>
        <li><a href="carbon.html">Carbon Footprint</a></li>
        <li><a href="advice.html">Advice</a></li>
        <li><a href="account.php" class="active">Account</a></li>
      </ul>
      <div class="accessibility-controls">
        <button onclick="changeFontSize('small')">Small</button>
        <button onclick="changeFontSize('medium')">Medium</button>
        <button onclick="changeFontSize('large')">Large</button>
        <button onclick="toggleDarkMode()">Toggle Dark/Light Mode</button>
        <button onclick="window.location.href='logout.php'">Sign Out</button>
      </div>
    </nav>
  </header>
  <main>
    <section class="account-details-section">
      <h1>Account Details</h1>
      <div class="account-details-container">
        <div class="account-left">
          <img src="https://www.bing.com/th/id/OIP.cEvbluCvNFD_k4wC3k-_UwHaHa?w=150&h=150&c=8&rs=1&qlt=90&o=6&pid=3.1&rm=2" alt="User Icon" class="user-icon">
        </div>
        <div class="account-center">
          <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION["email"]); ?></p>
          <p><strong>First Name:</strong> <?php echo htmlspecialchars($_SESSION["first_name"]); ?></p>
          <p><strong>Last Name:</strong> <?php echo htmlspecialchars($_SESSION["last_name"]); ?></p>
          <p><strong>Location:</strong> <?php echo htmlspecialchars($_SESSION["location"]); ?></p>
        </div>
        <div class="account-right">
          <h2>Account Settings</h2>
          <p>Light mode / Dark mode</p>
          <p>Font Size Adjuster</p>
        </div>
      </div>
    </section>
  </main>
  <footer>
    <div class="footer-left">
      <img src="images/logo.png" alt="Company Logo">
      <span>Rolsa Technologies</span>
    </div>
    <div class="footer-right">
      <a href="#">Twitter</a>
      <a href="#">Facebook</a>
      <a href="#">LinkedIn</a>
    </div>
  </footer>
  <script src="script.js"></script>
</body>
</html>
