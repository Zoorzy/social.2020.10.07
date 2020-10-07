var postCount = 8;
$ajaxFinished = 1;

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};

var user_id = getUrlParameter("user_id");

var res = {
    loader: $('<div />', { class: 'loader' }),
    container: $('#photogallery')
}

$(window).ready(function() {
    loadPosts()
});


$(window).ready(function() {
    $(window).scroll(function() {
        clearTimeout($.data(this, 'scrollTimer'));
        $.data(this, 'scrollTimer', setTimeout(function() {
            if ($(window).scrollTop() > $(document).height() - $(window).height() - $("#footer").height()) {
                loadPosts();
            }
        }, 250));
    });
});

function loadPosts() {
    if ($("#stopLoad").length == 0) {
        // do something
        if ($ajaxFinished == 1) {
            $ajaxFinished = 0;
            // ajax call get data from server and append to the div
            postCount += 8;

            $.post({
                url: 'includes/loadnewimages.inc.php',
                data: {
                    postNewCount: postCount,
                    user_id: user_id
                },
                beforeSend: function() {
                    res.container.append(res.loader);
                },
                success: function(data) {
                    res.container.html(data);
                    res.container.find(res.loader).remove();
                },
                complete: function() {
                    $ajaxFinished = 1;
                }
            });
        }
    }
}