// Tässä on neliöiden määrä, niiden ominaisuudet ja pistemäärä 
const squaresContainer = document.querySelector('#squares')
const numberOfsquares = 16
let i = 0;
let square1, square2;
let clickCount = 0;
let score = 0

// Tämä queryselector valitsee html tiedostosta pistemäärän jolla on oma id
document.querySelector("#score").style.visibility = "hidden"; 
// Tämä luo "pelaa uudestaan" napin ja valitsee samalla html tiedostosta napin
const playAgainBtn = document.querySelector('button')

playAgainBtn.style.visibility = "hidden"
playAgainBtn.addEventListener('click', playAgain)

// Tässä on pelin värit
let colors = [
    "#33ff33",
    "#33ff33",  
    "#ff944d",
    "#ff944d",
    "#80ccff",
    "#80ccff",
    "#ffff66",
    "#ffff66",
    "#ff4dff",
    "#ff4dff",
    "#ff1a1a",
    "#ff1a1a",
    "#dddddd",
    "#dddddd",
    "#000099",
    "#000099",
]

// Tämä funktio sijoittelee muistipelin värit satunnaisesti
function selectColor() {

    // 0-15
    const random = Math.floor(Math.random() * colors.length);
    const selected = colors[random]
    colors.splice(random, 1)
    return selected;
}

// Tämä on looppi joka toteutuu niin monta kertaa kunnes kaikki värit ovat laitettu
while(i < numberOfsquares) {
    const square = document.createElement('li')
    const color = selectColor();
    // nelio.style.background = kuva;
    square.setAttribute("data-color", color)
    squaresContainer.appendChild(square);
    i++;
}

// Tämä luo neliöille "list itemit" johon sisällytetään värit toisessa funktiossa
const squares = document.querySelectorAll('li');
for(const square of squares) {
    square.addEventListener('click', squareClicked);

}

// Tämä funktio toteutuu kun neliötä klikataan ja sitten muuttaa sen värin joka on valittu edellisessä funktiossa
function squareClicked() {
    if(square1 == this) return;
    clickCount++;
    if(clickCount > 2) return;
    clickCount === 1 ? (square1 = this) : (square2 = this);
    if(clickCount === 1) {
        square1.style.backgroundColor = square1.getAttribute('data-color');
        // console.log("moi")
    } else {
        square2.style.backgroundColor = square2.getAttribute('data-color');
        checkMatch()
    }
}

// Tässä funktiossa annetaan data "list itemille" ja katsoo onko peli loppunut 
function checkMatch() {
    let match =
    square1.getAttribute('data-color') === square2.getAttribute('data-color');
    if(!match) {
        square1.classList.add("shake");
        square2.classList.add("shake");
        setTimeout(function() {
            noMatch();
        }, 500);
    } else {
        isMatch();
        checkGameEnded();
    }
}

// Tämä funktio toteutuu kun kun värit eivät täsmää muistipelissä ja poistaa värit siitä
function noMatch() {
    square1.style.background = "";
    square2.style.background = "";
    square1.classList.remove("shake");
    square2.classList.remove("shake");
    square1 = "";
    square2 = "";
    clickCount = 0
    console.log("ei täsmää")
}

// Tämä funktio on päin vastainen ja säilyttää värin kun värit vastaavat toisiaan
function isMatch() {
    score++;
    document.querySelector("#score").innerText = score;
    document.querySelector("#score").style.visibility = "visible";
    square1.classList.add("pop");
    square2.classList.add("pop");
    square1.style.border = "none";
    square2.style.border = "none";
    square1.removeEventListener("click", squareClicked);
    square2.removeEventListener("click", squareClicked);
    clickCount = 0;
    console.log("täsmää")
}

// Tämä funktio katsoo onko peli loppunut, ensin sen jakaa neliöiden määrän kahdella ja kun kyseinen pistemäärä on täynnä niin peli loppuu
function checkGameEnded() {
    const target = numberOfsquares / 2;
    const gameOver = score === target ? true : false
    if(gameOver) {
        console.log("peli ohi")
        playAgainBtn.style.visibility = "visible";
    }
}

// Tämä funktio päivittää sivun ja nollaa pelin
function playAgain() {
    window.location.reload()
}