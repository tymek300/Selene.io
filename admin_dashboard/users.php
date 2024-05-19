<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        //Importing header tags
        include("../components/headerparams.php");

        //Checking if user is logged in, and if is admin
        if(!isset($_SESSION['userID']) || $_SESSION['admin'] == 0)
        {
            FailureMessage("You have no permissions to see this page.", "../main/");
            echo '<title>No permissions</title>';
            die;
        }
    ?>
    <title>Welcome <?php echo $_SESSION['nickname']?>!</title>
</head>
<body>
    <section class="content">

        <!-- PROFILE MODYFYING -->
        <div class="body-overlay user-modify-form-box">
            <div class="dialog-box">

            <div class="icon">
                    <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
            </div>

            <div class="message">
                You can change user parameters below.
            </div>

            <form action="../components/ADMIN/Users/userModifyAddADMIN.php" method="post" class="userModifyForm">
                <legend>Set new parameters:</legend>
                <input type="text" class="idInput" name="userID" hidden required>

                <input type="text" class="typeInput" name="type" value="modify" hidden required>

                <input type="text" class="formTextInput" name="hiddenNick" hidden required>
                <input type="text" class="formTextInput" name="hiddenMail" hidden required>

                <label>
                    <span>Nickname: </span>
                    <input type="text" class="formTextInput" name="nickname" required>
                </label>

                <label>
                    <span>Mail: </span>
                    <input type="text" class="formTextInput" name="mail" required>
                </label>

                <label>
                    <span>
                        Admin:
                    </span>
                    <fieldset>
                        Yes <input type="radio" name="admin" value="1" required> &nbsp;
                        No <input type="radio"  name="admin" value="0" required>
                    </fieldset>
                </label>

                <div>
                    <button class="close-btn" style="background-color: #32de84">Submit</button> &nbsp;
                    <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('users.php')">Close</button>
                </div>
            </form>
            </div>
        </div>

        <!-- PROFILE ADDING -->
        <div class="body-overlay user-add-form-box">
            <div class="dialog-box">

                <div class="icon">
                        <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
                </div>

                <div class="message">
                    You can set user parameters below.
                </div>

                <form action="../components/ADMIN/Users/userModifyAddADMIN.php" method="post" class="userAddForm">
                    <legend>Set parameters:</legend>

                    <input type="text" class="typeInput" name="type" value="add" hidden required>

                    <label>
                        <span>Nickname: </span>
                        <input type="text" class="formTextInput" name="nickname" required>
                    </label>

                    <label>
                        <span>Mail: </span>
                        <input type="text" class="formTextInput" name="mail" required>
                    </label>

                    <label>
                        <span>Password:</span> 
                        <input type="password" class="formTextInput" name="password" required>
                    </label>

                    <label>
                        <span>
                            Admin:
                        </span>
                        <fieldset>
                            Yes <input type="radio" class="formTextInput" name="admin" value="1" required> &nbsp;
                            No <input type="radio" class="formTextInput" name="admin" value="0" required>
                        </fieldset>
                    </label>

                    <div>
                        <button class="close-btn" style="background-color: #32de84">Submit</button> &nbsp;
                        <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('users.php')">Close</button>
                    </div>
                    
                </form>
            </div>
        </div>

        <!-- PROFILE DELETING -->
        <div class="body-overlay delete-user-form-box">
            <div class="dialog-box">

            <div class="icon">
                    <i class="fa-solid fa-seal-question" style="color: #8240d4;"></i>
            </div>

            <div class="message">
                Are you sure you want to delete this profile?
                <br>
                <b>Warning: </b> You will not be able to recover it after that.
            </div>

            <form action="../components/profileDelete.php" method="post" class="deleteUserForm">
                <input type="text" class="idInput" name="userID" hidden required>
                <input type="text" name="admin" value="TRUE" hidden required>
                <div>
                    <button class="close-btn" style="background-color: #E32636">Submit</button> &nbsp;
                    <button class="close-btn" type="button" style="background-color: #654ab8" onclick="closeDialog('users.php')">Close</button>
                </div>
            </form>
            </div>
        </div>

        <?php
            //Importing baner
            include("../components/ADMIN/sideNavbarADMIN.php");
            RenderSideNavbar(0);
        ?>

        <section class="main">

            <?php
                //Importing baner
                include("../components/ADMIN/banerADMIN.php")
            ?>

            <div class="filter-bar">

                <form class="filter-form" method="get">

                    <div class="form-inputs">
                        <div class="input-box">
                            <label for="since">Start Date (joining): </label>
                            <input type="date" name="since">
                        </div>
                        <div class="input-box">
                            <label for="until">End Date (joining): </label>
                            <input type="date" name="until">
                        </div>
                        <div class="input-box">
                            <label for="nickname">Nickname: </label>
                            <input type="text" name="nickname">
                        </div>
                    </div>
                    
                    <div class="filter-actions">
                        <button>
                            Filter Users
                        </button>
                        <a onclick="AddUser()" style="background-color: #32de84"> 
                            Add user
                        </a>
                    </div>
                
                </form>
            </div>

            <?php

                //Creating varabiable to hold possible conditions
                $condition = "";

                //If user marks start of the range of join date
                if(isset($_GET['since']))
                {
                    if(!empty($_GET['since'])) 
                    {
                        $condition .= "AND join_date >= '{$_GET['since']}'";
                    }
                }
                
                //If user marks end of the range of join date
                if(isset($_GET['until']))
                {
                    if(!empty($_GET['until'])) 
                    {
                        $condition .= " AND join_date <= '{$_GET['until']}'";
                    }
                }
                
                //If user marks desirable nickname 
                if(isset($_GET['nickname']))
                {
                    if(!empty($_GET['nickname'])) 
                    {
                        $condition .= " AND nickname LIKE '%{$_GET['nickname']}%'";
                    }
                }
                

                //Fetching for users with certain parameters
                $stmt = $conn->prepare("SELECT * FROM user WHERE 1 $condition");
                $stmt->execute();
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach($users as $user)
                {
                    ?>
                        <section class="user-bar">
                            <div class="user-informations">
                                <div class="profile-picture">
                                    <img src="<?php echo $user['profile_picture'] ?>" alt="Profile Picture">
                                </div>
                                <hr>
                                <div class="profile-nickname">
                                    <?php echo $user['nickname'] ?>
                                </div>
                                <hr>
                                <div class="profile-mail">
                                    <?php echo $user['mail'] ?>
                                </div>
                                <hr>
                                <div class="profile-join-date">
                                    <?php echo $user['join_date'] ?>
                                </div>
                                <hr>
                                <div class="profile-verification-status">
                                    <?php
                                        if($user['verified'] == 0)
                                        {
                                            echo 'Not verified';
                                        }
                                        else
                                        {
                                            echo 'Verified';
                                        }
                                    ?>
                                </div>
                                <hr>
                                <div class="profile-admin-status">
                                    <?php
                                        if($user['admin'] == 0)
                                        {
                                            echo 'No admin privileges';
                                        }
                                        else
                                        {
                                            echo 'Admin';
                                        }
                                    ?>
                                </div>
                            </div>
                            <div class="user-actions">
                                <a onclick="ModifyUser(<?php echo $user['user_id']. ', \''. $user['nickname']. '\''. ', \''. $user['mail']. '\''. ', '. $user['admin'] ?>)">
                                    Modify user
                                </a>
                                <a onclick="DeleteUser(<?php echo $user['user_id']?>)" style="background-color: #fd5c63;">
                                    Delete user
                                </a>
                            </div>
                        </section>
                    <?php
                }

            ?>

        </section>
    </section>
    <!--Internal Scripts Import-->
    <script src="./script.js"></script>
</body>
</html>