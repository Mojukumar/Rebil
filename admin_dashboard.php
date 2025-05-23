<?php
session_start(); // Start session for access control
$conn = new mysqli("localhost", "root", "", "user_management");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$sql = "SELECT * FROM contact_messages ORDER BY submitted_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <style>
      .nav-container {
  display: flex;
  justify-content: center; /* Centers content horizontally */
  align-items: center;     /* Aligns items vertically */
  gap: 20px;               /* Space between menu and user icon */
  flex-wrap: wrap;
}

.nav-links {
  display: flex;
  gap: 15px;
  list-style: none;
  padding: 0;
  margin: 0;
}
nav {
  display: flex;
  justify-content: center;
  align-items: center;
}

.user-dropdown {
  display: none;
  position: absolute;
  top: 100%;
  right: 0;
  background-color: white;
  border: 1px solid #ddd;
  padding: 10px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  z-index: 999;
  min-width: 160px;
}
.user-dropdown.active {
  display: block;
}

    </style>



</head>
<body>
  <!-- Top Bar -->
<div class="top-bar">
    <span class="contact-info">
        📍 777 Street, Bangalore, INDIA | 📞 +91 1234567890 | ✉ mahi@gmail.com
    </span>
    <span class="connect-with-us">
        <a href="#"><i class="fa-brands fa-instagram"></i></a>
        <a href="#"><i class="fa-brands fa-facebook"></i></a>
        <a href="#"><i class="fa-brands fa-twitter"></i></a>
        <a href="#"><i class="fa-brands fa-linkedin"></i></a>
        <a href="#"><i class="fa-brands fa-youtube"></i></a>
    </span>
</div>


   <!-- Navbar -->
<nav class="navbar">
    <div class="logo-container">
        <img src="uploads/1743837369_icon.png" alt="Logo" class="logo" style="height: 40px;">
        </div>


    <div class="header-info2 d-flex align-items-center position-relative">
    
</div>


    

<span class="hamburger" id="menuToggle">☰</span>

<!-- Flex container -->
<div class="nav-container">
  <ul class="nav-links fs-4" id="navMenu">
    <li><a href="home.html" id="service-link">Home <span class="loading-line"></span></a></li>
    <li><a href="pricing.html" id="pricing-link">Pricing <span class="loading-line"></span></a></li>
    <li class="dropdown">
      <a href="#" id="support-link">Features <span class="caret">▾</span></a>
      <ul class="dropdown-menu">
        <li><a href="candidate.html">Candidate Sourcing</a></li>
        <li><a href="careersite.html">Career Site</a></li>
        <li><a href="resumemanagement.html">Resume Management</a></li>
        <li><a href="backgroundscreening.html">Background Screening</a></li>
      </ul>
    </li>
    <li><a href="solutions.html" id="contact-link">Solutions <span class="loading-line"></span></a></li>
    <li><a href="contact.html" id="help-link">Contact <span class="loading-line"></span></a></li>
  </ul>

  <!-- User Icon -->
  <div class="header-media user-dropdown-toggle" onclick="toggleDropdown()">
    <i class="bi bi-person-circle" style="font-size: 30px; cursor: pointer;"></i>
  </div>

  <!-- Dropdown Menu -->
  <div id="userDropdown" class="user-dropdown">
    <div class="user-info">
      <!-- <h6><?php echo htmlspecialchars($username ?? 'Guest'); ?></h6>
      <p><?php echo htmlspecialchars($user_type ?? 'Unknown'); ?></p> -->
    </div>
    <hr>
    <ul>
      <li><a href="signIn.html">Logout</a></li>
      <li><a href="admin_dashboard.php">Admin Dashboard</a></li>
    </ul>
  </div>
</div>
</nav>



<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center">
    <h2>Contact Messages</h2>
    
  </div>
  <table class="table table-bordered table-striped mt-3">
    <thead class="bg-primary text-white fs-3">
      <tr>
        
        <th>Name</th>
        <th>Email</th>
        <th>Subject</th>
        <th>Message</th>
        <th>Submitted At</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            
            <td><?= htmlspecialchars($row["name"]) ?></td>
            <td><?= htmlspecialchars($row["email"]) ?></td>
            <td><?= htmlspecialchars($row["subject"]) ?></td>
            <td><?= htmlspecialchars($row["message"]) ?></td>
            <td><?= $row["submitted_at"] ?></td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="6" class="text-center">No messages found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Footer Section -->
<footer class="footer mt-5 py-4">
    <div class="container">
        <div class="footer-container">
            <!-- Column 1: REBIL Recruit -->
            <div>
                <h3 class="footer-title">REBIL Recruit</h3>
                <p>Recruit's world-class recruitment software will help you find, evaluate, and communicate with candidates for any role.</p>
                <p>A more efficient hiring process means new hires that add more value to your organization or clients.</p>
            </div>

            <!-- Column 2: Get in Touch -->
            <div>
                <h3 class="footer-title">Get In Touch</h3>
                <p>777 Street, Bangalore, INDIA</p>
                <p>mahi@gmail.com</p>
                <p>+91 1234567890</p>
            </div>

            <!-- Column 3: Quick Links -->
            <div>
                <h3 class="footer-title">Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="home.html">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Our Services</a></li>
                    <li><a href="#">Latest Blog</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                </ul>
            </div>

            <!-- Column 4: Popular Links -->
            <div>
                <h3 class="footer-title">Popular Links</h3>
                <ul class="footer-links">
                    <li><a href="home.html">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Our Services</a></li>
                    <li><a href="#">Latest Blog</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                </ul>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="text-center mt-4">
            <p>© Rebil. All Rights Reserved. Designed by <a href="https://www.ttglobalit.com/">TT Global</a></p>
        </div>
    </div>
</footer>
    
    
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"> </script>
        <script src="script.js"></script>
        <script>
  function toggleDropdown() {
    const dropdown = document.getElementById("userDropdown");
    dropdown.classList.toggle("active");
  }

  // Optional: Close dropdown if clicked outside
  document.addEventListener("click", function (event) {
    const dropdown = document.getElementById("userDropdown");
    const toggleBtn = document.querySelector(".user-dropdown-toggle");

    if (!toggleBtn.contains(event.target) && !dropdown.contains(event.target)) {
      dropdown.classList.remove("active");
    }
  });
</script>

</body>
</html>

<?php $conn->close(); ?>
