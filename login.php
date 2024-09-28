<?php
// Database configuration (replace with your actual credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "career_coach";

// Session configuration (add these lines for session timeout)
session_start();  // Start the session
ini_set('session.gc_maxlifetime', 60); // Set session timeout to 1 minute (60 seconds)

// Connect to MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve email and password from the form
  $email = $_POST["email"];
  $password = $_POST["password"];

  // Prepare the SQL statement and select and check in the database
  $stmt = "SELECT * FROM Users WHERE email = '$email' AND password = '$password'";

  $result = mysqli_query($conn, $stmt) or die(mysqli_error($conn));
  $num_row = mysqli_num_rows($result);

  // Verify the provided password with the hashed password from the database
  if ($num_row == 1) {
    // If password is correct, update session last access time and redirect to index.html
    $_SESSION['last_activity'] = time(); // Update last activity timestamp
    header("Location: ../mainpages/index1.html");
    exit();
  } else {
    // If password is incorrect, alert the user and return to the login page
    echo "<script>alert('Invalid email or password. Please try again.');";
    header("Location: 'login.html'");
    exit();
  }
} else {
  // If no record found or form not submitted, check for session timeout
  if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 60)) {
    // Session has timed out, destroy session and redirect to login
    session_destroy();
    echo "<script>alert('Session timed out. Please login again.');";
    header("Location: 'login.html'");
    exit();
  }
}

// Close the statement (already done in most cases by fetch_assoc)
$stmt->close();

// Close the database connection
$conn->close();
?>
