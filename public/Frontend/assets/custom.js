let prevScrollPos = window.pageYOffset;
let scroller = 0;

document.getElementById("bod").onscroll = function myFunction() {
    let currentScrollPos = window.pageYOffset;
    
    if (prevScrollPos > currentScrollPos) {
        // user has scrolled up
        if (scroller != 0) {
            scroller = 0;
            $("#head-nav").removeClass("nav-hide");
            $("#head-nav").addClass("nav-show");
        }
    } else {
        if (scroller != 1) {
            scroller = 1;
            // user has scrolled down
            $("#head-nav").removeClass("nav-show");
            $("#head-nav").addClass("nav-hide");
        }
    }

    // update previous scroll position
    prevScrollPos = currentScrollPos;

    let scrolltotop = document.scrollingElement.scrollTop;
            let target = document.getElementById("main1");
            let xvalue = "center";
            let factor = 0.8;
            let yvalue = scrolltotop * factor;
            target.style.backgroundPosition = xvalue + " " + yvalue + "px";
        
};

function displayBtn(bid) {
    $('#b-' + bid).show();
    $('#p-' + bid).hide();
}
function hideBtn(bid) {
    $('#b-' + bid).hide();
    $('#p-' + bid).show();
}       