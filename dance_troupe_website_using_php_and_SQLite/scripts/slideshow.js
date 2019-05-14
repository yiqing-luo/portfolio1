$(document).ready(function() {
    var images = [
        "images/cover_1.jpg", //0
        "images/cover_2.jpg", //1
        "images/cover_3.jpg" //2
    ];

    var current_index = 0;
    var next_index =0;
    var last_index=0;

    $("#next_button").click(function () {
        if(current_index!=images.length-1){
            next_index= current_index+1;
            $("#slideshow_img").attr("src", images[next_index]);
            current_index+=1;
        }else{
            next_index=0;
            $("#slideshow_img").attr("src", images[next_index]);
            current_index=0;
        }
    });

    $("#last_button").click(function () {
        if(current_index!=0){
            last_index= current_index-1;
            $("#slideshow_img").attr("src", images[last_index]);
            current_index-=1;
        }else{
            last_index=images.length-1;
            $("#slideshow_img").attr("src", images[last_index]);
            current_index=images.length-1;
        }
    });
  });
