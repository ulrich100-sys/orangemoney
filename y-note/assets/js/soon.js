// Set the date we're counting down to
var countDownDate = new Date("Jan 5, 2019 15:37:25").getTime();

// Update the count down every 1 second
var countdownfunction = setInterval(function () {

    // Get todays date and time
    var now = new Date().getTime();

    // Find the distance between now an the count down date
    var distance = countDownDate - now;

    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    var ul = "<ul class='soon-list'>";
    var ulend = "</ul>";
    var li = "<li>";
    var liend = "</li>";
    // Output the result in an element with id="demo"
    document.getElementById("soon-con").innerHTML = ul + li + days + "<span>days</span>" + liend + li + hours + "<span>hours</span>" +
        liend + li + minutes + "<span>minutes</span>" + liend + li + seconds + "<span>seconds</span>" + liend + ulend;

    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(countdownfunction);
        document.getElementById("soon-con").innerHTML = "EXPIRED";
    }
}, 1000);
