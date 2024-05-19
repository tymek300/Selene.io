<!DOCTYPE html>
<html lang="en">

<head>
    <title>About Us</title>

    <?php
        //Importing header tags
        include("../components/headerparams.php");
    ?>
</head>

<body>

    <?php
        // Importing header
        include('../components/headernav.php');

        //TryCatch block
        try
        {
            //Function for validating inputs
            function TestInputs($inputValue, $length = null)
            {
                if($length != null)
                {
                    // Testing if user didn't provide too long data in input form
                    if (strlen($inputValue) > $length)
                    {
                        FailureMessage("One of form input value exceeds the maximum allowed length.", "index.php");
                        die();
                    }
                }
                // Preventing XSS attacks
                $safeInput = htmlspecialchars($inputValue, ENT_QUOTES, 'UTF-8');
                return $safeInput;
            }

            //Checking if user send collaboration form properly
            if((isset($_GET['name']) && !empty($_GET['name'])) && (isset($_GET['company']) && !empty($_GET['company'])) && (isset($_GET['phone_number']) && !empty($_GET['phone_number'])) && (isset($_GET['type']) && !empty($_GET['type'])) && (isset($_GET['description']) && !empty($_GET['description'])))
            {
                foreach($_GET as $key => $value)
                {
                    TestInputs($value, 50);

                    if($key == 'phone_number')
                    {
                        $key = TestInputs($value, 15);
                    }
                    elseif($key == "description")
                    {
                        $key = TestInputs($value, 1000);
                    }
                }

                //If so, checking if he/she was logged in
                if(isset($_SESSION['userID']))
                {
                    //Inserting record to collaboration table with info about userID
                    $stmt = $conn->prepare("INSERT INTO collaboration (user_id, name, company, phone_number, type, description) VALUES (:userID, :name, :company, :phone_number, :type, :description)");
                    $stmt->bindParam(':userID', $_SESSION['userID'], PDO::PARAM_INT);
                }
                else
                {
                    //Inserting record to collaboration table without info about userID
                    $stmt = $conn->prepare("INSERT INTO collaboration (name, company, phone_number, type, description) VALUES (:name, :company, :phone_number, :type, :description)");
                }
                $stmt->bindParam(':name', $_GET['name']);
                $stmt->bindParam(':company', $_GET['company']);
                $stmt->bindParam(':phone_number', $_GET['phone_number']);
                $stmt->bindParam(':type', $_GET['type']);
                $stmt->bindParam(':description', $_GET['description']);
                $stmt->execute();

                //Showing apropriate success message
                SuccessMessage("Your collaboration request has been sent successfully.", "index.php");
            }
        }
        catch(PDOException $e) 
        {
            ?>
            <script>window.location.replace("../errors/uncaught.php?errorCode=<?php echo $e->getMessage(); ?>");</script>
            <?php
        }
    ?>

    <section class="photo-slides-baner">
        <div class="slide" style="display: block;">
            <img src="./components/baner1.png" alt="SlidePhoto">
            <div class="slide-info">
                <h1>Unlock the Tunes!</h1>
                <p>
                    Last Minute Gift Cards for Musical Escapes – a perfect choice for a spontaneous rhythm-filled adventure.
                    <br>
                    Check out our music gift card deals now!
                </p>
            </div>
            <button>Explore Offers!</button>
        </div>
        
        <div class="slide">
            <img src="./components/baner2.png" alt="SlidePhoto">
            <div class="slide-info">
                <h1>Gaming Galore!</h1>
                <p>
                    Embark on virtual adventures with our Xbox Gift Cards.
                    We ensure a safe and thrilling gaming experience for all.
                </p>
            </div>
            <button>Explore Offers!</button>
        </div>
        
        <div class="slide">
            <img src="./components/baner3.png" alt="SlidePhoto">
            <div class="slide-info">
                <h1>PlayStation Plus Bliss!</h1>
                <p>
                    Exclusive access and perks await with our PS Plus Gift Cards.
                    Treat yourself to the best of PlayStation gaming. Check out our offers!
                </p>
            </div>
            <button>Explore Offers!</button>
        </div>
    </section>

    <section class="company-history-box">
        <div class="company-history">
            <h2>Information about Gift Card Emporium</h2>

            <div>
                <h4>1. Inception of Dreams (2021):</h4>
                In the year 2021, a group of travel enthusiasts with diverse experiences decided to join forces and
                create a company they named "Gift Card Emporium." It stemmed from their shared dream of providing
                unforgettable adventures for travelers, bringing together diverse cultures and destinations worldwide.
            </div>

            <div>
                <h4>2. Exploration of a Niche Market (2022-2023):</h4>
                In its early years of operation, Gift Card Emporium focused on exploring a niche market, offering unique
                travel routes and extraordinary experiences. They proposed distant destinations, providing customers not
                only with standard trips but also intimate encounters with local cultures.
            </div>

            <div>
                <h4>3. Technological Innovations (2024):</h4>
                Gift Card Emporium recognized the potential of technological innovations in the travel industry. They
                implemented advanced mobile applications, allowing customers to easily browse offerings, make online
                reservations, and track their journeys in real-time. Leveraging artificial intelligence, the company
                tailors offerings to individual customer preferences.
            </div>

            <div>
                <h4>4. Sustainable Development (2025):</h4>
                In response to the growing interest in sustainable travel, Gift Card Emporium introduced ecological
                initiatives. They collaborated with local communities, promoting ecotourism and implementing measures
                aimed at minimizing environmental impact.
            </div>

            <div>
                <h4>5. Global Reputation (2026-present):</h4>
                Through commitment to customer service quality, unique travel routes, technological innovations, and
                sustainable development, Gift Card Emporium gained global renown. It became one of the leading players
                in the travel industry, and its brand became synonymous with unforgettable adventures and professional
                service. Today, the company continues its mission of providing customers with exceptional travel
                experiences worldwide.
            </div>
        </div>
    </section>

    <section class="colab-form-box">
        <form class="colab-form" action='index.php' method='get'>

            <div class="colab-form-header">
                <h2>Interested in Collaboration?</h2>
            </div>

            <div class="colab-form-field">
                <label for="name">Your Full Name: </label>
                <input type="text" id="name" name="name" required maxlength="50" pattern="[A-Za-z\s]+" title="Name can only contain letters and spaces. (Max 50 characters)">
            </div>

            <div class="colab-form-field">
                <label for="organization">Your Company Name: </label>
                <input type="text" id="organization" name="company" required maxlength="50" title="Company name can contain maximum 50 characters.">
            </div>

            <div class="colab-form-field">
                <label for="phone">Your Phone Number: </label>
                <input type="tel" id="phone" name="phone_number" required maxlength="15" pattern="[0-15\s-]+" title="Phone number can contain digits, spaces, and dashes. (Max 15 characters)">
            </div>

            <div class="colab-form-field">
                <label for="collaboration">What type of collaboration are you interested in?</label>
                <select id="collaboration" name="type" required>
                    <option value="consulting">Consultation</option>
                    <option value="research">Research</option>
                    <option value="development">Development</option>
                    <option value="education">Employee Education</option>
                </select>
            </div>

            <div class="colab-form-field">
                <label for="description">Describe your requirements and needs related to collaboration:</label>
                <textarea id="description" name="description" rows="4" cols="50" required maxlength="1000" title="Description can contain maximum 1000 characters."></textarea>
            </div>

            <div class="colab-form-submit">
                <input type="submit" value="Submit">
            </div>

        </form>
    </section>

    <?php
        //Importing footer
        include("../components/footer.php");
    ?>
</body>

</html>
</html>