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
    setInterval('getCoords();', 3000);
}

function call_server(event, ui) {

    $.post(
        "index.php?r=site/dragbase",
        {
            X: x,
            Y: y,
            ip: user_id
            //name: username

        })

}


function getCoords() {
    $.ajax({
            type: 'POST',
            url: "index.php?r=site/intervalbase",
            data: {
                // conf: true,
                own_id: user_id,
                moving: moving
            },
            success: function (data) {
                //console.log(data);
                coord_array = data;
                var array = JSON.parse(coord_array);
                if(moving == false){
                    for (var i = 0; i < array.length; i++) {
                        if(array[i].user_id== user_id)
                        {
                            document.getElementById("dragable").style.top = array[i].coord_x +"px";
                            document.getElementById("dragable").style.left = array[i].coord_y+"px";

                        }else{
                            if(document.getElementById("square" + array[i].user_id) == null)
                            {
                                $('#sq').append('<div id="square' + array[i].user_id +'"></div>');
                                document.getElementById("square" + array[i].user_id).style.position ="inherit";
                                document.getElementById("square" + array[i].user_id).style.backgroundColor ="black";
                                document.getElementById("square" + array[i].user_id).style.width = 50;
                                document.getElementById("square" + array[i].user_id).style.height = 50;
                            }
                            document.getElementById("square" + array[i].user_id).style.top = array[i].coord_x+"px";
                            document.getElementById("square" + array[i].user_id).style.left = array[i].coord_y+"px";
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