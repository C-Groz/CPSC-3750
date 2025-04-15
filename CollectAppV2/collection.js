document.addEventListener('DOMContentLoaded', function(){
    fetch('getCollection.php')
        .then(response => response.json())
        .then(data => {
            displayMovies(data);
        })
        .catch(error => console.error('Error fetching collection', error));
});

function displayMovies(movies){
    let resultsDiv = document.getElementById('collectionResults');
    resultsDiv.innerHTML = "";

    if(movies.length === 0){
        resultsDiv.innerHTML = "<p>No Movies in collection.</p>";
        return;
    }

    movies.forEach(movie => {
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
        showDetailsButton.addEventListener('click', function () {
            detailsContainer.style.display = detailsContainer.style.display === 'none' ? 'block' : 'none';
        });

        let deleteButton = document.createElement('button');
        deleteButton.textContent = "Delete";
        deleteButton.addEventListener('click', function () {
            deleteFromCollection(movie.id);
        });

        movieElement.appendChild(buttonContainer);
        buttonContainer.appendChild(showDetailsButton);
        buttonContainer.appendChild(deleteButton);
        resultsDiv.appendChild(movieElement);
        resultsDiv.appendChild(detailsContainer);
    });
}

function deleteFromCollection(movieId){
    fetch('deleteMovie.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: movieId })
    })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        })
        .catch(error => {
            console.error('Error deleting movie:', error);
        });
}
