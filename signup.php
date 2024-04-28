<?php
include 'functions.php';
session_start(); // Start the session
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login or Sign Up</title>
  <link rel="stylesheet" href="signup.css">
  <style>
    /* Add the CSS for the login box here */
    .login-box {
      background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
      border-radius: 10px; /* Rounded corners */
      padding: 20px; /* Add padding */
      margin: 50px auto; /* Center the box horizontally and add some top margin */
      max-width: 400px; /* Limit the width of the box */
    }
  </style>
</head>

<body>
  <div class="background"></div>
  <div class="login-signup-page">
    <div class="login-box"> <!-- Wrap all login-related content in a box -->
      <div class="login-content" id="login">
        <h1>Login</h1>

          <!-- Display error message if it exists -->
          <?php if(isset($_SESSION["error"])): ?>
          <p><?php echo $_SESSION["error"]; ?></p>
          <?php unset($_SESSION["error"]); ?> <!-- Clear the error message after displaying -->
          <?php endif; ?>

        <form name="login" class="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <div class="input-group">
            <label for="login-username">Username</label>
            <input type="text" id="login-username" name="login-username" required>
          </div>
          <div class="input-group">
            <label for="login-password">Password</label>
            <input type="password" id="login-password" name="login-password" required>
          </div>
          <div class="input-group">
            <a href="#" class="forgot-password">Forgot Password?</a>
          </div>
          <button type="submit" class="login-button" name="login">Login</button>
        </form>
        <p>Don't have an account? <a href="#" class="signup-link">Sign up</a></p>
      </div>
    </div>
    <div class="signup-content" id="signup" style="display: none;">
      <h1>Sign Up</h1>

      <form name="signup" class="signup-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="input-group">
          <label for="signup-username">Username</label>
          <input type="text" id="signup-username" name="signup-username" required>
        </div>
        <div class="input-group">
          <label for="signup-email">Email</label>
          <input type="email" id="signup-email" name="signup-email" required>
        </div>
        <div class="input-group">
          <label for="signup-password">Password</label>
          <input type="password" id="signup-password" name="signup-password" required>
        </div>
        <button type="submit" class="signup-button">Sign Up</button>
      </form>

      <p>Already have an account? <a href="#" class="login-link">Login</a></p>
    </div>
    <div class="forgot-password-content" id="forgot-password" style="display: none;">
      <h1>Forgot Password</h1>
      <form name="forgot" class="forgot-password-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="input-group">
          <label for="forgot-email">Email</label>
          <input type="email" id="forgot-email" name="forgot-email" required>
        </div>
        <button type="submit" class="forgot-password-button">Reset Password</button>
      </form>
    </div>
  </div>
  <script src="login_signup_script.js"></script>
</body>
</html>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["login"])) {
    $username = $_POST["login-username"];
    $password = $_POST["login-password"];

    // Query the database to check for matching record
    $result = loginCustomer($username, $password);

    if ($result->num_rows == 1) {
        // Fetch the user ID and store it in a session variable
        $row = $result->fetch_assoc();
        $_SESSION["user_id"] = $row["CustomerID"];

        // Redirect to the main menu page or any other page
        header("Location: menu.php");
        exit();
    } 
    else {
        // Set error message as a session variable
        $_SESSION["error"] = "Invalid username or password";
        
        // Redirect back to the login page
        header("Location: signup.php");
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"])) {
    $user = $_POST["signup-username"];
    $email = $_POST["signup-email"];
    $pass = $_POST["signup-password"];

    $result = createCustomer($user, $pass, $email, NULL, NULL);

    if ($result) {
        echo "<br>";
        echo "Customer added successfully";
    }
    else {
        echo "Failed to add customer" . $conn->error;
    }
}

?>