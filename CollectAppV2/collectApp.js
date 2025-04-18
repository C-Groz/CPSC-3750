document.getElementById('movieForm').addEventListener('submit', function(event) {
    event.preventDefault(); 

    const query = document.getElementById('movieQuery').value;
    const numMovies = document.getElementById('numMovies').value;

    if(numMovies == null || numMovies < 0){
        numMovies = 1;
    }

    if(numMovies >= 100){
        numMovies = 100;
    }

    fetch(`fetchMovies.php?query=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            console.log(data);
            let resultsDiv = document.getElementById('results');
            resultsDiv.innerHTML = ""; 

            if(data.results && data.results.length > 0){
                for(var i = 0; i < numMovies; i++){
                    if(data.results[i] == null)
                        break;
                    let movie = data.results[i];
                    let movieElement = document.createElement('li');
                    movieElement.textContent = `${movie.title} `;

                    let detailsContainer = document.createElement('div');
                    detailsContainer.style.display = 'none';
                    detailsContainer.className = "details";

                    let detailsText = document.createElement('p');
                    detailsText.innerHTML = "Overview: " + (movie.overview || "No description available.") + "<br>Release Date: " + (movie.release_date || "No release date available.") + "<br>Popularity: " + (movie.popularity || "No popularity available.");
                    detailsContainer.appendChild(detailsText);

                    let buttonContainer = document.createElement('div');


                    let showDetailsButton = document.createElement('button');
                    showDetailsButton.textContent = "More Info"; 

                    showDetailsButton.addEventListener('click', function(){
                        if(detailsContainer.style.display == 'none'){
                            detailsContainer.style.display = 'block'; 
                        }
                        else{
                            detailsContainer.style.display = 'none'; 
                        }
                    });

                    let saveButton = document.createElement('button');
                    saveButton.textContent = "Save"; 
                    saveButton.addEventListener('click', function(){
                        saveToCollection(movie);
                    });
                    
                    movieElement.appendChild(buttonContainer);
                    buttonContainer.appendChild(showDetailsButton);
                    buttonContainer.appendChild(saveButton);
                    resultsDiv.appendChild(movieElement);
                    resultsDiv.appendChild(detailsContainer);
            }
            }else{
                resultsDiv.innerHTML = "<p>No movies found.</p>";
            }
        })
        .catch(error => console.error('Error fetching movies:', error));
});

function saveToCollection(movie){
    fetch('saveMovie.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(movie) 
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
    })
    .catch(error => {
        console.error('Error saving movie:', error);
    });
}