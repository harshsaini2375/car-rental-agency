<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <title>Dream Drive | Luxury Car Rental</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- nav bar -->
<?php include('reuse/navbar.php'); ?>

  <main>
    <!-- hero section -->
    <section id="home" class="hero">
      <div class="hero-overlay"></div>
      <div class="hero-content">
        <h1>Drive Your Dream Car</h1> 
        <p class="hero-tagline">Anytime Anywhere</p>
        <p class="hero-description">
          Dream Drive offers curated luxury cars, quick booking, and seamless rental experience.
        </p>
        <a href="public/availableCars.php" class="btn btn-primary">Browse Our Cars</a>
      </div>
    </section>

    <!-- brand section  -->
    <section id="brands" class="brands-section">
      <div class="container">
        <div class="section-header">
          <h2>Our Fleet & Car Brands</h2>
          <p>Exclusive selection of premium vehicles for every journey</p>
        </div>
        <div class="brands-grid">
          <div class="brand-card">
            <span class="brand-name">BMW</span>
            <span class="brand-note">Performance & Luxury</span>
          </div>
          <div class="brand-card">
            <span class="brand-name">Cadillac</span>
            <span class="brand-note">American Prestige</span>
          </div>
          <div class="brand-card">
            <span class="brand-name">GMC</span>
            <span class="brand-note">Strength & Style</span>
          </div>
          <div class="brand-card">
            <span class="brand-name">Mercedes-Benz</span>
            <span class="brand-note">Engineered Elegance</span>
          </div>
          <div class="brand-card">
            <span class="brand-name">NISSAN</span>
            <span class="brand-note">Innovation & Power</span>
          </div>
          <div class="brand-card">
            <span class="brand-name">HUM</span>
            <span class="brand-note">Hummer · Bold Spirit</span>
          </div>
        </div>
        <div class="fleet-cta">
          <a href="public/availableCars.php" class="btn btn-outline">View Full Cars →</a>
        </div>
      </div>
    </section>

    <!-- services -->
    <section id="services" class="services-section">
      <div class="container">
        <div class="section-header">
          <h2>Our Services</h2>
          <p>Drive with confidence, flexibility, and premium care</p>
        </div>
        <div class="services-grid">
          <div class="service-card">
            <div class="service-icon">🚗</div>
            <h3>Quick Booking</h3>
            <p>Reserve your dream car in minutes — online or mobile, hassle-free.</p>
          </div>
          <div class="service-card">
            <div class="service-icon">🔑</div>
            <h3>Lease To Own</h3>
            <p>Flexible lease programs that let you drive now with an option to own.</p>
          </div>
          <div class="service-card">
            <div class="service-icon">🛡️</div>
            <h3>Premium Support</h3>
            <p>24/7 roadside assistance and dedicated concierge service.</p>
          </div>
          <div class="service-card">
            <div class="service-icon">✨</div>
            <h3>Curated Luxury</h3>
            <p>Hand-picked fleet of high-end vehicles, maintained to perfection.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- lease -->
    <section id="lease" class="lease-highlight">
      <div class="container lease-flex">
        <div class="lease-text">
          <h2>Lease To Own – Drive Today, Own Tomorrow</h2>
          <p>Our exclusive Lease To Own program gives you the freedom to enjoy a luxury car with a pathway to ownership. No hidden fees, tailored monthly plans, and full support.</p>
          <a href="#" class="btn btn-dark">Explore Lease Plans</a>
        </div>
        <div class="lease-note">
          <p>✓ Flexible terms 12–60 months</p>
          <p>✓ Low mileage options & upgrades</p>
          <p>✓ Trade‑in opportunities</p>
        </div>
      </div>
    </section>

    <!-- footer -->
    <!-- about, contact info -->
    <?php include('reuse/footer.php'); ?>
  </main>
</body>
</html>