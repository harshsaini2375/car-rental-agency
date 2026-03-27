<?php
session_start(); 

include '../config.php';

$error = ''; //store errors

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        // Check it exist in customers table or not
        // craete alias for columns
        $sql = "SELECT customer_id AS id, full_name AS name, email, password_hash, 'customer' AS user_type FROM customers WHERE email = ?";
        // prepare statement
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        // result is a row 
        $result = mysqli_stmt_get_result($stmt);
        // convert row to array
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($user && password_verify($password, $user['password_hash'])) {
            // Customer login success
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_type'] = 'customer';
            header('Location: ../mydashboard/dashboard.php');
            exit;
        }

        // If not found in customers, check agencies
        $sql = "SELECT agency_id AS id, agency_name AS name, email, password_hash, approved, 'agency' AS user_type FROM agencies WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);

        if ($user && password_verify($password, $user['password_hash'])) {
            // Agency login 
           
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_type'] = 'agency';
                header('Location: ../mydashboard/dashboard.php');
                exit;
            
        } else {
            $error = 'Invalid email or password.';
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In | Dream Drive</title>
  <link rel="stylesheet" href="/car/style.css">
</head>
<body>

  <?php include('../reuse/navbar.php'); ?>

  <main class="auth-page">
    <div class="container auth-container">
      <div class="auth-cardlogin">
        <h2>Welcome Back</h2>
        <p style="margin-bottom: 10px">Sign in to access your Dream Drive account</p>

        <?php if ($error): ?>
                <div class="error-message">
                    <p><?php echo htmlspecialchars($error); ?></p>
                </div>
            <?php endif; ?>


        <form action="" method="post">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
          </div>
          <button type="submit" class="btn btn-primary btn-dark">Sign In</button>
        </form>
        <div class="auth-footer">
          <p >Don't have an account? </p>
        Register as 
          <a href="register-customer.php">Customer</a>
          or
          <a href="register-agency.php">Agency</a>
         </div>  
      
      </div>
    </div>
  </main>

   <?php include('../reuse/footer.php'); ?>

</body>
</html>