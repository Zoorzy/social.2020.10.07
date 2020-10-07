/* upload img ( profile / post ) */
function selectimg(idForm) {
    var img = document.getElementById(idForm + "_file");
    img.click();
    submitimg(img, idForm);
}

function submitimg(idImg, idForm) {
    $(idImg).change(function(e) {
        if (idImg.value == "") {
            setTimeout(submitimg, 3000);
        } else {
            document.getElementById(idForm).submit();
        }
    });
}