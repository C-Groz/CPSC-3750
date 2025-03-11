let song = document.getElementById("song");
song.addEventListener("timeupdate", updateSongTime)

let currentTitle = document.getElementById("current-title");

let rewindButton = document.getElementById("rewind");
rewindButton.addEventListener("click", rewind);

let playButton = document.getElementById("play");
playButton.addEventListener("click", playSong);

let forwardButton = document.getElementById("forward");
forwardButton.addEventListener("click", forward);

let addTitleButton = document.getElementById("add-title");
addTitleButton.addEventListener("click", addTitle);

let deleteTitleButton = document.getElementById("delete-title");
deleteTitleButton.addEventListener("click", deleteTitle);

let currentSongTime = document.getElementById("current-song-time");

let titleButtons = document.querySelectorAll('.title');
titleButtons.forEach(button => {
    button.addEventListener("click", function(){
        var time = parseFloat(button.getAttribute('data-time'));
        song.currentTime = time;
        currentTitle.innerText = button.innerText;
        currentTitleTime = time;
    })
});

let playing = false;
let currentTitleTime;
let titleCount = 6;

function forward(){
    if(song.currentTime + 5 < song.duration){
        song.currentTime += 5;
    }
    else{
        song.currentTime = song.duration;
    }
}

function rewind(){
    if(song.currentTime - 5 >= 0){
        song.currentTime -= 5;
    }
    else{
        song.currentTime = 0;
    }
}

function playSong(){
    if(!playing){
        song.play();
        playButton.innerText = "Pause";
        playing = true;
    }
    else{
        song.pause();
        playButton.innerText = "Play";
        playing = false;
    }
}

function updateSongTime(){
    currentSongTime.innerText = formatTime(song.currentTime);
}

function formatTime(secondsIn){
    var minutes = Math.floor(secondsIn/60);
    var seconds = Math.floor(secondsIn%60);
    if(seconds < 10){
        return "0" + minutes + ":0" + seconds + "";
    }
    else{
        return "0" + minutes + ":" + seconds + "";
    }
}


function addTitle(){
    if(titleCount >= 50)
        return;
    
    let titleTime = song.currentTime;
    let titleName = prompt("Enter name for title at " + formatTime(titleTime) + " seconds:");

    newTitle = document.createElement("button");
    newTitle.classList.add("title");
    newTitle.setAttribute("data-time", titleTime);
    newTitle.innerText = titleName;
    titleContainer = document.getElementById("title-container");

    // Insert button at correct position based on time
    let buttons = Array.from(titleContainer.getElementsByClassName("title"));
    let inserted = false;
    for(let i = 0; i < buttons.length; i++) {
        let currentButtonTime = parseFloat(buttons[i].getAttribute("data-time"));
        if(titleTime < currentButtonTime) {
            titleContainer.insertBefore(newTitle, buttons[i]);
            inserted = true;
            break;
        }
    }
    if(!inserted) {
        titleContainer.appendChild(newTitle);
    }

    newTitle.addEventListener("click", function(){
        var time = parseFloat(newTitle.getAttribute('data-time'));
        song.currentTime = time;
        currentTitle.innerText = newTitle.innerText;
        currentTitleTime = time;
    })
    
    titleCount++;
}

function deleteTitle(){
    if(currentTitleTime){
        titles = document.querySelectorAll(".title");
        titles.forEach(title => {
            if(title.getAttribute("data-time") == currentTitleTime){
                title.remove();
                currentTitle.innerText = "None";
                titleCount--;
            }
        })
    }
}