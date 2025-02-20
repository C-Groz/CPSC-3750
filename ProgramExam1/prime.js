// Charlie Grozier
// 2/20/25
// CPSC 3750
// Programming Exam #1
// Grade level: B

document.getElementById("startButton").addEventListener("click", function(){
    if(!ascend){
        generateListsAscend();
    }
    else{
        generateListsDecend();
    }
});

document.getElementById("modeButton").addEventListener("click", toggleMode);
document.getElementById("sort").addEventListener("click", sort);
document.addEventListener("DOMContentLoaded", animation);

let darkMode = false;
let ascend = true;

function isPrime(n){
    // Ensure numbers less than or equal to 1 are classified as not prime
    if(n <= 1){
        return false;
    }
    
    // Return false if number is not prime
    for(let i = 2; i <= Math.sqrt(n); i++){
        if(n % i == 0){
            return false;
        }
    }

    // If reached, number is prime
    return true;
}

function generateListsDecend(){
    let userInput = document.getElementById("numberInput").value;
    let primeList = document.getElementById("primeList");
    let nonPrimeList = document.getElementById("nonPrimeList");

    // Clear previous list output
    primeList.innerHTML = " ";
    nonPrimeList.innerHTML = " ";

    // Dynamically append prime and non-prime numbers to appropriate lists in descending order
    for(let i = 1; i <= userInput; i++){
        let numberElement = document.createElement("ul");
        numberElement.innerText = i;

        if(isPrime(i)){
            primeList.appendChild(numberElement);
        }
        else{
            nonPrimeList.appendChild(numberElement);
        }
    }
}

function generateListsAscend(){
    let userInput = document.getElementById("numberInput").value;
    let primeList = document.getElementById("primeList");
    let nonPrimeList = document.getElementById("nonPrimeList");

    // Clear previous list output
    primeList.innerHTML = " ";
    nonPrimeList.innerHTML = " ";

    // Dynamically append prime and non-prime numbers to appropriate lists in ascending order
    for(let i = userInput; i >= 1; i--){
        let numberElement = document.createElement("ul");
        numberElement.innerText = i;

        if(isPrime(i)){
            primeList.appendChild(numberElement);
        }
        else{
            nonPrimeList.appendChild(numberElement);
        }
    }
}

function toggleMode(){

    // Toggle Dark Mode
    if(!darkMode){
        darkMode = true;

        // Invert button colors and change toggle mode button text
        document.getElementById("modeButton").innerText = "Toggle Light Mode";
        let buttons = document.getElementsByClassName("buttons");
        
        for(let i = 0; i <= 1; i++){
            buttons[i].style.background = "#383838";
            buttons[i].style.color = "white";
        }

        // Invert background color
        document.body.style.backgroundColor = "#383838";

        let lists = document.getElementsByClassName("list");
        lists[0].style.background = "#282828";
        lists[1].style.background = "#282828";

        let text = document.getElementsByClassName("text");
        for(let i = 0; i <= 5; i++){
            text[i].style.color = "white";
        }

    }

    // Toggle Light Mode
    else{
        darkMode = false;

        // Invert button colors and change toggle mode button text
        document.getElementById("modeButton").innerText = "Toggle Dark Mode";
        let buttons = document.getElementsByClassName("buttons");
        
        for(let i = 0; i <= 1; i++){
            buttons[i].style.background = "#f4f4f4";
            buttons[i].style.color = "black";
        }

        // Invert background color
        document.body.style.backgroundColor = "#f4f4f4";

        let lists = document.getElementsByClassName("list");
        lists[0].style.background = "white";
        lists[1].style.background = "white";

        let text = document.getElementsByClassName("text");
        for(let i = 0; i <= 5; i++){
            text[i].style.color = "black";
        }
    }
}

// Sort Lists in ascending or descending order
function sort(){
    if(!ascend){
        ascend = true;
        document.getElementById("sort").innerText = "Sort Descending";
        generateListsDecend();
    }
    else{
        ascend = false;
        document.getElementById("sort").innerText = "Sort Ascending";
        generateListsAscend();
    }
}

// Toggle color animation
function animation(){
    let primeDiv = document.getElementById("prime-div");
    let nonPrimeDiv = document.getElementById("non-prime-div");

    setInterval(() => {
        primeDiv.style.animation = "color-start 5s alternate";
        nonPrimeDiv.style.animation = "color-end 5s alternate";
        setTimeout(() => {
            primeDiv.style.animation = "color-end 5s alternate";
            nonPrimeDiv.style.animation = "color-start 5s alternate";
        }, 5000);
    }, 10000);
};