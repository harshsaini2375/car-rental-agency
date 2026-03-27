<?php
session_start();
include '../config.php';

// Fetch all available cars
$cars = [];
$sql = "SELECT car_id, model, vehicle_number, seating_capacity, rent_per_day, 
               fuel_type, transmission, year, color, image_url 
        FROM cars 
        WHERE status = 'available' 
        ORDER BY rent_per_day ASC";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $cars[] = $row;
}
mysqli_free_result($result);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Fleet | Dream Drive</title>
    <link rel="stylesheet" href="/car/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   
</head>
<body>
    <?php include('../reuse/navbar.php'); ?>
    <main class="fleet-page">
        <div class="container">
            <div class="fleet-header">
                <h1>Our Premium Cars</h1>
                <p>Experience luxury, comfort, and performance</p>
            </div>

            <div class="cars-grid">
                <?php if (empty($cars)): ?>
                    <p class="empty-message">No cars available at the moment. Check back soon!</p>
                <?php else: ?>
                    <?php foreach ($cars as $car): ?>
                        <div class="car-card">

                            <div class="car-image-placeholder">
                                <?php if (!empty($car['image_url'])): ?>
                                    <img src="<?php echo htmlspecialchars($car['image_url']); ?>" alt="<?php echo htmlspecialchars($car['model']); ?>" style="width:100%; height:100%; object-fit:cover;">
                                <?php else: ?>
                                    <!-- this is logo of car <i> tag -->
                                    <i class="fas fa-car-side"></i>
                                <?php endif; ?>
                            </div>

                            <h3 class="car-model"><?php echo htmlspecialchars($car['model']); ?></h3>

                            <div class="car-details">
                                <p><i class="fas fa-id-card"></i> <strong>Vehicle No:</strong> <?php echo htmlspecialchars($car['vehicle_number']); ?></p>
                                <p><i class="fas fa-users"></i> <strong>Seating:</strong> <?php echo $car['seating_capacity']; ?> persons</p>
                                <p><i class="fas fa-tag"></i> <strong>Rent:</strong> ₹<?php echo number_format($car['rent_per_day']); ?> <span>/ day</span></p>
                                <?php if (!empty($car['fuel_type'])): ?>
                                    <p><i class="fas fa-gas-pump"></i> <?php echo $car['fuel_type']; ?></p>
                                <?php endif; ?>
                                <?php if (!empty($car['transmission'])): ?>
                                    <p><i class="fas fa-cog"></i> <?php echo $car['transmission']; ?></p>
                                <?php endif; ?>
                            </div>

                            
                             <!-- Show rental form only if user is logged in as customer -->
                            <?php
                            $show_form = false;
                            if (isset($_SESSION['user_id']) && isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'customer') {
                                $show_form = true;
                            }
                            ?>

                            <?php if ($show_form): ?>

                                <form action="../customer/processBooking.php" method="post" class="rental-form">
                                    <!-- hidden , we need this car id in backend when processing booking -->
                                    <input type="hidden" name="car_id" value="<?php echo $car['car_id']; ?>">
                                    <label for="days_<?php echo $car['car_id']; ?>">Number of days:</label>
                                    <select name="days" id="days_<?php echo $car['car_id']; ?>" required>
                                        <option value="1">1 day</option>
                                        <option value="2">2 days</option>
                                        <option value="3">3 days</option>
                                        <option value="4">4 days</option>
                                        <option value="5">5 days</option>
                                        <option value="6">6 days</option>
                                        <option value="7">1 week (7 days)</option>
                                        <option value="14">2 weeks (14 days)</option>
                                        <option value="21">3 weeks (21 days)</option>
                                        <option value="30">1 month (30 days)</option>
                                    </select>
                                    <label for="start_date_<?php echo $car['car_id']; ?>">Start date:</label>
                                    <!-- min ensure, we select only future date not any past date -->
                                    <input type="date" name="start_date" id="start_date_<?php echo $car['car_id']; ?>" min="<?php echo date('Y-m-d'); ?>" required style="margin-bottom: 15px" >
                                    <button type="submit" class="rent-btn">Rent Car <i class="fas fa-arrow-right"></i></button>
                                </form>

                                    <!-- if user is not logged in then -->
                            <?php elseif (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'agency'): ?>
                                <div class="login-prompt">
                                    Agencies cannot rent cars. <a href="login.php">Switch to customer account?</a>
                                </div>
                                <!-- if no one logged in neither customer nor agency -->
                            <?php else: ?>
                                <div class="login-prompt">
                                    <a href="login.php">Log in</a> as a customer to rent this car.
                                </div>
                            <?php endif; ?>


                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php include('../reuse/footer.php'); ?>
</body>
</html>