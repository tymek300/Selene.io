<style>
/* SOMEBANNER */
.baner {
    height: 200px;

    padding: 0 50px 0 20px;

    display: flex;
    justify-content: space-between;

    font-family: 'Nunito', sans-serif;

    -webkit-box-shadow: 0 0 23px 10px rgba(231, 231, 255, 1);
    -moz-box-shadow: 0 0 23px 10px rgba(231, 231, 255, 1);
    box-shadow: 0 0 23px 10px rgba(231, 231, 255, 1);

    overflow: hidden;
}

.baner-text {
    width: 500px;

    padding: 20px 0 20px 0;

    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.baner-text h2 {
    color: #696cff;

    font-size: 30px;
}

.baner-text p {
    color: #84919d;
    font-size: 20px;
}

.baner-photo {
    height: 100%;

    display: flex;
    align-items: end;
}

.baner-photo img {
    height: 95%;
}

@media screen and (max-width: 1000px) {

    .baner {
        height: fit-content;
        flex-direction: column;
        align-items: center;

        padding: 0;
    }

    .baner-text {
        text-align: center;
    }

}

@media screen and (max-width: 750px) {

    .baner-text h2 {
        font-size: 24px;
    }

    .baner-text p {
        color: #84919d;
        font-size: 16px;
    }

    .baner-text {
        padding: 20px 10px 20px 10px;
        width: auto;
    }
}
</style>

<section class="baner">

    <div class="baner-text">
        <h2>
            Hello dear admin <?php echo $_SESSION['nickname'] ?> 🥳!
        </h2>
        <p>
            Welcome to our new admin dashboard!<br> We hope you will fall in love with it ❤️.<br> It cost our team a lot of work.
        </p>
    </div>

    <div class="baner-photo">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQlIOyX1IXZQmvqc3IYtX-VMPJOwRigcgkxVHnFpr_m5x5o8c4s" alt="BanerImage">
    </div>

</section>