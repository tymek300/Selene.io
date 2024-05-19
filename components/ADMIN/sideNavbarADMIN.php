<style>

/* SIDENAVBAR */

.side-navbar {
    padding: 10px 0 10px 20px;

    position: sticky;
    position: -webkit-sticky;
    top: 0;

    display: flex;
    flex-direction: column;
    gap: 17px;

    width: 20%;
    height: 100vh;

    min-width: 147px;

    -webkit-box-shadow: 12px 0 23px -6px rgba(231, 231, 255, 1);
    -moz-box-shadow: 12px 0 23px -6px rgba(231, 231, 255, 1);
    box-shadow: 12px 0 23px -6px rgba(231, 231, 255, 1);
}

.side-navbar i {
    width: 24px;
}

.side-navbar img {
    width: 60%;

    object-fit: cover;
}

.admin-options {
    display: flex;
    flex-direction: column;

    gap: 10px;
}

.exit-dashboard {
    margin-top: auto;

    color: white;

    background-color: #f03645;

    position: relative;

    margin-right: 10px;

    border-radius: 5px;

    width: calc(100% - 20px);
    height: 45px;

    transition: ease-in-out 200ms;

    font-family: 'Kanit', sans-serif;
    font-weight: bold;

    text-align: center;

    padding: 10px;
}

.exit-dashboard:hover {
    background-color: #d32f3d;
}

.exit-dashboard:active {
    scale: 0.95;
}

.options-title {
    text-transform: uppercase;

    margin: 0;

    color: rgba(0, 0, 0, 0.5);
    font-size: 13px;

    font-family: 'Nunito', 'sans-serif';
}

.options {
    display: flex;
    flex-direction: column;
    gap: 8px;

    font-family: 'Kanit', sans-serif;
    font-weight: bold;
}

.option {
    display: flex;
    justify-content: space-between;
    align-items: center;

    cursor: pointer;
}

.option-link {
    padding: 10px;

    background-color: white;
    color: #84919d;

    margin-right: 4px;

    border-radius: 5px;

    transition: ease-in-out 200ms;

    width: 95%;
}

.option-link:hover {
    opacity: 0.7;
}

.current-site {
    background-color: #e7e7ff;
    color: #696cff;
}

.options i {
    margin-right: 5px;
}

.options label {
    background-color: #696cff;

    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;

    height: 100%;
    width: 6px;
}

@media screen and (max-width: 800px) {

    .side-navbar {
        padding-left: 10px;
    }

}

</style>

<?php
    $navbarSites =[
    ["Users", 'users.php', '<i class="fa-regular fa-users fa-lg"></i>'],
    ["Products", 'products.php', '<i class="fa-regular fa-basket-shopping-simple fa-lg"></i>'],
    ["Orders", 'orders.php', '<i class="fa-regular fa-box fa-lg"></i>'],
    ["Categories", 'categories.php', '<i class="fa-light fa-icons fa-lg"></i>'],
    ["Promo Codes", 'promoCodes.php', '<i class="fa-regular fa-percent fa-lg"></i>']];

    function RenderSideNavbar($currentSite)
    {
        global $navbarSites;
        ?>
            <section class="side-navbar">
                <img src="../photos/logotypes/mainlogo.png" alt="Logotype">

                <div class="admin-options">

                    <p class="options-title">
                        Admin Options
                    </p>

                    <ul class="options">

                    <?php
                            foreach($navbarSites as $index=>$option)
                            {
                                if($index == $currentSite)
                                {
                                ?>
                                    <li  class="option">
                                        <a href="<?php echo $option[1] ?>" class="option-link  current-site">
                                            <?php echo $option[2] ?>
                                            <?php echo $option[0] ?>
                                        </a>
                                        <label></label>
                                    </li>
                                <?php
                                continue;
                                }
                                ?>
                                    <li  class="option">
                                        <a href="<?php echo $option[1] ?>" class="option-link">
                                            <?php echo $option[2] ?>
                                            <?php echo $option[0] ?>
                                        </a>
                                    </li>
                                <?php
                            }
                    ?>

                    </ul>
                </div>

                <a class="exit-dashboard" href="../main/">Exit dashboard</a>

            </section>
        <?php
    }
?>

