"use strict";

//setInterval is a setTimeout in a loop
var prepareEventHandlers = function() {
    var intervalHd = null;
    var myImage = document.getElementById("mainImage");

    var imageArray = ["images/horses_horsemen_black_night_cloak_68719_1366x768.jpg",
        "images/moon_birds_boats_water_castle_sky_stars_61663_1366x768.jpg",
        "images/uildrim_wild_dreamer_art_drops_95146_1366x768.jpg", "images/girl_dress_fantasy_88609_1366x768.jpg"
    ];

    var imgIndex = 0


    var changeImage = function() {
        // document.querySelector("#mainImage").classList.remove("otherclass");
        myImage.setAttribute("src", imageArray[imgIndex]);
         // document.getElementById("mainImage").className = "fadeInLeft";
        imgIndex++;
        if (imgIndex === imageArray.length) {
            imgIndex = 0;
        };
        myImage.style.marginLeft = "0px";
        setTimeout(function(){
            myImage.style.marginLeft = "100%";
        },4200);
        // myImage.style.marginLeft = "100%";
    }
    
    setInterval(changeImage,5000);    

    // change welcome text on slider

    var welcomeText = document.getElementById("welcome");

    var welcomeTextArray = ["Content Management System", "Lynda CMS Demo!!!!", "Hello Guest, Welcome to Ark Inc!"];
    var welcomeTextIndex = 0;

    var changeText = function() {
        welcomeText.innerHTML = welcomeTextArray[welcomeTextIndex];
        welcomeTextIndex++;
        if (welcomeTextIndex === welcomeTextArray.length) {
            welcomeTextIndex = 0;
        };
    };

    setInterval(changeText, 5000);


};

// wait everything to finish loading before starting the slider
window.onload = function() {
    prepareEventHandlers();
};
