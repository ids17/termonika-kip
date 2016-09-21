$(document).ready(function() {
    $('a').click(function() {
        var url = $(this).attr('href');
        //alert(url);
        //alert(url + 'ajax=1');
        $.ajax({
            url:     url + '&ajax=1',
            success: function(data){
                $('#content').html(data);
                alert(url);
            }
        });

        //alert('bad');

        if(url != window.location){
            window.history.pushState(null, null, url);
            if (url != 'catalog.php') {
                //alert(url);
                $('#footer').css('display','none');
                if (url === 'about.php') {

                }
            }else{
                $('#footer').css('display','block');
            }
        }

        return false;
    });

    $(window).bind('popstate', function() {
        $.ajax({
            url:     location.pathname + 'ajax=1',
            success: function(data) {
                $('#content').html(data);
            }
        });
    });
});