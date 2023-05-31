
function buttonInputField() {
    var muutos = prompt("Syötä haluamasi otsikko: ")
    var otsikko = document.getElementById("title")
    otsikko.innerText = muutos
}