<?php include 'connectDB.php';
include 'header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="StyleIndex.css">
</head>
<body>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    ?>

    <section class="hero">
        <div class="container">
            <h1>Give Life</h1>
            <div class="zoom-container">
                <img src="img/awarness.jpg" alt="Blood Donation" class="zoom-image" style="max-width: 100%; border-radius: 8px;">
            </div>
        </div>
    </section>

    <section class="parallax" style="background-image: url('img/bgBloodBank.jpeg');">
        <div class="container">
            <h2 style="color: white; text-align: center; padding-top: 150px;">Every Drop Counts</h2>
        </div>
    </section>

    <section class="impact">
        <div class="container">
            <h2>Our Impact</h2>
            <div class="impact-stats">
                <div class="stat">
                    <span class="counter">5000</span>
                    <p>Lives Saved</p>
                </div>
                <div class="stat">
                    <span class="counter">10000</span>
                    <p>Donations</p>
                </div>
                <div class="stat">
                    <span class="counter">500</span>
                    <p>Events Organized</p>
                </div>
            </div>
        </div>
    </section>

    <!--rewards preview-->
    <section class="rewards-program">
    <section class="rewards-program">
    <div class="container">
        <h2 class="rewards-title">Blood Donation Rewards Program</h2>
        <p class="rewards-tagline">Save Lives and Earn Rewards</p>
        
        <div class="rewards-intro">
            <p>At Blood Bank, we believe in recognizing and appreciating our donors' selfless contributions. With our new <strong>Blood Donation Rewards Program</strong>, you not only save lives but also earn points that you can redeem for exciting rewards!</p>
        </div>
        
        <div class="rewards-how-it-works">
            <h3>How It Works</h3>
            <ol class="rewards-steps">
                <li><strong>Donate Blood:</strong> Every time you donate blood, you earn points.</li>
                <li><strong>Earn Points:</strong> The more you donate, the more points you accumulate. Special donation events and milestones offer bonus points!</li>
                <li><strong>Redeem Rewards:</strong> Use your points to redeem a variety of rewards, from gift cards to exclusive merchandise.</li>
            </ol>
        </div>

        <div class="rewards-why-donate">
            <h3>Why Donate?</h3>
            <ul class="why-donate-list">
                <li><i class="fas fa-heart"></i> <strong>Save Lives:</strong> Your blood donations help patients in need and save countless lives.</li>
                <li><i class="fas fa-users"></i> <strong>Community Impact:</strong> Be a hero in your community and inspire others to join the cause.</li>
                <li><i class="fas fa-medkit"></i> <strong>Personal Benefits:</strong> Regular blood donations can have health benefits, such as reducing iron levels and improving cardiovascular health.</li>
            </ul>
        </div>

        <?php
        // Fetch the redeem points from the database
        $sql = "SELECT * FROM redeempoint";
        $result = $conn->query($sql);
        ?>

        <section class="initiatives">
            <div class="container">
                <h2>Feature Rewards</h2>
                <div class="initiative-grid">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <div class="initiative-card">
                            <div class="initiative-card-inner">
                                <div class="initiative-card-front">
                                    <h3><?php echo htmlspecialchars($row['Redeem_Name']); ?></h3>
                                    <h4><?php echo htmlspecialchars($row['Redeem_PointValue']); ?> Points</h4>
                                    <?php if (!empty($row['Redeem_pic'])) { ?>
                                        <img src="img/<?php echo htmlspecialchars($row['Redeem_pic']); ?>" alt="<?php echo htmlspecialchars($row['Redeem_Name']); ?>" class="reward-image">
                                    <?php } ?>
                                </div>
                                <div class="initiative-card-back">
                                    <p><?php echo htmlspecialchars($row['Redeem_Desc']); ?></p>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="center-button">
                    <a href="reward.php" class="btn">Explore More</a>
                </div>
            </div>
        </section>

        <?php
        $conn->close();
        ?>
        
        
        <div class="rewards-cta">
            <h3>Join Our Community</h3>
            <p>Sign up today and start earning points with your first donation. Together, we can make a difference!</p>
            <a href="signUp.php" class="btn rewards-btn">Sign Up Now</a>
        </div>
    </div>    </section>


    <section class="mission">
    <div class="container">
            <h2>Our Vission</h2>
            <p>Our Vission is to save lives by connecting generous blood donors with those in need, while educating and inspiring our community about the importance of regular blood donation. We strive to make the donation process easy, accessible, and rewarding for all participants, ensuring a stable and sufficient blood supply for medical emergencies, surgeries, and treatments</p>
            <h2>Our Mission</h2>
            <p>"We envision a world where no life is lost due to a shortage of blood. Our vision is to create a global network of committed donors, advanced healthcare facilities, and efficient distribution systems that work seamlessly to meet all blood transfusion needs. We aim to foster a culture where blood donation is viewed as a regular act of community service, empowering individuals to make a direct impact on saving lives."
             <ol>
                <li>the life-saving aspect of blood donation</li>
                <li>Focusing on community engagement and education</li>
                <li>Highlighting the importance of accessibility and ease of donation</li>
                <li>Stressing the need for a stable and sufficient blood supply</li>
                <li>Promoting a global perspective on blood donation</li>
                <li>Encouraging regular donation as a part of community service</li>
            </ol>
        </div>    
    </section>

    

    <section class="follow-us">
    <div class="container">
            <h2>Follow Us in Exploring the beuty of information</h2>
            <div style="display: flex; flex-wrap: wrap; justify-content: space-around;">
                <img src="img/bloodsupply.jpg" alt="Social Image 1" style="width: 23%;">
                <img src="img/slide1.png" alt="Social Image 2" style="width: 23%;">
                <img src="img/slide2.png" alt="Social Image 3" style="width: 23%;">
                <img src="img/slide3.png" alt="Social Image 4" style="width: 23%;">
            </div>
            <a href="#" class="btn">View More</a>
        </div>    </section>

    <?php include("footer.php"); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
    $(document).ready(function() {
        $('.counter').each(function () {
            $(this).prop('Counter',0).animate({
                Counter: $(this).text()
            }, {
                duration: 4000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    });

    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
    </script>
</body>
</html>