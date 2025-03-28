<?php
require 'db.php';
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
  $first_name = $_POST["first_name"];
  $last_name = $_POST["last_name"];
  $location = $_POST["location"];
  $stmt = $conn->prepare("INSERT INTO users (email, password, first_name, last_name, location) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("sssss", $email, $password, $first_name, $last_name, $location);
  if ($stmt->execute()) {
    header("Location: login.php");
    exit();
  } else {
    $error = "Error: " . $stmt->error;
  }
  $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rolsa Technologies - Register</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <nav>
      <ul class="navbar">
        <li><a href="index.html">Home</a></li>
        <li><a href="carbon.html">Carbon Footprint</a></li>
        <li><a href="advice.html">Advice</a></li>
        <li><a href="account.php">Account</a></li>
      </ul>
      <div class="accessibility-controls">
        <button onclick="changeFontSize('small')">Small</button>
        <button onclick="changeFontSize('medium')">Medium</button>
        <button onclick="changeFontSize('large')">Large</button>
        <button onclick="toggleDarkMode()">Toggle Dark/Light Mode</button>
        <button onclick="window.location.href='login.php'">Sign In</button>
      </div>
    </nav>
  </header>
  <main>
    <section class="register-section">
      <h1>Register</h1>
      <?php if($error) { echo "<p class='error'>$error</p>"; } ?>
      <form action="register.php" method="post">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        <label for="first_name">First Name</label>
        <input type="text" id="first_name" name="first_name">
        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name">
        <label for="location">Location</label>
        <input type="text" id="location" name="location">
        <button type="submit">Register</button>
      </form>
      <p>Already have an account? <a href="login.php">Login here</a></p>
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
