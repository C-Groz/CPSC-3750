var cheatMode = false;
var cheatModeLabel = document.getElementById("cheat-mode-label");
var cheatModeBox = document.getElementById("cheat-mode-box");

var correctCount = 0;
var incorrectCount = 0;
var guessedLeters = [];
var currentWord;
var currentWordString;
const wordToGuess = document.getElementById('wordToGuess');



cheatModeBox.addEventListener("change", function(){
    if(cheatMode == true){
        cheatMode = false;
        cheatModeLabel.innerText = "Enable Cheat Mode";
    }
    else{
        cheatMode = true;
        cheatModeLabel.innerText = "Disable Cheat Mode";
    }
})

// test comment
function startGame() {
   // Fetch a new word from the server
   fetch('getWord.php')
       .then(response => response.json())
       .then(data => {
           if(data.word) {
			    if(cheatMode){    
                    alert(data.word);
                }
            setupGame(data.word);
           } else {
                console.error('Error fetching word:', data.error);
           }
       })
       .catch(error => console.error('Error:', error));
}

function setupGame(word) {
   currentWordString = '_ '.repeat(word.length).trim();
   wordToGuess.innerHTML = currentWordString;
   generateLetterButtons();
   currentWord = word;
}

function generateLetterButtons() {
   const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
   const lettersDiv = document.getElementById('letters');
   lettersDiv.innerHTML = ''; // Clear previous buttons
   letters.split('').forEach(letter => {
       const button = document.createElement('button');
       button.textContent = letter;
       button.onclick = () => guessLetter(letter);
       lettersDiv.appendChild(button);
   });
}

function guessLetter(letter) {
    let correct = false; 
    for(let i = 0; i < currentWord.length; i++){
        if(currentWord[i].toUpperCase() == letter && !guessedLeters.includes(letter)){
            guessedLeters.push(letter);
            correctGuess(letter, i);
            correct = true;
        }
    }
    if(!correct && !guessedLeters.includes(letter)){
        guessedLeters.push(letter);
        inCorrectGuess(letter);
    }
}

function correctGuess(letter, index){
    let currentWordArray = currentWordString.split('');
    currentWordArray[index * 2] = letter;
    currentWordString = currentWordArray.join('');
    wordToGuess.innerHTML = currentWordString;

    correctCount++;
    if(correctCount >= currentWord.length){
        alert("You Win!");
        correctCount = 0;
        incorrectCount = 0;
        guessedLeters = [];
    }
}

function inCorrectGuess(letter){
    incorrectCount++;
    guessedLeters.push(letter);
    let img = document.getElementById('img');
    img.src = "" + (incorrectCount + 1) + ".jpeg";

    if(incorrectCount >= 11){
        alert("You Lose. The word was " + currentWord);
        correctCount = 0;
        incorrectCount = 0;
        guessedLeters = [];
        img.src = "1.jpeg";
        startGame();
    }
}


// Initially start the game
startGame();
