<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agency Registration | Dream Drive</title>
    <link rel="stylesheet" href="/car/style.css">
</head>
<body>

  <?php include('../reuse/navbar.php'); ?>

    <main class="auth-page">
        <div class="container auth-container">
            <div class="auth-card">
                <h2>Register Your Car Agency</h2>
                <p>Partner with Dream Drive to list your fleet</p>

                <form action="#" method="post" id="agencyForm">
                    <div class="form-group">
                        <label for="agency_name">Agency Name</label>
                        <input type="text" id="agency_name" name="agency_name" required>
                    </div>
                    <div class="form-group">
                        <label for="contact_person">Contact Person</label>
                        <input type="text" id="contact_person" name="contact_person" required>
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
                        <label for="address">Business Address</label>
                        <textarea id="address" name="address" rows="2"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="reg_number">Agency Registration Number / Tax ID</label>
                        <input type="text" id="reg_number" name="reg_number" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-dark">Register Agency</button>
                </form>
                <p class="auth-footer">Already registered? <a href="login.php">Sign in</a></p>
            </div>
        </div>
    </main>

   <?php include('../reuse/footer.php'); ?>
  

    <!-- <script>
        const form = document.getElementById('agencyForm');
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