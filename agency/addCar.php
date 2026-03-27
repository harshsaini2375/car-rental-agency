<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'agency') {
    header('Location: ../public/login.php');
    exit;
}

include '../config.php';

$success = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $model = trim($_POST['model'] ?? '');
    $vehicle_number = trim($_POST['vehicle_number'] ?? '');
    $seating_capacity = (int)($_POST['seating_capacity'] ?? 0);
    $rent_per_day = (float)($_POST['rent_per_day'] ?? 0);
    $fuel_type = $_POST['fuel_type'] ?? '';
    $transmission = $_POST['transmission'] ?? '';
    $year = (int)($_POST['year'] ?? 0);
    $color = trim($_POST['color'] ?? '');
    $image_url = trim($_POST['image_url'] ?? '');

    // Validation
    if (empty($model)) $errors[] = "Car model is required.";
    if (empty($vehicle_number)) $errors[] = "Vehicle number is required.";
    if ($seating_capacity <= 0) $errors[] = "Seating capacity must be at least 1.";
    if ($rent_per_day <= 0) $errors[] = "Rent per day must be greater than 0.";
    if (!in_array($fuel_type, ['Petrol', 'Diesel', 'Electric', 'Hybrid'])) $errors[] = "Please select a valid fuel type.";
    if (!in_array($transmission, ['Manual', 'Automatic'])) $errors[] = "Please select a valid transmission.";
    if ($year < 1990 || $year > date('Y') + 1) $errors[] = "Please enter a valid year (1990 - " . (date('Y')+1) . ").";

    if (empty($errors)) {
        $agency_id = $_SESSION['user_id'];
        $sql = "INSERT INTO cars (agency_id, model, vehicle_number, seating_capacity, rent_per_day, fuel_type, transmission, year, color, image_url, status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'available')";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "issidssiss", 
            $agency_id, $model, $vehicle_number, $seating_capacity, $rent_per_day, 
            $fuel_type, $transmission, $year, $color, $image_url
        );

        if (mysqli_stmt_execute($stmt)) {
            $success = true;
            // Clear form
            $_POST = [];
        } else {
           
                $errors[] = "Database error: " . mysqli_error($conn);
            
        }
        mysqli_stmt_close($stmt);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Car | Dream Drive</title>
    <link rel="stylesheet" href="/car/style.css">
    
</head>
<body>
    
<?php include('../reuse/navbar.php'); ?>

    <main class="add-car-page">
        <div class="container">
            <div class="form-card">
                <h2>Add New Car</h2>
                <p>List your luxury vehicle in our fleet</p>

                <?php if ($success): ?>
                    <div class="success-message">
                        Car added successfully! <a href="myCars.php">View My Cars</a>
                    </div>
                <?php elseif (!empty($errors)): ?>
                    <div class="error-message">
                        <?php foreach ($errors as $err): ?>
                            <p><?php echo htmlspecialchars($err); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form action="" method="post" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group">
            <label for="model">Car Model *</label>
            <input type="text" id="model" name="model">
        </div>
        <div class="form-group">
            <label for="vehicle_number">Vehicle Number *</label>
            <input type="text" id="vehicle_number" name="vehicle_number">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="seating_capacity">Seating Capacity *</label>
            <input type="number" id="seating_capacity" name="seating_capacity" min="1" max="20">
        </div>
        <div class="form-group">
            <label for="rent_per_day">Rent per Day (₹) *</label>
            <input type="number" id="rent_per_day" name="rent_per_day" min="1" >
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="fuel_type">Fuel Type *</label>
            <select id="fuel_type" name="fuel_type" required>
                <option value="">Select Fuel Type</option>
                <option value="Petrol">Petrol</option>
                <option value="Diesel">Diesel</option>
                <option value="Electric">Electric</option>
                <option value="Hybrid">Hybrid</option>
            </select>
        </div>
        <div class="form-group">
            <label for="transmission">Transmission *</label>
            <select id="transmission" name="transmission" required>
                <option value="">Select Transmission</option>
                <option value="Manual">Manual</option>
                <option value="Automatic">Automatic</option>
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <label for="year">Year *</label>
            <input type="number" id="year" name="year" min="1990" max="2026">
        </div>
        <div class="form-group">
            <label for="color">Color</label>
            <input type="text" id="color" name="color" placeholder="e.g., Black, White, Silver">
        </div>
    </div>

    <div class="form-group full-width">
        <label for="image_url">Image URL (optional)</label>
        <input type="url" id="image_url" name="image_url" placeholder="https://example.com/car-image.jpg">
    </div>

    <div class="form-buttons">
        <button type="submit" class="btn btn-primary btn-dark">Add Car</button>
        <a href="../mydashboard/dashboard.php" class="btn btn-outline">Cancel</a>
    </div>
</form>

            </div>
        </div>
    </main>
    <?php include('../reuse/footer.php'); ?>
</body>
</html>