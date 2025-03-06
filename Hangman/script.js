var cheatMode = false;
var cheatModeLabel = document.getElementById("cheat-mode-label");
var cheatModeBox = document.getElementById("cheat-mode-box");

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
        if(currentWord[i] == letter){
            correctGuess(currentWord[i], i);
            correct = true;
        }
    }
    if(!correct){
        inCorrectGuess(letter);
    }
}

function correctGuess(letter, index){
    currentWordString[index * 2] = letter;
    wordToGuess = currentWordString;
}

function inCorrectGuess(letter){
    
}


// Initially start the game
startGame();
