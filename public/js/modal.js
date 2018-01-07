// Get the modal
var modal = document.getElementById('myModal')

// Get the button that opens the modal
var btn = document.getElementsByClassName("myBtn")

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0]
var contentName = document.getElementsByClassName('name')
// When the user clicks on the button, open the modal
var close
for (var i = 0; i < btn.length; i++) {
    var anchor = btn[i]
    anchor.onclick = function () {
        this.nextElementSibling.style.display = "block"
        var content = this.previousElementSibling.previousElementSibling.innerHTML
        contentName.innerHTML = content

    }
}
// When the user clicks on <span> (x), close the modal
span.onclick = function () {
    modal.style.display = "none"
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
        modal.style.display = "none"
}
