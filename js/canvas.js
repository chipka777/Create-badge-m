$(document).ready(function () {
    /*
     * Scale
     */
    $('#canvas-scale').on('mousedown', function(e) {
        var top = Math.round($('#canvas-scale').position().top / $('#canvas-scale').parent().height() * 100);

        var p = e.pageY;

       $('#canvas-line').on('mousemove', function(e) {
            h = $('#canvas-scale').parent().height();
            res = e.pageY - p ;
            
            a = res/(h*0.15);
        
            n = top + (15*a);

            q = 15 * Math.floor(n/15) + 4;

            if (q < 80 && q > 3) {
                $('#canvas-scale').css('top', q +"%");
                setRotationDegrees(latest, q);
                
            }
       })
    });
    $('#canvas-scale').on('dragstart', function (event) {
        return false;
    });
    $('html').on('mouseup', function() {
        $('#canvas-line').off('mousemove');
    });

     /*
     * Display canvas
     */

     /*
      * Drag and drop images
      */

     $(".panel img").on("mousedown", function(e){

          var elem = $(this);

          var obj = $(this).parent();
          
          var top_per = Math.round(obj.position().top / obj.parent().height() * 100);
          var left_per = Math.round(obj.position().left / obj.parent().width() * 100);
          
          var left = obj.position().left;
          var top = obj.position().top;

          var y = e.pageY ;
          var x = e.pageX;
          
          

          obj.css({'z-index': 10000, 'transition-duration': '0.1s' });
          
          //$('html').append($(this));

          $('html').on('mousemove', function(e) {
                res_y = (top + e.pageY - y)/obj.parent().height() * 100;
                res_x = (left + e.pageX - x)/obj.parent().width() * 100;
                 
                obj.css({top: res_y + '%', left: res_x + '%'});
                
          });
          
          obj.on('dragstart', function() {
              return false;
          });

          $(document).on('mouseup', function() {
              $('html').off('mousemove');

              var canvas = $(".canvas").offset();
              var canvas_h = $(".canvas").height();
              var canvas_w = $(".canvas").width();

              var img = elem.offset();
              var img_h = elem.height();
              var img_w = elem.width();

              var status = 0;

              if ( (img.top + img_h) > canvas.top    &&
                   img.top < (canvas.top + canvas_h) &&
                   (img.left + img_w) > canvas.left  &&
                   img.left < (canvas.left + canvas_w) ) status = 1;

              if (status) {
  
                  setLast(obj.clone().appendTo(".canvas").addClass('border').children('img').addClass('border-active'));
                  canvasImg();
              }
              obj.css({'transition-duration': '0.5s', top: top_per + '%', left: left_per + '%', 'z-index': 1});

              $(document).off("mouseup");
              
          });
     }); 
});

var latest = false;

function canvasImg(obj) {

    $(".canvas>.border img").on("mousedown", function(e){

        var elem = $(this);

        var obj = $(this).parent();

        var left = obj.position().left;
        var top = obj.position().top;

        var y = e.pageY ;
        var x = e.pageX;

        setLast(elem);
        
        $('html').on('mousemove', function(e) {
            var canvas = $(".canvas").offset();
            var canvas_h = $(".canvas").height();
            var canvas_w = $(".canvas").width();

            var img = elem.offset();
            var img_h = elem.height();
            var img_w = elem.width();
            res_y = top + e.pageY - y;
            res_x = left + e.pageX - x;
            
            if (res_y > 0 && (res_x) > 0 && (res_y + obj.height()) < canvas_h && (res_x + obj.width()) < canvas_w) {
                obj.css({top: res_y + 'px', left: res_x + 'px'});
                console.log("res y = " + res_y + " img_h = " + img_h + " canvas_h = " + canvas_h)
            }
        });
        obj.on('dragstart', function() {
            return false;
        });
        $(document).on('mouseup', function() {
            $('html').off('mousemove');
            $(document).off("mouseup");
        });
    });
}

function setLast(obj) {
    if (latest) latest.removeClass('border-active');

    latest = obj;

    latest.addClass('border-active');

    setRotationDegrees(latest);

}

function getRotationDegrees(obj) {
    var matrix = obj.css("-webkit-transform") ||
    obj.css("-moz-transform")    ||
    obj.css("-ms-transform")     ||
    obj.css("-o-transform")      ||
    obj.css("transform");
    if(matrix !== 'none') {
        var values = matrix.split('(')[1].split(')')[0].split(',');
        var a = values[0];
        var b = values[1];
        var angle = Math.round(Math.atan2(b, a) * (180/Math.PI));
    } else { var angle = 0; }
    return (angle < 0) ? angle + 360 : angle;
}

function setRotationDegrees(obj, rotate = false) {
    if (!rotate) {
        var rotate = getRotationDegrees(obj);
        
        switch(rotate) {
            case 0:
                $("#canvas-scale").css("top", 79 + "%");
                break;
            case 70:
                $("#canvas-scale").css("top", 64 + "%");
                break;
            case 140:
                $("#canvas-scale").css("top", 49 + "%");
                break;
            case 210:
                $("#canvas-scale").css("top", 34 + "%");
                break;
            case 280:
                $("#canvas-scale").css("top", 19 + "%");
                break;
            case 360:
                $("#canvas-scale").css("top", 4 + "%");
                break;
        }
    }else {
        switch(rotate) {
            case 4:
                obj.css("transform", 'rotate(' + 360 +'deg)');
                break;
            case 19:
                obj.css("transform", 'rotate(' + 280 +'deg)');
                break;
            case 34:
                obj.css("transform", 'rotate(' + 210 +'deg)');
                break;
            case 49:
                obj.css("transform", 'rotate(' + 140 +'deg)');
                break;
            case 64:
                obj.css("transform", 'rotate(' + 70 +'deg)');
                break;
            case 79:
                obj.css("transform", 'rotate(' + 0 +'deg)');
                break;
        }
    }

}

