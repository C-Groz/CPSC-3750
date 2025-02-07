let total = 0;
let moveInterval;

function makeButton(){
    let buttonColor = document.getElementById("dropdown_colors").value;
    let button = document.createElement("button");
    let paddingX = 50;
    let paddingY = 80;
    let randX = Math.floor(Math.random() * ((window.innerWidth - paddingX) - paddingX)) + paddingX;
    let randY = Math.floor(Math.random() * ((window.innerHeight- paddingY) - paddingY)) + paddingY;
    let value = Math.floor(Math.random() * 100);

    button.className = "newButton";
    button.textContent = value;
    button.onclick = function(){
        newButtonPress(button);
    }

    button.style.position = "absolute";
    button.style.background = buttonColor;
    button.style.zIndex = "100";
    button.style.top = randY + "px"
    button.style.left = randX + "px";

    button.dataset.directionX = (Math.random() > 0.5 ? 1 : -1) * (Math.floor(Math.random() * 3) + 1);
    button.dataset.directionY = (Math.random() > 0.5 ? 1 : -1) * (Math.floor(Math.random() * 3) + 1);

    document.body.appendChild(button);
}

function newButtonPress(button){
    let buttonValue = parseInt(button.textContent);
    let buttonColor = document.getElementById("dropdown_colors").value;
    button.style.background = buttonColor;
    total += buttonValue;
    document.getElementById("total").innerHTML = "Total: " + total;
}

function startMoving(){
    let moveButton = document.getElementById("move");
    let stopButton = document.getElementById("stop");
    if(!moveInterval){
        moveInterval = setInterval(move, 50);
    }
    moveButton.style.visibility = "hidden";
    stopButton.style.visibility = "visible";
}

function stopMoving(){
    let moveButton = document.getElementById("move");
    let stopButton = document.getElementById("stop");
    clearInterval(moveInterval);
    moveInterval = null;
    moveButton.style.visibility = "visible";
    stopButton.style.visibility = "hidden";
}


function move(){
    const buttons = document.getElementsByClassName("newButton");
    for(let i = 0; i < buttons.length; i++){
        let directionX = parseInt(buttons[i].dataset.directionX);
        let directionY = parseInt(buttons[i].dataset.directionY);

        let newLeft = parseInt(buttons[i].style.left) + directionX;
        let newTop = parseInt(buttons[i].style.top) + directionY;

        if (newLeft <= 0 || newLeft >= window.innerWidth - 25) {
            buttons[i].dataset.directionX = -directionX; 
        }
        if (newTop <= 85 || newTop >= window.innerHeight - 20) {
            buttons[i].dataset.directionY = -directionY; 
        }

        buttons[i].style.left = (parseInt(buttons[i].style.left) + parseInt(buttons[i].dataset.directionX)) + "px";
        buttons[i].style.top = (parseInt(buttons[i].style.top) + parseInt(buttons[i].dataset.directionY)) + "px";
    }
}