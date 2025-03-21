<!-- filepath: c:\xampp\htdocs\Website\Studentview\credits.php -->
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credits</title>
    <link rel="stylesheet" href="credits.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=League+Spartan:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Raleway:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900&display=swap" rel="stylesheet">
    <style>
        .fade-in {
            opacity: 0;
            transition: opacity 0.6s ease-in;
        }

        .fade-in.show {
            opacity: 1;
        }
    </style>
</head>

<body class="fade-in">
    <div class="nav">
        <img src="Logo.png" alt="Umak Logo">
        <img src="OSHO-LOGO.webp" alt="OSHO logo">
        <h2>Online Faculty Logbook</h2>
        <div class="line"></div>

        <div class="hamburger-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>

        <ul data-title="Online Faculty Logbook">
            <li><a href="account.php" class="active">Your Schedule</a></li>
            <li><a href="registration.php">Registration</a></li>
            <li><a href="facultymap.html">Faculty Map</a></li>
            <li class="mobile-logout"><a href="../index.php">Log Out</a></li>
        </ul>
        <a href="../index.php" class="logout-btn">Log Out</a>
    </div>
    <div class="credits">
        <h1>Credits</h1>
        <p>This project was made possible by the following contributors:</p>
        <div class="credits-row">
            <div class="credit-item">
                <img src="OSHO-LOGO.webp" alt="Contributor Image">
                <h2>Sean Dale Aming</h2>
                <p>Faculty Map</p>
            </div>
            <div class="credit-item">
                <img src="Japhette.jpg" alt="Contributor Image">
                <h2>Japhette Louis C. Magpulong</h2>
                <p>Front-End & Back-End Programmer</p>
            </div>
            <div class="credit-item">
                <img src="OSHO-LOGO.webp" alt="Contributor Image">
                <h2>Claudine De Guzman</h2>
                <p>Faculty Map</p>
            </div>
            <div class="credit-item">
                <img src="OSHO-LOGO.webp" alt="Contributor Image">
                <h2>Jyro Azrael Torres</h2>
                <p>Faculty Map</p>
            </div>
        </div>
        <p>Special thanks to:</p>
        <div class="credits-row">
            <div class="credit-item">
                <img src="OrlandoBenedicto.jpg" alt="Special Thanks Image">
                <h2>Orlando Benedicto</h2>
                <p>Project Client and Advisor</p>
            </div>
            <div class="credit-item">
                <img src="ArielDomingo.jpg" alt="Special Thanks Image">
                <h2>Ariel Domingo</h2>
                <p>Teacher</p>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="info">
            <div class="ohsologo-container">
                <h2>Occupational Health and Safety Office</h2>
                <img src="OSHO-LOGO.webp" alt="OHSO Logo" class="ohsologo">
            </div>
            <div class="contact-info">
                <h2>Contact OHSO</h2>
                <ul>
                    <li>
                        <img src="gmail.png" alt="Gmail Icon">
                        <span>ohso@umak.edu.ph</span>
                    </li>
                    <li>
                        <img src="phone-call.png" alt="Phone Icon">
                        <span>288820535</span>
                    </li>
                    <li>
                        <img src="facebook.png" alt="Facebook Icon">
                        <a href="https://www.facebook.com/profile.php?id=100076383932855"><span>UMak Occupational Health and Safety Office </span></a>
                    </li>
                </ul>
            </div>
            <div class="location-info">
                <h2>Ohso Office</h2>
                <ul>
                    <li>
                        <img src="map.png" alt="Map Icon">
                        <span>J.P. Rizal Extn. West Rembo, Makati, Philippines, 1215</span>
                    </li>
                </ul>
                <div class="feedback">
                    <h2>Feedback</h2>
                    <p>Please take a moment to fill out our Google Form for our research:</p>
                    <a href="https://forms.gle/your-google-form-link" target="_blank" class="feedback-link">Google Forms</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="copyright">
                <p>&copy; <?php echo date("Y"); ?> Online Faculty Logbook. All rights reserved. Icons and code used are copyrighted by their respective owners.</p>
            </div>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('show');
        });
    </script>
</body>

</html>