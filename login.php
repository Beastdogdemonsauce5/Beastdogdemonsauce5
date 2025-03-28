<?php
session_start();
require 'db.php';
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $password = $_POST["password"];
  $stmt = $conn->prepare("SELECT id, password, first_name, last_name, location FROM users WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $stmt->store_result();
  if ($stmt->num_rows > 0) {
    $stmt->bind_result($id, $hash, $first_name, $last_name, $location);
    $stmt->fetch();
    if (password_verify($password, $hash)) {
      $_SESSION["user_id"] = $id;
      $_SESSION["email"] = $email;
      $_SESSION["first_name"] = $first_name;
      $_SESSION["last_name"] = $last_name;
      $_SESSION["location"] = $location;
      header("Location: account.php");
      exit();
    } else {
      $error = "Invalid password.";
    }
  } else {
    $error = "No user found with that email.";
  }
  $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Rolsa Technologies - Login</title>
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
    <section class="login-section">
      <h1>Login</h1>
      <?php if($error) { echo "<p class='error'>$error</p>"; } ?>
      <form action="login.php" method="post">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
      </form>
      <p>Don't have an account? <a href="register.php">Register here</a></p>
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
