<!--Header CSS-->
<style>
/* FONTS-IMPORT */
@import url('https://fonts.googleapis.com/css2?family=Kanit:wght@200&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Barlow:wght@300&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Dosis:wght@300&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Arimo&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@600&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Josefin+Sans&display=swap');

/* ================================================= */

/* HEADER */

.navigation-header {
    display: flex;
    justify-content: space-between;
    align-items: center;

    padding: 0 1.5% 0 1.5%;
    margin: 1.5vh 0 3vh 0;

    width: 100%;
    height: fit-content;

    font-family: 'Kanit', sans-serif;
}

.navigation-header-logotype {
    width: 225px;
}

#Mobile-Nav-Icon {
    display: none;
}

.navigation-header-logotype img {
    width: 175px;
    height: 75px;
}

.navigation-header-links {
    width: 100%;

    display: flex;

    transition: 300ms ease-in-out;

    gap: 17px;

    justify-content: space-between;
}

.navigation-header-subpages {
    display: flex;

    gap: 10px;
}

.navigation-header-subpages a {
    font-size: 22px;
    
    font-weight: bold;

    margin-right: 17px;

    transition: 300ms ease-in-out;
}

.navigation-header-subpages a:hover {
    letter-spacing: 0.1em;
}

.navigation-header-user {
    display: flex;

    gap: 20px;
}

.userIcon {
    display: flex;
    align-items: center;
    transition-duration: 300ms;

    gap: 10px;

    cursor: pointer;
}

.userIcon p{
    font-size: 18px;
    font-weight: bold;
}

.userIcon img {
    border-radius: 9999px;

    width: 48px;
    height: 48px;

    transition-duration: 300ms;
}

.userIcon:hover {
    color: #4212cc;
}

@media screen and (max-width: 650px) {

    .navigation-header {
        flex-direction: column;
    }

    #Mobile-Nav-Icon {
        display: block;

        cursor: pointer;
    }

    .navigation-header-logotype {
        width: 100%;

        display: flex;

        justify-content: space-between;

        align-items: center;
    }

    .navigation-header-links {
        flex-direction: column;
        align-items: center;
        justify-content: start;

        height: 0;

        overflow: hidden;
    }

    .navigation-header-links span {
        display: none;
    }

    .navigation-header-subpages {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

}
</style>

<?php
    //Importing cart overlay container
    include("CART/cartOverlay.php");
?>

<header class="navigation-header">
    <div class="navigation-header-logotype">
        <a href="../main/"><img src="../photos/logotypes/mainlogo.png" alt="Logotype"></a>
        <i class="fa-regular fa-bars fa-xl" id="Mobile-Nav-Icon" onclick="Nav_Reveal()"></i>
    </div>

    <div class="navigation-header-links">
        <span></span>

        <nav class="navigation-header-subpages">
            <a href="../main/">Home</a>
            <a href="../about_Shop/">About</a>
            <a href="../contact/">Contact</a>
        </nav>

    <?php
    if(isset($_SESSION['userID']))
    {
        ?>
        <nav class="navigation-header-user">
            <a href="../userProfile/" class="userIcon">
                <p>
                    <?php 
                    echo $_SESSION['nickname'];
                    ?>
                </p>
                <img src="<?php echo $_SESSION['profilePicture']; ?>" alt="ProfilePicture">
            </a>
            <a class="userIcon cart-icon-header">
                <span></span>
                <i class="fa-regular fa-cart-shopping fa-xl"></i>
            </a>
            <a class="userIcon" href="../components/logout.php">
                <span></span>
                <i class="fa-regular fa-right-from-bracket fa-xl"></i>
            </a> 
        </nav>
        <?php
    }
    else
    {
        ?>
        <nav class="navigation-header-user">
            <a href="../loginForm/" class="userIcon">
                <p>Login</p>
                <i class="fa-light fa-user fa-xl"></i>
            </a>
            <a href="../loginForm/" class="userIcon">
                <p>Register</p>
                <i class="fa-light fa-user-plus fa-xl"></i>
            </a>
        </nav>
        <?php
    }
        ?>
    </div>
</header>

<!--Header Script-->
<script>
//UserIconClassChange
{
    let UserIcons = document.querySelectorAll(".userIcon");

    UserIcons.forEach(element => {
        element.addEventListener('mouseenter', function () {
            element.children[1].classList.add("fa-bounce");
        })

        element.addEventListener('mouseleave', function () {
            element.children[1].classList.remove("fa-bounce");
        })
    });
}

//MobileNavBar
{
    let navbar = document.querySelector(".navigation-header-links");

    window.addEventListener("resize", function(){
        if (window.matchMedia("(max-width: 650px)").matches) {
            navbar.style.height = "0px";
        } else {
            navbar.style.height = "auto";
        }
    });

    function Nav_Reveal()
    {
        let computedHeight = window.getComputedStyle(navbar).getPropertyValue('height');

        if (computedHeight === "0px") {
            navbar.style.height = "200px";
        } else {
            navbar.style.height = "0px";
        }
    }
}
//CartShowing
{
    let bodyOverlayContainer = document.querySelector(".body-overlay-container");
    let cart = document.querySelector(".cart-container");
    let revealButton = document.querySelector(".cart-icon-header");

    revealButton.addEventListener("click", function () {
        bodyOverlayContainer.style.display = "flex";
    })
}
</script>