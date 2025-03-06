function startGame() {
   // Fetch a new word from the server
   fetch('getWord.php')
       .then(response => response.json())
       .then(data => {
           if(data.word) {
						   alert(data.word);
               setupGame(data.word);
           } else {
               console.error('Error fetching word:', data.error);
           }
       })
       .catch(error => console.error('Error:', error));
}

function setupGame(word) {
   const wordToGuess = document.getElementById('wordToGuess');
   wordToGuess.innerHTML = '_ '.repeat(word.length).trim();
   generateLetterButtons();
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
   console.log('Guessed letter:', letter);
   // Implement the guessing logic here
   // This is where you would update the displayed word or handle incorrect guesses
}

// Initially start the game
startGame();
