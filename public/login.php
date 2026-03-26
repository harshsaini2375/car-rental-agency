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
        <form action="dashboard.html" method="get">
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