document.addEventListener("DOMContentLoaded", function () {
    /*** 🔹 Toggle Hamburger Menu ***/
    const menuToggle = document.getElementById("menuToggle");
    const navMenu = document.getElementById("navMenu");

    if (menuToggle && navMenu) {
        menuToggle.addEventListener("click", function () {
            navMenu.classList.toggle("active"); // Toggle class for menu visibility
        });
    }

    /*** 🔹 Toggle Search Popup ***/
    const searchIcon = document.getElementById("search-icon");
    const searchPopup = document.getElementById("search-popup");
    const closeBtn = document.getElementById("close-btn");

    if (searchIcon && searchPopup && closeBtn) {
        searchIcon.addEventListener("click", (e) => {
            e.preventDefault();
            searchPopup.style.display = "block";
        });

        closeBtn.addEventListener("click", () => {
            searchPopup.style.display = "none";
        });

        window.addEventListener("click", (e) => {
            if (e.target === searchPopup) {
                searchPopup.style.display = "none";
            }
        });
    }

    /*** 🔹 Toggle Social Icons in Mobile View ***/
    const socialToggle = document.getElementById("socialToggle");

    if (socialToggle) {
        socialToggle.addEventListener("click", function () {
            this.classList.toggle("active");
        });
    }

    /*** 🔹 Dropdown Menu Toggle ***/
    const dropdown = document.querySelector(".dropdown");
    const dropdownMenu = document.querySelector(".dropdown-menu");

    if (dropdown && dropdownMenu) {
        dropdown.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default click behavior
            dropdownMenu.classList.toggle("show");
        });

        // Close dropdown if clicked outside
        document.addEventListener("click", function (e) {
            if (!dropdown.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.remove("show");
            }
        });
    }
});


document.querySelectorAll('.dropdown-menu a').forEach(function(link) {
    link.addEventListener('click', function(e) {
      window.location.href = this.getAttribute('href');
    });
  });



  $("#profileButton").click(function () {
    $("#profileSidebar").load("profile_sidebar.php", function () {
        $("#profileSidebar").fadeIn();
    });
});



document.querySelectorAll('.dropdown-menu a').forEach(function(link) {
    link.addEventListener('click', function(e) {
        e.preventDefault(); // Prevent the default behavior to allow custom navigation
        
        const targetUrl = this.getAttribute('href');
        console.log("Navigating to:", targetUrl);
        
        // Allowing navigation to the target URL
        window.location.href = targetUrl;
    });
});