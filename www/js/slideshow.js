const SLIDESHOWDELAYMS = 3500;

//Defined in slideshow.php: const slideshowFnames

let slideshowIndex = 1;
let slideshowInterval;

let ssi1 = document.getElementById("slideshowImage1");
let ssi2 = document.getElementById("slideshowImage2");


function stepSlideshow(imgs) {
    //Swap image elements
    let tmp = ssi1;
    ssi1 = ssi2;
    ssi2 = tmp;
    //Swap visibility
    ssi2.classList.remove("slideshowactive");
    ssi1.classList.add("slideshowactive");
    setTimeout(()=>{
        //Change source to next picture after it is faded out
        slideshowIndex = (slideshowIndex + 1) % imgs.length; 
        ssi2.src = slideshowFnames[slideshowIndex];
    }, 1000);
}

//Initialize slideshow, start interval
if (slideshowFnames.length > 1) {
    slideshowInterval = setInterval(()=>{
        stepSlideshow(slideshowFnames);
    }, SLIDESHOWDELAYMS);
}
