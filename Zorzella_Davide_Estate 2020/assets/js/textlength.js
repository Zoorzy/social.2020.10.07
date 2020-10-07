// Reduce text length
$(document).ready(function() {
    $('.text').each(function() {
        var str = $(this).text();
        $(this).text(str);
    });
})