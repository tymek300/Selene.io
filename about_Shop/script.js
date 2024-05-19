//SlideShow
{
    let Slides = document.getElementsByClassName("slide");
    let SlideNum = 0;

    Slides[SlideNum].style.display = "block";


    setInterval(function()
    {
        Slides[SlideNum].style.display = "none";

        SlideNum++;

        SlideNum = SlideNum%Slides.length;

        Slides[SlideNum].style.display = "block";

    }, 5000)
}