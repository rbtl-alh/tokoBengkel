document.onreadystatechange = function() {
    if (document.readyState !== "complete") {
        document.querySelector("body").style.visibility = "hidden";
        document.querySelector("#loader").style.visibility = "visible";
    } else {
        document.querySelector("#loader").style.display = "none";
        document.querySelector("body").style.visibility = "visible";
    }
};

var countDownDate = new Date("Oct 15, 2020 07:00:00").getTime();

var x = setInterval(function() {

    var now = new Date().getTime();
    var distance = countDownDate - now;

    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // document.getElementById("demo").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
    document.getElementById("demo").innerHTML = "<div class='days-box text-center'><h4>"+ days +"</h4>Days</div><div class='hours-box text-center'><h4>"+ hours +"</h4>Hour</div><div class='min-box text-center'><h4>"+ minutes +"</h4>Min</div><div class='sec-box text-center'><h4>"+ seconds +"</h4>Sec</div>";

    if (distance < 0) {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "DONE !!!";
    }
}, 1000);