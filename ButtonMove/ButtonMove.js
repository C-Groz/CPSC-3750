let total = 0;
let moveInterval;

//function which creates a new button in the viewing area
function makeButton(){
    let buttonColor = document.getElementById("dropdown_colors").value;
    let button = document.createElement("button");
    let paddingX = 50;
    let paddingY = 100;
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

    //create random initial direction to move
    button.dataset.directionX = (Math.random() > 0.5 ? 1 : -1) * (Math.floor(Math.random() * 3) + 1);
    button.dataset.directionY = (Math.random() > 0.5 ? 1 : -1) * (Math.floor(Math.random() * 3) + 1);

    document.body.appendChild(button);
}

//function which increments total and changes button color when clicked
function newButtonPress(button){
    let buttonValue = parseInt(button.textContent);
    let buttonColor = document.getElementById("dropdown_colors").value;
    button.style.background = buttonColor;
    total += buttonValue;
    document.getElementById("total").innerHTML = "Total: " + total;
}

//function which begins movement and switches move button to stop
function startMoving(){
    let moveButton = document.getElementById("move");
    let stopButton = document.getElementById("stop");
    if(!moveInterval){
        moveInterval = setInterval(move, 50);
    }
    moveButton.style.visibility = "hidden";
    stopButton.style.visibility = "visible";
}

//function which stops movement and switches stop button to move
function stopMoving(){
    let moveButton = document.getElementById("move");
    let stopButton = document.getElementById("stop");
    clearInterval(moveInterval);
    moveInterval = null;
    moveButton.style.visibility = "visible";
    stopButton.style.visibility = "hidden";
}

//function which is continuously called for movement 
function move(){
    const buttons = document.getElementsByClassName("newButton");
    for(let i = 0; i < buttons.length; i++){

        //store initial direction
        let directionX = parseInt(buttons[i].dataset.directionX);
        let directionY = parseInt(buttons[i].dataset.directionY);

        //calclate new coordinates for button
        let newLeft = parseInt(buttons[i].style.left) + directionX;
        let newTop = parseInt(buttons[i].style.top) + directionY;

        //check for edges of screen, if on edge invert direction
        if(newLeft <= 0 || newLeft >= window.innerWidth - 25) {
            buttons[i].dataset.directionX = -directionX; 
        }
        if(newTop <= 110 || newTop >= window.innerHeight - 20) {
            buttons[i].dataset.directionY = -directionY; 
        }

        //update position of button
        buttons[i].style.left = (parseInt(buttons[i].style.left) + parseInt(buttons[i].dataset.directionX)) + "px";
        buttons[i].style.top = (parseInt(buttons[i].style.top) + parseInt(buttons[i].dataset.directionY)) + "px";
    }
}