const canvas = document.getElementById("game-area");
const ctx = canvas.getContext("2d");

let x = 100;
let y = 100;
let radius = 50;
let speed = 10;

let upPressed = false;
let downPressed = false;
let leftPressed = false;
let rightPressed = false;

function drawGame() {
    requestAnimationFrame(drawGame);
    clearScreen();
    inputs();
    drawGreenBlob();
}

function inputs() {
        
    if(upPressed) {
        y =  y - speed;
    }
    if (downPressed) {
        y = y + speed;
    }
    if (leftPressed) {
        x = x - speed;
    }
    if (rightPressed) {
        x = x + speed;
    }
}

function drawGreenBlob(){
    ctx.fillStyle = "green";
    ctx.beginPath();
    ctx.arc(x, y, radius, 0, Math.PI * 2);
    ctx.fill();
}


function clearScreen(){
    ctx.fillStyle = "black";
    ctx.fillRect(0,0, canvas.width, canvas.height);
}

document.body.addEventListener('keydown', keyDown);
document.body.addEventListener('keyup', keyUp);

function keyDown(event) {
    
    if(event.keyCode == 38) {
        upPressed = true;
    }
    
    if(event.keyCode == 40) {
        downPressed = true;
    }

    if(event.keyCode == 37) {
        leftPressed = true;
    }

    if(event.keyCode == 39) {
        rightPressed = true;
    }
}

function keyUp(event) {
    
    if (event.keyCode == 38) {
        downPressed = false;
    }

    if(event.keyCode == 40) {
        downPressed = false;
    }

    if(event.keyCode == 37) {
        leftPressed = false;
    }

    if(event.keyCode == 39) {
        rightPressed = false;
    }
}

drawGame();
