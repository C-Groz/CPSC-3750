document.getElementById('movieForm').addEventListener('submit', function(event) {
    event.preventDefault(); 

    const query = document.getElementById('movieQuery').value;
    const numMovies = document.getElementById('numMovies').value;

    if(numMovies == null){
        numMovies = 1;
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
                    
                    movieElement.appendChild(showDetailsButton);
                    resultsDiv.appendChild(movieElement);
                    resultsDiv.appendChild(detailsContainer);
            }
            }else{
                resultsDiv.innerHTML = "<p>No movies found.</p>";
            }
        })
        .catch(error => console.error('Error fetching movies:', error));
});