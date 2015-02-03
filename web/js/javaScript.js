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

   /* $(document).mouseup(call_server);
    setInterval('getCoords();', 3000);*/


}