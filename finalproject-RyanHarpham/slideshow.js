$(document).ready(function () {
    var slider = $("#image_list");                     // slider = ul element
    var leftProperty, newleftProperty;

    // the click event handler for the right button						
    $("#right_button").click(function () {
        // get value of current left property
        leftProperty = parseInt(slider.css("left"));
        // determine new value of left property
        if (leftProperty - 300 <= -900) {
            newLeftProperty = 0;
        } else {
            newLeftProperty = leftProperty - 300;
        }
        // use the animate function to change the left property
        slider.animate({left: newLeftProperty}, 1000);
    });  // end click

    // the click event handler for the left button
    $("#left_button").click(function () {
        // get value of current right property
        leftProperty = parseInt(slider.css("left"));

        // determine new value of left property
        if (leftProperty < 0) {
            newLeftProperty = leftProperty + 300;
        } else {
            newLeftProperty = 0;
        }

        // use the animate function to change the left property
        slider.animate({left: newLeftProperty}, 1000);
    });  // end click	

    // preload images
    $("#image_list a").each(function () {
        var swappedImage = new Image();
        swappedImage.src = $(this).attr("href");
    });

    $("#image_list a").click(function (evt) {
        document.getElementById("slideshowTitle").innerHTML = "<?php echo htmlspecialchars($topFiveProducts['product']['Name']); ?>"
        var imageURL = $(this).attr("href");

        $("#slideshowImage").animate({opacity: 0, left: "-=205"}, 1000, function () {
            $("#slideshowImage").attr("src", imageURL).animate({opacity: 1, left: "+=205"}, 1000)
        });

        evt.preventDefault();
    })

}); // end ready