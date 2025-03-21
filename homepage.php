<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Faculty Logbook</title>
    <!-- Removed Bootstrap CSS link -->
    <link rel="stylesheet" href="homepage.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=League+Spartan:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&family=Raleway:ital,wght@0,100..900;1,100..900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <style>
        html,
        body {
            height: 100%;
        }

        .fade-in {
            opacity: 0;
            transition: opacity 0.6s ease-in;
        }

        .fade-in.show {
            opacity: 1;
        }

        .button-wrapper {
            width: 100%;
            max-width: 900px;
            margin-bottom: 1rem; /* Replaced Bootstrap mb-3 */
        }

        .button {
            width: 100%;
            max-width: 900px;
            display: flex; /* Replaced Bootstrap d-flex */
            align-items: center; /* Replaced Bootstrap align-items-center */
            text-decoration: none;
            background-color: #0d6efd; /* Replaced Bootstrap btn-primary */
            color: white;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            font-weight: 400;
            text-align: center;
            border: 1px solid transparent;
            cursor: pointer;
        }

        .button img {
            width: 40px;
            height: 40px;
            margin-right: 0.5rem; /* Replaced Bootstrap mr-2 */
        }

        .button p {
            margin: 0; /* Replaced Bootstrap mb-0 */
            font-size: 1em;
        }

        .ofl-logo-container {
            position: absolute;
            top: 60px;
            right: 0;
            z-index: 5;
        }

        .flex-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .flex-content {
            flex: 1;
            margin-top: 80px;
        }

        .content-container {
            position: relative;
            z-index: 10;
        }
        
        .buttons {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
    </style>
</head>

<body class="fade-in">
    <div class="flex-container">
        <div class="nav">
            <img src="Assets/Logo.png" alt="Umak Logo">
            <img src="Assets/OSHO-LOGO.webp" alt="OSHO logo">
            <h2>Online Faculty Logbook</h2>
            <a href="index.php" class="logout-btn">Log In</a>
        </div>
        <div class="ofl-logo-container">
            <img src="Assets/OFLLogo.png" alt="UMak Logo">
        </div>
        <div class="content-container flex-content">
            <div class="introduction">
                <div class="text-buttons">
                    <h1>Welcome to UMak Online Faculty Logbook</h1>
                    <h2>A platform designed to streamline faculty logging and student consultations</h2>
                    <div class="buttons">
                        <div class="button-wrapper">
                            <a href="#about" class="button">
                                <img src="Assets/i.png" alt="Info Icon">
                                <p>About the Website</p>
                            </a>
                        </div>
                        <div class="button-wrapper">
                            <a href="#guides" class="button">
                                <img src="Assets/Guide.png" alt="Guide Icon">
                                <p>Guides for the Online Logbook</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <!-- Footer content unchanged -->
            <div class="info">
                <div class="ohsologo-container">
                    <h2>Occupational Health and Safety Office</h2>
                    <img src="Assets/OSHO-LOGO.webp" alt="OHSO Logo" class="ohsologo">
                </div>
                <div class="contact-info">
                    <h2>Contact OHSO</h2>
                    <ul>
                        <li>
                            <img src="Assets/gmail.png" alt="Gmail Icon">
                            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=ohso@umak.edu.ph" target="_blank"><span>ohso@umak.edu.ph</span></a>
                        </li>
                        <li>
                            <img src="Assets//phone-call.png" alt="Phone Icon">
                            <span>288820535</span>
                        </li>
                        <li>
                            <img src="Assets/facebook.png" alt="Facebook Icon">
                            <a href="https://www.facebook.com/profile.php?id=100076383932855" target="_blank"><span>UMak Occupational Health and Safety Office</span></a>
                        </li>
                    </ul>
                </div>
                <div class="location-info">
                    <h2>Ohso Office</h2>
                    <ul>
                        <li>
                            <img src="Assets/map.png" alt="Map Icon">
                            <a href="https://www.google.com/maps/place/University+of+Makati/@14.5631001,121.0569066,18z/data=!4m6!3m5!1s0x3397c860ad20d9e9:0xeeb71061020f655a!8m2!3d14.5633428!4d121.0565387!16s%2Fm%2F05c17ym?entry=ttu&g_ep=EgoyMDI1MDMxNi4wIKXMDSoASAFQAw%3D%3D" target="_blank"><span>J.P. Rizal Extn. West Rembo, Makati, Philippines, 1215</span></a>
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
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.body.classList.add('show');
        });
    </script>
    <!-- Removed Bootstrap JS script -->
</body>

</html>