$(document).ready(init);

var x, y;
var coord_array = [];
var moving;

function init() {
    $( "#dragable" ).draggable({
        containment: "parent",
        drag: function(event, ui) {
            x = ui.position.top;
            y = ui.position.left;
        },
        start: function(event, ui) {
            moving = true;
        },
        stop: function(event, ui) {
            moving = false;
        }
    });
    //$('#navForHistory a:last').tab('show');

    $("#sq").mouseup(sendOwnCoordsAfterDrag);

    setInterval(getCoords, 3000);
}

function sendOwnCoordsAfterDrag(event, ui) {

    $.post(
        "index.php?r=site/dragbase",
        {
            X: x,
            Y: y,
            own_id: user_id

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
                            var ownSquare = document.getElementById("dragable");
                            ownSquare.style.top = arraySquares[i].coord_x +"px";
                            ownSquare.style.left = arraySquares[i].coord_y+"px";

                        }else{
                            var userSquare = document.getElementById("square" + arraySquares[i].user_id);
                            if(userSquare == null)
                            {
                                $('#sq').append('<div id="square' + arraySquares[i].user_id +'"></div>');
                                userSquare.style.position ="inherit";
                                userSquare.style.backgroundColor ="black";
                                userSquare.style.width = 50;
                                userSquare.style.height = 50;
                            }
                            userSquare.style.top = arraySquares[i].coord_x+"px";
                            userSquare.style.left = arraySquares[i].coord_y+"px";
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