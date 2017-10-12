$(document).ready(function () {

    $('#canvas-scale').on('mousedown', function(e) {
        var top = Math.round($('#canvas-scale').position().top / $('#canvas-scale').parent().height() * 100);
        var t = e.pageY - top;
        var p = e.pageY;
        console.log('e.pageY = ' + e.pageY );

       $('#canvas-line').on('mousemove', function(e) {
            h = $('#canvas-scale').parent().height();
            res = e.pageY - p ;
            
            a = res/(h*0.15);
            
            n = top + (15*a);
            console.log("n = " + n + " res = " + res + " a = " + a + " top = " + top);


            q = 15 * Math.floor(n/15) + 4;
            if (q < 80 && q > 3) $('#canvas-scale').css('top', q +"%");
        
       })
    });
    $('#canvas-scale').on('dragstart', function (event) {
        return false;
    });
    $(document).on('mouseup', function() {
        $('#canvas-line').off('mousemove');
    });
});