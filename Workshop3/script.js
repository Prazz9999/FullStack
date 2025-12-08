// script.js
const API_URL = 'http://localhost:3000/movies';

const movieListDiv = document.getElementById('movie-list');
const searchInput = document.getElementById('search-input');
const form = document.getElementById('add-movie-form');

let allMovies = []; // full list from server

// Render movies to DOM
function renderMovies(moviesToDisplay) {
  movieListDiv.innerHTML = '';
  if (!moviesToDisplay || moviesToDisplay.length === 0) {
    const p = document.createElement('div');
    p.className = 'no-results';
    p.textContent = 'No movies found matching your criteria.';
    movieListDiv.appendChild(p);
    return;
  }

  moviesToDisplay.forEach(movie => {
    const wrapper = document.createElement('div');
    wrapper.className = 'movie-item';

    const info = document.createElement('div');
    info.innerHTML = `<p>${escapeHtml(movie.title)} <small>(${movie.year})</small></p>
                      <small>${escapeHtml(movie.genre || '—')}</small>`;

    const controls = document.createElement('div');
    controls.className = 'controls';

    const editBtn = document.createElement('button');
    editBtn.textContent = 'Edit';
    editBtn.addEventListener('click', () => editMoviePrompt(movie));

    const delBtn = document.createElement('button');
    delBtn.textContent = 'Delete';
    delBtn.className = 'delete';
    delBtn.addEventListener('click', () => {
      if (confirm(`Delete "${movie.title}"?`)) {
        deleteMovie(movie.id);
      }
    });

    controls.appendChild(editBtn);
    controls.appendChild(delBtn);

    wrapper.appendChild(info);
    wrapper.appendChild(controls);
    movieListDiv.appendChild(wrapper);
  });
}

// Basic HTML-escaping for safety in rendering
function escapeHtml(str) {
  if (typeof str !== 'string') return str;
  return str.replaceAll('&', '&amp;').replaceAll('<', '&lt;').replaceAll('>', '&gt;').replaceAll('"', '&quot;').replaceAll("'", '&#39;');
}

// Fetch all movies (READ)
function fetchMovies() {
  fetch(API_URL)
    .then(res => {
      if (!res.ok) throw new Error(`Server error: ${res.status}`);
      return res.json();
    })
    .then(movies => {
      allMovies = Array.isArray(movies) ? movies : [];
      renderMovies(allMovies);
    })
    .catch(err => {
      console.error('Error fetching movies:', err);
      movieListDiv.innerHTML = `<div class="no-results">Unable to fetch movies. Is the JSON Server running? <br><small>${err.message}</small></div>`;
    });
}
fetchMovies();

// Search filtering (client-side)
searchInput.addEventListener('input', () => {
  const term = searchInput.value.trim().toLowerCase();
  if (!term) {
    renderMovies(allMovies);
    return;
  }
  const filtered = allMovies.filter(m => {
    const title = (m.title || '').toLowerCase();
    const genre = (m.genre || '').toLowerCase();
    return title.includes(term) || genre.includes(term) || String(m.year || '').includes(term);
  });
  renderMovies(filtered);
});

// CREATE new movie (POST)
form.addEventListener('submit', function (e) {
  e.preventDefault();

  const title = document.getElementById('title').value.trim();
  const genre = document.getElementById('genre').value.trim();
  const yearVal = document.getElementById('year').value.trim();
  const year = parseInt(yearVal, 10);

  if (!title) {
    alert('Title is required.');
    return;
  }
  if (!yearVal || Number.isNaN(year)) {
    alert('Please provide a valid year.');
    return;
  }

  const newMovie = { title, genre, year };

  fetch(API_URL, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(newMovie)
  })
    .then(res => {
      if (!res.ok) throw new Error('Failed to add movie');
      return res.json();
    })
    .then(created => {
      form.reset();
      fetchMovies();
    })
    .catch(err => {
      console.error('Error adding movie:', err);
      alert('Error adding movie. See console for details.');
    });
});

// Prompt user for updated fields and call update
function editMoviePrompt(movie) {
  const newTitle = prompt('Enter new Title:', movie.title);
  if (newTitle === null) return; // cancelled

  const newYearStr = prompt('Enter new Year:', movie.year);
  if (newYearStr === null) return;

  const newGenre = prompt('Enter new Genre:', movie.genre || '');
  if (newGenre === null) return;

  const newYear = parseInt(newYearStr, 10);
  if (!newTitle.trim()) {
    alert('Title cannot be empty.');
    return;
  }
  if (Number.isNaN(newYear)) {
    alert('Year must be a valid number.');
    return;
  }

  const updated = { id: movie.id, title: newTitle.trim(), genre: newGenre.trim(), year: newYear };
  updateMovie(movie.id, updated);
}

// UPDATE (PUT)
function updateMovie(id, updatedMovieData) {
  fetch(`${API_URL}/${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(updatedMovieData)
  })
    .then(res => {
      if (!res.ok) throw new Error('Failed to update movie');
      return res.json();
    })
    .then(() => fetchMovies())
    .catch(err => {
      console.error('Error updating movie:', err);
      alert('Error updating movie. See console for details.');
    });
}

// DELETE
function deleteMovie(id) {
  fetch(`${API_URL}/${id}`, { method: 'DELETE' })
    .then(res => {
      if (!res.ok) throw new Error('Failed to delete movie');
      fetchMovies();
    })
    .catch(err => {
      console.error('Error deleting movie:', err);
      alert('Error deleting movie. See console for details.');
    });
}
