<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/styles/home.css">
    <!-- <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet"> -->
</head>

<!-- Nav Bar -->

<?php require __DIR__ . "/views/partials/nav.php"?>

<body>
    <!-- Section 1 -->

    <section class="section1">
        <div class="desc1">
            <img src="/styles/img/building.png" alt="Lab building" class="building">
            <h1>A REAL TIME LOCATION TRACKER FOR QCU VISITORS</h1>
            <p>At Quezon City University, We Believe In Creating A Safe And <br> Connected Environment For Our Students,
                Faculty, And Staff. That's <br> Why We've Developed A Cutting-Edge Location Tracking System To <br>
                Enhance Campus Security And Give You Peace Of Mind.</p>
            <div>
                <a href="#" class="register_btn">Register</a>
                <a href="#terms" class="contact_btn">Contact Us</a>
            </div>

        </div>
    </section>
    <hr>

    <!-- Section 2 -->

    <section class="section2">
        <div class="desc2">
            <img src="/styles/img/city.png" alt="City drawing" class="city">
            <h1 id="stay-aware">SECURE CAMPUS, EMPOWERED COMMUNITY</h1>
            <br>
            <h2>Stay Aware, Stay Secure</h2>
            <br>
            <p>Our Location Tracker Allows You to Monitor Your Position Within the <br> University Grounds, Ensuring You
                Can Quickly Identify Your Location and <br> Access Help If Needed. with Real-Time Updates and Intuitive
                Mapping, <br> You'll Always Know Where You Are and How to Reach the Nearest <br> Emergency Resources.
            </p>
        </div>

        <div class="desc3">
            <img src="styles/img/map.png" alt="Map drawing" class="map">
            <h1>SAFETY WITH PRIVACY-ORIENTED TRACKING </h1>
            <br>
            <p>By Leveraging the Power of Openstreetmap-Based Location Tracking, We're <br> Putting the Tools for a
                Secure Campus Directly in Your Hands While <br> Prioritizing Your Privacy. Whether You're Walking to
                Class, Studying Late, or<br>Attending an Event, Our System Keeps You Connected and Empowered to<br> Take
                Control of Your Safety Without Compromising Your Personal Information.</p>
        </div>

    </section>

    <!-- Section 3 -->

    <section class="section3">
        <div class="desc4">
            <img src="/styles/img/college_students.png" alt="students drawing" class="students">
            <h1>UNLOCK THE FULL POTENTIAL <br>OF CAMPUS LIFE</h1>
            <br>
            <p>Experience the Freedom to Explore Your University to the Fullest,<br> Knowing That Your Location Is Being
                Monitored for Your Protection<br> Using Open-Source Technology. Engage with the Vibrant Campus<br>
                Community, Participate in Extracurricular Activities, and Make the<br> Most of Your University
                Experience - All While Enjoying the Security<br> of Our Advanced Location Tracking System.</p>
        </div>

        <div class="desc5">
            <img src="styles/img/security.png" alt="security image" class="security">
            <h1>JOIN THE MOVEMENT FOR A SAFER, <br>
                PRIVACY-FOCUSED CAMPUS</h1>
            <br>
            <p>Discover How Quezon City University's Openstreetmap-Powered Location<br> Tracker Can Transform the Way
                You Experience Campus Life. Sign Up Today<br> and Take the First Step Towards a More Secure, Connected,
                and<br> Empowered University Community.</p>
        </div>
    </section>

</body>

<!-- Footer -->
<?php require __DIR__ . "/views/partials/footer.php"?>;

</html>