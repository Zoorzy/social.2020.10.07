// Zoom every single photo in the photo gallery
var fullGallery = document.getElementById("fullGallery");
var fullImg = document.getElementById("fullImg");
var fullImgLink = document.getElementById("fullImgLink");
var fullText = document.getElementById("fullText");

$(".responsive").click(function() {

    //modal.style.display = "block";
    var img = $('img', this);
    $("#fullGallery").show();
    fullImg.src = img.attr('src');
    fullText.innerHTML = img.attr('alt') + "<br><h4>Clicca sullo schermo per andare al post</h4>";
    fullImgLink.href = "post.php?post_id=" + img.data('post_id');

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        fullGallery.style.display = "none";
    }
});