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
    $('#navForHistory a:last').tab('show');

    $(document).mouseup(call_server);
    setInterval(getCoords, 3000);
}

function call_server(event, ui) {

    $.post(
        "index.php?r=site/dragbase",
        {
            X: x,
            Y: y,
            ip: user_id

        })

}


function getCoords() {
    $.ajax({
            type: 'POST',
            url: "index.php?r=site/intervalbase",
            data: {
                own_id: user_id,
                moving: moving
            },
            success: function (data) {
                var arraySquares = JSON.parse(data);
                if(moving == false){
                    for (var i = 0; i < arraySquares.length; i++) {
                        if(arraySquares[i].user_id== user_id)
                        {
                            document.getElementById("dragable").style.top = arraySquares[i].coord_x +"px";
                            document.getElementById("dragable").style.left = arraySquares[i].coord_y+"px";

                        }else{
                            if(document.getElementById("square" + arraySquares[i].user_id) == null)
                            {
                                $('#sq').append('<div id="square' + arraySquares[i].user_id +'"></div>');
                                document.getElementById("square" + arraySquares[i].user_id).style.position ="inherit";
                                document.getElementById("square" + arraySquares[i].user_id).style.backgroundColor ="black";
                                document.getElementById("square" + arraySquares[i].user_id).style.width = 50;
                                document.getElementById("square" + arraySquares[i].user_id).style.height = 50;
                            }
                            document.getElementById("square" + arraySquares[i].user_id).style.top = arraySquares[i].coord_x+"px";
                            document.getElementById("square" + arraySquares[i].user_id).style.left = arraySquares[i].coord_y+"px";
                        }
                    }
                }


            },
            datatype: 'JSON',
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        }
    )

}