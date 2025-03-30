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

            if (data.results && data.results.length > 0) {
                for(var i = 0; i < numMovies; i++){
                    let movie = data.results[i];
                    let movieElement = document.createElement('p');
                    movieElement.textContent = `${movie.title} (${movie.release_date})`;
                    resultsDiv.appendChild(movieElement);
            }
            } else {
                resultsDiv.innerHTML = "<p>No movies found.</p>";
            }
        })
        .catch(error => console.error('Error fetching movies:', error));
});