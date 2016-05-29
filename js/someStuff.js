$(document).ready(function () {
    $(".alert").delay(4000).slideUp(200, function() {
        $(this).alert('close');
    });

    $(".custom-item").bind({
            mouseenter: function (e) {
                $(this).children("span").removeClass('glyphicon-music');
                $(this).children("span").addClass('glyphicon-play');
            },
            mouseleave: function (e) {
                $(this).children("span").removeClass('glyphicon-play');
                $(this).children("span").addClass('glyphicon-music');
            },
            click: function (e) {

                if($(this).is($(".active"))) {
                    console.log("yeeee");
                    $('#jquery_jplayer_1').jPlayer("stop");
                    $(".active").children("span").toggleClass("glyphicon-stop");
                    $(".active").removeClass("active");
                    return true;
                }

                $(".active").children("span").toggleClass("glyphicon-stop");
                $(".active").removeClass("active");






                $(this).children("span").toggleClass('glyphicon-stop');
                $(this).toggleClass("active");

                var mediaURL="getFile.php?id="+$(this).find(".hidden").text();
                $('#jquery_jplayer_1').jPlayer('setMedia', {
                    mp3: mediaURL,
                });

                $('#jquery_jplayer_1').jPlayer("play");


            }
        }
    );

    $(".custom-item").click(function (e) {
        e.preventDefault();
    })



    $("#jquery_jplayer_1").jPlayer({
        ready: function (event) {

        },
        ended: function() {
            $(".active").children("span").toggleClass("glyphicon-stop");
            $(".active").removeClass("active");
        },
        supplied: "mp3",
        wmode: "window",
        useStateClassSkin: true,
        autoBlur: false,
        smoothPlayBar: true,
        keyEnabled: true,
        remainingDuration: true,
        toggleDuration: true
    });
});