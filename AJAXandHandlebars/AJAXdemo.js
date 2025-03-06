
var pageCounter = 1;
var btn = document.getElementById("btn");
var animalContainer = document.getElementById("animal-info");

btn.addEventListener("click", function(){
    var ourRequest = new XMLHttpRequest();
    ourRequest.open('GET', 'https://learnwebcode.github.io/json-example/animals-' + pageCounter + '.json');
    ourRequest.onload = function(){
        if(ourRequest.status >= 200 && ourRequest.status < 400){
            var ourData = JSON.parse(ourRequest.responseText);
            renderHTML(ourData);
        }
        else{
            console.log("Connection Error");
        }  
    }

    ourRequest.send();
    pageCounter++;
    if(pageCounter > 3){
        btn.style.display = "none";
    }
});

function renderHTML(data){
    var rawTemplate = document.getElementById("animal-info-template").innerHTML;
    var compliledTemplate = Handlebars.compile(rawTemplate);
    var ourGeneratedHTML = compliledTemplate(data);

    var animalContainer = document.getElementById("animal-container");
    animalContainer.innerHTML += ourGeneratedHTML;
}

