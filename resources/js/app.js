require('./bootstrap');
import { createApp } from 'vue'
import subscription from './components/subscription.vue'

createApp({
    components: {
        subscription
    }
}).mount('#app');

$(document).ready(function() {
    //Navigation
    $(".menu-toggle").click(function() {
        $("nav").toggleClass("active");
    });

    // Hamburger icon animation
    $(".menu-toggle").on("click", function() {
        $(".hamburger-menu").toggleClass("animate");
    });

    //Fullscreen search menu
    $("#search").click(function() {
        $(".search-overlay").css("display", "block");
    });
    $(".close-search").click(function() {
        $(".search-overlay").css("display", "none");
    });

});

//Sticky Navigation
$(window).scroll(function(event) {
    if ($(this).scrollTop() > 300) {
        $("header").addClass("fixed");
    } else {
        $("header").removeClass("fixed");
    }
});
