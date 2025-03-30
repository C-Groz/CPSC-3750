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
                    let movie = data.results[i];
                    let movieElement = document.createElement('li');
                    movieElement.textContent = `${movie.title} `;

                    let showDetailsButton = document.createElement('button');
                    showDetailsButton.textContent = "More Info"; 

                    let detailsContainer = document.createElement('div');
                    //detailsContainer.style.display = 'none';

                    let detailsText = document.createElement('p');
                    detailsText.textContent = movie.overview || "No description available.";
                    detailsContainer.appendChild(detailsText);

                    showDetailsButton.addEventListener('click', function(){
                        if(detailsContainer.style.display == 'none'){
                            detailsContainer.style.display = 'block'; 
                            detailsContainer.style.display = 'none'; 
                        }
                    });
                    
                    movieElement.appendChild(showDetailsButton);
                    movieElement.appendChild(detailsContainer);
                    resultsDiv.appendChild(movieElement);
            }
            }else{
                resultsDiv.innerHTML = "<p>No movies found.</p>";
            }
        })
        .catch(error => console.error('Error fetching movies:', error));
});