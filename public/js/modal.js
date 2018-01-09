$(document).ready(function () {
// Get the modal
var modal = $('#myModal')

// Get the button that opens the modal
var btn = $(".myBtn")

// Get the <span> element that closes the modal
var span = $(".close")
var contentName = $('.name')
// When the user clicks on the button, open the modal
var close
    btn.each(function (index) {
        $(this).click(function () {
            $(this).next().css({display: "block"})
        });
    });
    span.each(function (index) {
        $(this).click(function () {
            console.log($(this).parent())
            $(this).parent().parent().css({
                display: "none"
            })
        });
    });
});
