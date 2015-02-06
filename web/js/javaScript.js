$(document).ready(init);

var x, y;
var coord_array = [];
var moving;

function init() {
    $("#dragable").draggable(
        {
            containment: "parent",
            drag: function (event, ui) {
                x = ui.position.top;
                y = ui.position.left;
            },
            start: function(event, ui)
            {
                moving = true;
            },
            stop: function(event, ui)
            {
                moving = false;
            }

        }

    )

    $(document).mouseup(call_server);
    //setInterval('getCoords();', 3000);
}

function call_server(event, ui) {

    $.post(
        "index.php?r=site/base",
        {
            X: x,
            Y: y,
            ip: user_id
            //name: username

        })

}

/*
function getCoords() {
    $.ajax({
            type: 'POST',
            url: "index.php",
            data: {conf: true,
                conf_ip: id,
                moving: moving
            },
            success: function (data) {
                //console.log(data);
                coord_array = data;
                var array = JSON.parse(coord_array);

                console.log(array);
                //console.log(data.length)
                var y=0;
                for (var i = 0; i < array.length; i++) {
                    if(array[i].Name=="Mine")
                    {
                        document.getElementById("draggble").style.top = array[i].X;
                        document.getElementById("draggble").style.left = array[i].Y;
                    }else{
                        if(document.getElementById("square" + y) == null)
                        {
                            $('#sq').append('<div id="square' + y +'"></div>');
                            document.getElementById("square" + y).style.position ="inherit";
                            document.getElementById("square" + y).style.backgroundColor ="black";
                            document.getElementById("square" + y).style.width = 50;
                            document.getElementById("square" + y).style.height = 50;
                        }
                        document.getElementById("square" + y).style.top = array[i].X;
                        document.getElementById("square" + y).style.left = array[i].Y;
                        y++;
                    }
                }


            },
            datatype: 'JSON',
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        }
    )

}*/
