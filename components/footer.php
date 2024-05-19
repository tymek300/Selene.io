<!--Footer CSS-->
<style>
/* FOOTER */
.footer-bottom {

    display: flex;

    font-family: 'Kanit', sans-serif;

    width: 100%;

    background-color: #1F2937;
}

.footer-bottom-lists {
    display: flex;
    justify-content: start;

    padding-top: 30px;
    padding-left: 10%;

    gap: 32px;

    width: 70%;
    height: 100%;

    color: #ffffff;
}

.list-box {
    width: 193px;

    height: fit-content;
}

.list-title {
    margin-bottom: 16px;

    font-weight: 700;

    text-transform: uppercase;
}

.footer-list {
    font-size: 14px;

    line-height: 20px;

    color: #999999;
}

.footer-list-element {
    margin-bottom: 8px;

    transition-duration: 300ms;

    cursor: pointer;
}

.footer-bottom-icons {
    width: 100%;
    height: 100%;

    display: flex;
    justify-content: center;
}

.footer-bottom-icons-box {
    display: flex;

    padding: 48px 0 48px 0;

    align-items: center;
}

@media screen and (max-width: 700px) {

    .footer-bottom {
        flex-direction: column;
        align-items: center;
    }

    .footer-bottom-lists {
        padding-left: 0;
        justify-content: center;

        width: 100%;
    }

}

@media screen and (max-width: 655px) {

    .footer-bottom-lists {
        flex-direction: column;
        align-items: center;
    }

}

/* ================================================= */
</style>

<footer class="footer-bottom">
    <div class="footer-bottom-lists">
        <div class="list-box">
            <p class="list-title">Get Help</p>
            <ul class="footer-list">
                <li class="footer-list-element"><a href="../orderStatus/index.php">Order Status</a></li>
                <li class="footer-list-element"><a href="https://www.dhl.com/pl-pl/home.html">Shipping and Delivery</a></li>
                <li class="footer-list-element"><a href="https://www.w3schools.com/jsref/jsref_return.asp">Returns</a></li>
                <li class="footer-list-element"><a href="https://www.meetbunch.com/terms/order-cancellation">Order Cancellation</a></li>
            </ul>
        </div>
        <div class="list-box">
            <p class="list-title">About Selene.io</p>
            <ul class="footer-list">
                <li class="footer-list-element"><a href="https://www.bbc.com/news">News</a></li>
                <li class="footer-list-element"><a href="https://www.yourcareer.gov.au">Careers</a></li>
                <li class="footer-list-element"><a href="https://www.urygus.pl">Investors</a></li>
                <li class="footer-list-element"><a href="https://www.coursera.org/articles/full-stack-developer">Purpose</a></li>
                <li class="footer-list-element"><a href="https://en.wikipedia.org/wiki/Sustainability">Sustainability</a></li>
            </ul>
        </div>
        <div class="list-box">
            <p class="list-title">Promotions & Discounts</p>
            <ul class="footer-list">
                <li class="footer-list-element"><a href="https://www.agh.edu.pl/en/">Student</a></li>
                <li class="footer-list-element"><a href="https://pl.wikipedia.org/wiki/United_States_Navy_SEALs">Military</a></li>
                <li class="footer-list-element"><a href="https://www.facebook.com/ela.nawalaniec">Teacher</a></li>
                <li class="footer-list-element"><a href="https://www.youtube.com/watch?v=c-v-7JRisLA">Birthday</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom-icons">
        <div class="footer-bottom-icons-box">
            <a href="https://www.facebook.com/profile.php?id=100067961432579"><i class="fa-brands fa-facebook fa-xl mr-6" style="color: #ffffff;"></i></a>
            <a href="https://discord.gg/JFbvvK2D"><i class="fa-brands fa-discord fa-xl mr-6" style="color: #ffffff;"></i></a>
            <a href="https://www.instagram.com/kubus_szef1/"><i class="fa-brands fa-instagram fa-xl mr-6" style="color: #ffffff;"></i></a>
            <a href="https://github.com/tymek300/Selene.io"><i class="fa-brands fa-github fa-xl mr-6" style="color: #ffffff;"></i></a>
        </div>
    </div>
    </footer>

    <!--Internal Scripts Import-->
    <script src="./script.js"></script>