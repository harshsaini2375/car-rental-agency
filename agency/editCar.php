<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'agency') {
    header('Location: login.php');
    exit;
}

include '../config.php';

$car_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$agency_id = $_SESSION['user_id'];

// Fetch current car details
$car = null;
$sql = "SELECT * FROM cars WHERE car_id = ? AND agency_id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ii", $car_id, $agency_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$car = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

// If car not found or not owned by agency, redirect
if (!$car) {
    header('Location: myCars.php');
    exit;
}

$success = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get input dada
    $model = trim($_POST['model'] ?? '');
    $vehicle_number = trim($_POST['vehicle_number'] ?? '');
    $seating_capacity = (int)($_POST['seating_capacity'] ?? 0);
    $rent_per_day = (float)($_POST['rent_per_day'] ?? 0);
    $fuel_type = $_POST['fuel_type'] ?? '';
    $transmission = $_POST['transmission'] ?? '';
    $year = (int)($_POST['year'] ?? 0);
    $color = trim($_POST['color'] ?? '');
    $image_url = trim($_POST['image_url'] ?? '');
    $status = $_POST['status'] ?? 'available';

    // Validation if data enterd is correct format or not
    if (empty($model)) $errors[] = "Car model is required.";
    if (empty($vehicle_number)) $errors[] = "Vehicle number is required.";
    if ($seating_capacity <= 0) $errors[] = "Seating capacity must be at least 1.";
    if ($rent_per_day <= 0) $errors[] = "Rent per day must be greater than 0.";
    if (!in_array($fuel_type, ['Petrol', 'Diesel', 'Electric', 'Hybrid'])) $errors[] = "Please select a valid fuel type.";
    if (!in_array($transmission, ['Manual', 'Automatic'])) $errors[] = "Please select a valid transmission.";
    if ($year < 1990 || $year > date('Y') + 1) $errors[] = "Please enter a valid year (1990 - " . (date('Y')+1) . ").";
    if (!in_array($status, ['available', 'rented', 'maintenance'])) $errors[] = "Invalid status.";

    if (empty($errors)) {
        // Update the car
        $sql = "UPDATE cars SET model = ?, vehicle_number = ?, seating_capacity = ?, rent_per_day = ?, 
                fuel_type = ?, transmission = ?, year = ?, color = ?, image_url = ?, status = ? 
                WHERE car_id = ? AND agency_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssidssisssii", 
            $model, $vehicle_number, $seating_capacity, $rent_per_day,
            $fuel_type, $transmission, $year, $color, $image_url, $status,
            $car_id, $agency_id
        );

        if (mysqli_stmt_execute($stmt)) {
            $success = true;
            // Refresh car data after update
            $car['model'] = $model;
            $car['vehicle_number'] = $vehicle_number;
            $car['seating_capacity'] = $seating_capacity;
            $car['rent_per_day'] = $rent_per_day;
            $car['fuel_type'] = $fuel_type;
            $car['transmission'] = $transmission;
            $car['year'] = $year;
            $car['color'] = $color;
            $car['image_url'] = $image_url;
            $car['status'] = $status;
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
    <title>Edit Car | Dream Drive</title>
    <link rel="stylesheet" href="/car/style.css">
   
</head>
<body>
    <?php include('../reuse/navbar.php'); ?>
    <main class="edit-car-page">
        <div class="container">
            <div class="form-card">
                <h2>Edit Car</h2>
                <p>Update your car details</p>

                <?php if ($success): ?>
                    <div class="success-message">
                        Car updated successfully! <a href="myCars.php">Back to My Cars</a>
                    </div>
                <?php elseif (!empty($errors)): ?>
                    <div class="error-message">
                        <?php foreach ($errors as $err): ?>
                            <p><?php echo htmlspecialchars($err); ?></p>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form action="" method="post">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="model">Car Model *</label>
                            <input type="text" id="model" name="model" value="<?php echo htmlspecialchars($car['model']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="vehicle_number">Vehicle Number *</label>
                            <input type="text" id="vehicle_number" name="vehicle_number" value="<?php echo htmlspecialchars($car['vehicle_number']); ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="seating_capacity">Seating Capacity *</label>
                            <input type="number" id="seating_capacity" name="seating_capacity" min="1" max="20" value="<?php echo $car['seating_capacity']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="rent_per_day">Rent per Day (₹) *</label>
                            <input type="number" id="rent_per_day" name="rent_per_day" min="1" value="<?php echo $car['rent_per_day']; ?>" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="fuel_type">Fuel Type *</label>
                            <select id="fuel_type" name="fuel_type" required>
                                <option value="">Select Fuel Type</option>
                                <option value="Petrol" <?php echo ($car['fuel_type'] == 'Petrol') ? 'selected' : ''; ?>>Petrol</option>
                                <option value="Diesel" <?php echo ($car['fuel_type'] == 'Diesel') ? 'selected' : ''; ?>>Diesel</option>
                                <option value="Electric" <?php echo ($car['fuel_type'] == 'Electric') ? 'selected' : ''; ?>>Electric</option>
                                <option value="Hybrid" <?php echo ($car['fuel_type'] == 'Hybrid') ? 'selected' : ''; ?>>Hybrid</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="transmission">Transmission *</label>
                            <select id="transmission" name="transmission" required>
                                <option value="">Select Transmission</option>
                                <option value="Manual" <?php echo ($car['transmission'] == 'Manual') ? 'selected' : ''; ?>>Manual</option>
                                <option value="Automatic" <?php echo ($car['transmission'] == 'Automatic') ? 'selected' : ''; ?>>Automatic</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="year">Year *</label>
                            <input type="number" id="year" name="year" min="1990" max="2026" value="<?php echo $car['year']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="color">Color</label>
                            <input type="text" id="color" name="color" value="<?php echo htmlspecialchars($car['color']); ?>" placeholder="e.g., Black, White, Silver">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="status">Status *</label>
                            <select id="status" name="status" required>
                                <option value="available" <?php echo ($car['status'] == 'available') ? 'selected' : ''; ?>>Available</option>
                                <option value="rented" <?php echo ($car['status'] == 'rented') ? 'selected' : ''; ?>>Rented</option>
                                <option value="maintenance" <?php echo ($car['status'] == 'maintenance') ? 'selected' : ''; ?>>Maintenance</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image_url">Image URL (optional)</label>
                            <input type="url" id="image_url" name="image_url" value="<?php echo htmlspecialchars($car['image_url']); ?>" placeholder="https://example.com/car-image.jpg">
                        </div>
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn btn-primary btn-dark">Update Car</button>
                        <a href="myCars.php" class="btn-outline">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php include('../reuse/footer.php'); ?>
</body>
</html>