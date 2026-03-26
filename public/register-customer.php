<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration | Dream Drive</title>
    <link rel="stylesheet" href="/car/style.css">
</head>
<body>

    
 <?php include('../reuse/navbar.php'); ?>

    <main class="auth-page">
        <div class="container auth-container">
            <div class="auth-card">
                <h2>Create Customer Account</h2>
                <p>Join Dream Drive to rent luxury cars</p>

                <form action="#" method="post" id="customerForm">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address (Optional)</label>
                        <textarea id="address" name="address" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-dark">Register</button>
                </form>
                <p class="auth-footer">Already have an account? <a href="login.php">Sign in</a></p>
            </div>
        </div>
    </main>

    <?php include('../reuse/footer.php'); ?>
  

    <!-- simple client-side validation for password match -->
    <!-- <script>
        const form = document.getElementById('customerForm');
        form.addEventListener('submit', function(e) {
            const pwd = document.getElementById('password').value;
            const confirm = document.getElementById('confirm_password').value;
            if (pwd !== confirm) {
                e.preventDefault();
                alert('Passwords do not match.');
            }
        });
    </script> -->
</body>
</html>