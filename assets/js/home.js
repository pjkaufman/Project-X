$(document).ready(function() {
    var current = location + '';
    if ( current.includes('get_essentials')) {
        window.history.pushState(null,null,current.substring(0,current.lastIndexOf('/')));
    }
    $('a.href').click(function(){
        updateView($(this).text());
    });
});
function updateView( linkName ) {
    var link = { link: linkName };
    clearContent();
    $.ajax({
        type: "POST",
        data: link,
        url: location + '/get_link',
        success: function(resp) {
            getView($.parseJSON(resp), link);
        },
    });
}

function getView( link, linkObj ) {
    $.ajax({
        type: "POST",
        url: link,
        success: function(resp) {
            $('body').append(resp);
            // updates the URL that the user can see
            window.history.pushState(null,null,link);
            getJS(linkObj);
        },
    });
}

function clearContent() {
    $('.content').remove();
}

function getJS( link ) {
    $.ajax({
        type: "POST",
        data: link,
        url: location + '/get_js',
        success: function(resp) {
            var linkJS = $.parseJSON(resp);
            if( linkJS != null ){
                $.getScript(linkJS);
                console.log(linkJS);
            }
        },
    });
}
