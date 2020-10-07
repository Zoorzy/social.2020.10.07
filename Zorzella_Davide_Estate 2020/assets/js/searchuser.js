$ajaxFinishedUer = 1;

var result = {
    container: $('#searchresult')
}

$(window).ready(function() {
    $("#searchuser").on("keydown", function() {
        if ($(this).val() != null) {
            search();
            return;
        }
    })
});


function search() {
    var input = $("#searchuser").val();
    if ($ajaxFinishedUer == 1) {
        $ajaxFinishedUer = 0;

        $.post({
            url: 'includes/searchuser.inc.php',
            data: {
                user: input
            },
            success: function(data) {
                result.container.html(data);
            },
            complete: function() {
                $ajaxFinishedUer = 1;
            }
        });
    }
}