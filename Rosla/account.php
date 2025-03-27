<?php
session_start();


$csv_file = 'users.csv';


function findUser($email) {
    global $csv_file;
    if (!file_exists($csv_file)) {
        return false;
    }
    $handle = fopen($csv_file, 'r');
    while (($data = fgetcsv($handle)) !== false) {
        if (isset($data[0]) && $data[0] === $email) {
            fclose($handle);
            return $data;
        }
    }
    fclose($handle);
    return false;
}


function registerUser($email, $password, $dob, $location) {
    global $csv_file;
    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $userData = [$email, $hashedPassword, $dob, $location];
    $handle = fopen($csv_file, 'a');
    fputcsv($handle, $userData);
    fclose($handle);
}


$registrationError = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $reg_email = trim($_POST['reg_email']);
    $reg_password = trim($_POST['reg_password']);
    $reg_dob = $_POST['reg_dob'];
    $reg_location = $_POST['reg_location'];

  
    if (empty($reg_email) || empty($reg_password) || empty($reg_dob) || empty($reg_location)) {
        $registrationError = "All fields are required for registration.";
    } else {
       
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W]).{8,}$/', $reg_password)) {
            $registrationError = "Password must be at least 8 characters long and include uppercase, lowercase, number, and special symbol.";
        } elseif (findUser($reg_email)) {
            $registrationError = "User with this email already exists.";
        } else {
            registerUser($reg_email, $reg_password, $reg_dob, $reg_location);
            $_SESSION['user'] = $reg_email;
            header("Location: account.php");
            exit();
        }
    }
}


$loginError = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $login_email = trim($_POST['login_email']);
    $login_password = trim($_POST['login_password']);

    if (empty($login_email) || empty($login_password)) {
        $loginError = "Please enter both email and password.";
    } else {
        $user = findUser($login_email);
        if ($user && password_verify($login_password, $user[1])) {
            $_SESSION['user'] = $login_email;
            header("Location: account.php");
            exit();
        } else {
            $loginError = "Invalid email or password.";
        }
    }
}


if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: account.php");
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
        <li><a href="account.php">Account</a></li>
      </ul>
      <div class="accessibility-controls">
        <button onclick="changeFontSize('small')">Small</button>
        <button onclick="changeFontSize('medium')">Medium</button>
        <button onclick="changeFontSize('large')">Large</button>
        <button onclick="toggleDarkMode()">Toggle Dark/Light Mode</button>
      </div>
    </nav>
  </header>


  <main>
    <section class="account-content">
      <?php if (isset($_SESSION['user'])): ?>
       
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?></h1>
        <p>Account Details:</p>
        <?php
        $userData = findUser($_SESSION['user']);
        if ($userData):
        ?>
          <ul>
            <li>Email: <?php echo htmlspecialchars($userData[0]); ?></li>
            <li>Date of Birth: <?php echo htmlspecialchars($userData[2]); ?></li>
            <li>Location: <?php echo htmlspecialchars($userData[3]); ?></li>
          </ul>
        <?php endif; ?>
        <p><a href="account.php?action=logout">Logout</a></p>
      <?php else: ?>
   
        <div class="form-container">
          <h2>Register</h2>
          <?php if (!empty($registrationError)): ?>
            <p class="error"><?php echo $registrationError; ?></p>
          <?php endif; ?>
          <form method="POST" action="account.php">
            <input type="hidden" name="register" value="1">
            <label for="reg_email">Email Address:</label>
            <input type="email" id="reg_email" name="reg_email" required>
            
            <label for="reg_password">Password:</label>
            <input type="password" id="reg_password" name="reg_password" required>
            <small>Password must be at least 8 characters and include uppercase, lowercase, number, and special symbol.</small>
            
            <label for="reg_dob">Date of Birth:</label>
            <input type="date" id="reg_dob" name="reg_dob" required>
            
            <label for="reg_location">Location:</label>
            <select id="reg_location" name="reg_location" required>
              <option value="">Select Location</option>
              <option value="Location1">Location1</option>
              <option value="Location2">Location2</option>
              <option value="Location3">Location3</option>
            </select>
            
            <button type="submit">Register</button>
          </form>
        </div>
       
        <div class="form-container">
          <h2>Login</h2>
          <?php if (!empty($loginError)): ?>
            <p class="error"><?php echo $loginError; ?></p>
          <?php endif; ?>
          <form method="POST" action="account.php">
            <input type="hidden" name="login" value="1">
            <label for="login_email">Email Address:</label>
            <input type="email" id="login_email" name="login_email" required>
            
            <label for="login_password">Password:</label>
            <input type="password" id="login_password" name="login_password" required>
            
            <button type="submit">Login</button>
          </form>
        </div>
      <?php endif; ?>
    </section>
  </main>


  <footer>
    <div class="footer-left">
      <img src="https://via.placeholder.com/50" alt="Company Logo">
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
