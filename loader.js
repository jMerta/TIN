var timeOut;

function sleeper () {
    timeOut = setTimeout(display,500);
}
function display() {
    document.getElementById("loader").style.display = "none";
    document.getElementById("content").style.display = "block";
}