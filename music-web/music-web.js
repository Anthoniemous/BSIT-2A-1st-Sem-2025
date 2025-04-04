// DOM Elements
const musicContainer = document.getElementById("music-container");
const trendingContainer = document.getElementById("trending-container");
const playlistContainer = document.getElementById("playlist-container");
const genresContainer = document.getElementById("genres-container");

const searchInput = document.getElementById("search");
const themeToggle = document.getElementById("theme-toggle");
const navLinks = document.querySelectorAll(".nav-links a");
const sections = document.querySelectorAll(".section");

// Player elements
const audioPlayer = document.getElementById("audio-player");
const playerBar = document.getElementById("player-bar");
const playPauseBtn = document.getElementById("play-pause-btn");
const playIcon = document.getElementById("play-icon");
const prevBtn = document.getElementById("prev-btn");
const nextBtn = document.getElementById("next-btn");
const shuffleBtn = document.getElementById("shuffle-btn");
const repeatBtn = document.getElementById("repeat-btn");
const muteBtn = document.getElementById("mute-btn");
const volumeIcon = document.getElementById("volume-icon");
const currentTimeEl = document.getElementById("current-time");
const durationEl = document.getElementById("duration");
const playerProgress = document.getElementById("player-progress");
const playerProgressBar = document.getElementById("player-progress-bar");
const volumeProgress = document.getElementById("volume-progress");
const volumeSlider = document.getElementById("volume-slider");
const currentSongImg = document.getElementById("current-song-img");
const currentSongTitle = document.getElementById("current-song-title");
const currentSongArtist = document.getElementById("current-song-artist");

// Mobile elements
const menuToggle = document.getElementById("menu-toggle");
const navMenu = document.getElementById("nav-links");
const searchToggle = document.getElementById("search-toggle");
const searchContainer = document.querySelector(".search-container");

// Player state
const playerState = {
  currentSong: null,
  playlist: [],
  isPlaying: false,
  isShuffle: false,
  isRepeat: false,
  currentIndex: 0,
  volume: 1
};

// === THEME MANAGEMENT ===
// Check for saved theme preference
if (localStorage.getItem("theme") === "dark") {
  document.body.classList.add("dark-mode");
  themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
}

// Light/Dark Mode Toggle
themeToggle.addEventListener("click", () => {
  document.body.classList.toggle("dark-mode");
  const isDark = document.body.classList.contains("dark-mode");
  
  themeToggle.innerHTML = isDark ? 
    '<i class="fas fa-sun"></i>' : 
    '<i class="fas fa-moon"></i>';
    
  // Save preference
  localStorage.setItem("theme", isDark ? "dark" : "light");
});

// === NAVIGATION ===
// Switch Between Sections
navLinks.forEach(link => {
  link.addEventListener("click", (e) => {
    e.preventDefault();
    
    // Hide all sections
    sections.forEach(section => section.classList.add("hidden"));
    
    // Show selected section
    document.getElementById(link.dataset.section).classList.remove("hidden");
    
    // Update active link style
    navLinks.forEach(l => l.classList.remove("active"));
    link.classList.add("active");
    
    // Close mobile menu after selection
    navMenu.classList.remove("active");
  });
});

// Mobile menu toggle
menuToggle.addEventListener("click", () => {
  navMenu.classList.toggle("active");
});

// Mobile search toggle
searchToggle.addEventListener("click", () => {
  searchContainer.classList.toggle("active");
  if (searchContainer.classList.contains("active")) {
    searchInput.focus();
  }
});

// Close mobile menu when clicking outside
document.addEventListener("click", (e) => {
  if (!e.target.closest("nav") && navMenu.classList.contains("active")) {
    navMenu.classList.remove("active");
  }
});

// === API & DATA HANDLING ===
// Fetch Music from API with improved error handling
async function fetchMusic(query = "pop", container, limit = 12) {
  try {
    showLoading(container);
    const url = `https://itunes.apple.com/search?term=${encodeURIComponent(query)}&limit=${limit}&media=music`;
    const response = await fetch(url);
    
    if (!response.ok) {
      throw new Error(`API error: ${response.status}`);
    }
    
    const data = await response.json();
    
    if (data.results && data.results.length > 0) {
      displayMusic(data.results, container);
    } else {
      showNoResults(container);
    }
  } catch (error) {
    console.error("Error fetching music:", error);
    showError(container, error.message);
  }
}

// Show loading state
function showLoading(container) {
  container.innerHTML = `
    <div class="no-results">
      <i class="fas fa-spinner fa-spin"></i>
      <p>Loading songs...</p>
    </div>
  `;
}

// Show no results state
function showNoResults(container) {
  container.innerHTML = `
    <div class="no-results">
      <i class="fas fa-music"></i>
      <p>No songs found. Try a different search term.</p>
    </div>
  `;
}

// Show error state
function showError(container, message) {
  container.innerHTML = `
    <div class="no-results">
      <i class="fas fa-exclamation-circle"></i>
      <p>Oops! Something went wrong.</p>
      <small>${message}</small>
    </div>
  `;
}

// Display Music in the UI with improved UI
function displayMusic(songs, container) {
  container.innerHTML = "";
  
  songs.forEach((song, index) => {
    // Skip songs without preview URLs
    if (!song.previewUrl) return;
    
    const songDiv = document.createElement("div");
    songDiv.classList.add("song");
    
    // Use higher resolution artwork if available
    const artworkUrl = song.artworkUrl100?.replace('100x100', '400x400') || song.artworkUrl100;
    
    songDiv.innerHTML = `
      <div class="song-image">
        <img src="${artworkUrl}" alt="${song.trackName || 'Unknown Song'}" loading="lazy">
        <div class="song-overlay">
          <button class="play-btn" aria-label="Play">
            <i class="fas fa-play"></i>
          </button>
        </div>
      </div>
      <div class="song-info">
        <h3 class="song-title">${song.trackName || 'Unknown Song'}</h3>
        <p class="song-artist">${song.artistName || 'Unknown Artist'}</p>
        <div class="audio-progress">
          <div class="progress-bar"></div>
        </div>
        <div class="song-controls">
          <div class="song-actions">
            <button class="action-btn add-to-playlist" aria-label="Add to playlist">
              <i class="fas fa-plus"></i>
            </button>
            <button class="action-btn share-song" aria-label="Share song">
              <i class="fas fa-share-alt"></i>
            </button>
          </div>
        </div>
      </div>
    `;
    
    container.appendChild(songDiv);
    
    // Complete song object with additional data
    const completeSong = {
      ...song,
      element: songDiv,
      progressBar: songDiv.querySelector('.progress-bar'),
      index: index
    };
    
    // Play button click event
    const playBtn = songDiv.querySelector('.play-btn');
    playBtn.addEventListener('click', () => {
      playSong(completeSong);
    });
    
    // Add to playlist button click event
    const addToPlaylistBtn = songDiv.querySelector('.add-to-playlist');
    addToPlaylistBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      saveToPlaylist(completeSong);
    });
    
    // Share button click event
    const shareBtn = songDiv.querySelector('.share-song');
    shareBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      shareSong(completeSong);
    });
  });
}

// === AUDIO PLAYER FUNCTIONALITY ===
// Play selected song
function playSong(song) {
  // If this is a new song
  if (!playerState.currentSong || playerState.currentSong.trackId !== song.trackId) {
    // Reset UI of previous song if exists
    if (playerState.currentSong && playerState.currentSong.element) {
      const previousPlayBtn = playerState.currentSong.element.querySelector('.play-btn i');
      if (previousPlayBtn) previousPlayBtn.className = 'fas fa-play';
    }
    
    // Update player state
    playerState.currentSong = song;
    
    // Set audio source
    audioPlayer.src = song.previewUrl;
    audioPlayer.load();
    
    // Update player UI
    currentSongImg.src = song.artworkUrl100?.replace('100x100', '400x400') || song.artworkUrl100;
    currentSongTitle.textContent = song.trackName || 'Unknown Song';
    currentSongArtist.textContent = song.artistName || 'Unknown Artist';
    
    // Show player bar
    playerBar.classList.add('active');
    
    // Play audio
    audioPlayer.play().catch(err => {
      console.error('Error playing audio:', err);
      showToast('Error playing this song. Please try another.', 'error');
    });
    
    // Update UI
    playerState.isPlaying = true;
    playIcon.className = 'fas fa-pause';
    song.element.querySelector('.play-btn i').className = 'fas fa-pause';
    
    // Add to history
    addToHistory(song);
  } else {
    // Toggle play/pause for current song
    togglePlayPause();
  }
}

// Toggle Play/Pause
function togglePlayPause() {
  if (!playerState.currentSong) return;
  
  if (playerState.isPlaying) {
    audioPlayer.pause();
    playerState.isPlaying = false;
    playIcon.className = 'fas fa-play';
    if (playerState.currentSong.element) {
      playerState.currentSong.element.querySelector('.play-btn i').className = 'fas fa-play';
    }
  } else {
    audioPlayer.play();
    playerState.isPlaying = true;
    playIcon.className = 'fas fa-pause';
    if (playerState.currentSong.element) {
      playerState.currentSong.element.querySelector('.play-btn i').className = 'fas fa-pause';
    }
  }
}

// Format time (seconds to MM:SS)
function formatTime(seconds) {
  const minutes = Math.floor(seconds / 60);
  const remainingSeconds = Math.floor(seconds % 60);
  return `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
}

// Update progress bar
function updateProgress() {
  if (!audioPlayer.duration) return;
  
  const currentTime = audioPlayer.currentTime;
  const duration = audioPlayer.duration;
  const progressPercent = (currentTime / duration) * 100;
  
  // Update player progress bar
  playerProgress.style.width = `${progressPercent}%`;
  
  // Update time displays
  currentTimeEl.textContent = formatTime(currentTime);
  durationEl.textContent = formatTime(duration);
  
  // Update song item progress bar if visible
  if (playerState.currentSong && playerState.currentSong.progressBar) {
    playerState.currentSong.progressBar.style.width = `${progressPercent}%`;
  }
}

// Play next song
function playNext() {
  if (!playerState.playlist || playerState.playlist.length === 0) return;
  
  let nextIndex = playerState.currentIndex + 1;
  
  // Handle shuffle
  if (playerState.isShuffle) {
    nextIndex = Math.floor(Math.random() * playerState.playlist.length);
  } 
  // Loop back to start if at end
  else if (nextIndex >= playerState.playlist.length) {
    nextIndex = 0;
  }
  
  playerState.currentIndex = nextIndex;
  playSong(playerState.playlist[nextIndex]);
}

// Play previous song
function playPrevious() {
  if (!playerState.playlist || playerState.playlist.length === 0) return;
  
  // If current time > 3 seconds, restart song instead of previous
  if (audioPlayer.currentTime > 3) {
    audioPlayer.currentTime = 0;
    return;
  }
  
  let prevIndex = playerState.currentIndex - 1;
  
  // Loop to end if at start
  if (prevIndex < 0) {
    prevIndex = playerState.playlist.length - 1;
  }
  
  playerState.currentIndex = prevIndex;
  playSong(playerState.playlist[prevIndex]);
}

// Set progress when clicking on progress bar
function setProgress(e) {
  const width = this.clientWidth;
  const clickX = e.offsetX;
  const duration = audioPlayer.duration;
  
  if (isNaN(duration) || !isFinite(duration)) return;
  
  audioPlayer.currentTime = (clickX / width) * duration;
}

// Set volume when clicking on volume slider
function setVolume(e) {
  const width = this.clientWidth;
  const clickX = e.offsetX;
  const volume = clickX / width;
  
  audioPlayer.volume = volume;
  playerState.volume = volume;
  volumeProgress.style.width = `${volume * 100}%`;
  
  // Update volume icon
  updateVolumeIcon(volume);
  
  // Save volume preference
  localStorage.setItem('volume', volume);
}

// Update volume icon based on volume level
function updateVolumeIcon(volume) {
  if (volume === 0) {
    volumeIcon.className = 'fas fa-volume-mute';
  } else if (volume < 0.5) {
    volumeIcon.className = 'fas fa-volume-down';
  } else {
    volumeIcon.className = 'fas fa-volume-up';
  }
}

// Toggle mute
function toggleMute() {
  if (audioPlayer.volume > 0) {
    // Store current volume before muting
    playerState.lastVolume = audioPlayer.volume;
    audioPlayer.volume = 0;
    volumeProgress.style.width = '0%';
    volumeIcon.className = 'fas fa-volume-mute';
  } else {
    // Restore previous volume
    const volume = playerState.lastVolume || 0.5;
    audioPlayer.volume = volume;
    volumeProgress.style.width = `${volume * 100}%`;
    updateVolumeIcon(volume);
  }
}

// Toggle shuffle mode
function toggleShuffle() {
  playerState.isShuffle = !playerState.isShuffle;
  shuffleBtn.classList.toggle('active');
  
  showToast(`Shuffle ${playerState.isShuffle ? 'enabled' : 'disabled'}`, 'info');
}

// Toggle repeat mode
function toggleRepeat() {
  playerState.isRepeat = !playerState.isRepeat;
  repeatBtn.classList.toggle('active');
  
  showToast(`Repeat ${playerState.isRepeat ? 'enabled' : 'disabled'}`, 'info');
}

// === PLAYLIST MANAGEMENT ===
// Save to playlist with deduplication
function saveToPlaylist(song) {
  let playlist = JSON.parse(localStorage.getItem("playlist")) || [];
  
  // Check if song already exists in playlist
  if (!playlist.some(item => item.trackId === song.trackId)) {
    playlist.push({
      trackId: song.trackId,
      trackName: song.trackName,
      artistName: song.artistName,
      artworkUrl100: song.artworkUrl100,
      previewUrl: song.previewUrl,
      date: new Date().toISOString()
    });
    
    localStorage.setItem("playlist", JSON.stringify(playlist));
    showToast(`"${song.trackName}" added to your library`, 'success');
    
    // Refresh playlist view if currently visible
    if (!document.getElementById("playlists").classList.contains("hidden")) {
      loadPlaylist();
    }
  } else {
    showToast(`"${song.trackName}" is already in your library`, 'info');
  }
}

// Load and display playlist
function loadPlaylist() {
  const playlist = JSON.parse(localStorage.getItem("playlist")) || [];
  
  if (playlist.length === 0) {
    playlistContainer.innerHTML = `
      <div class="no-results">
        <i class="fas fa-music"></i>
        <p>Your library is empty. Start adding songs you love!</p>
      </div>
    `;
    return;
  }
  
  // Store in player state
  playerState.playlist = playlist;
  
  // Display playlist
  playlistContainer.innerHTML = "";
  playlist.forEach((song, index) => {
    const songDiv = document.createElement("div");
    songDiv.classList.add("song");
    
    // Use higher resolution artwork if available
    const artworkUrl = song.artworkUrl100?.replace('100x100', '400x400') || song.artworkUrl100;
    
    songDiv.innerHTML = `
      <div class="song-image">
        <img src="${artworkUrl}" alt="${song.trackName || 'Unknown Song'}" loading="lazy">
        <div class="song-overlay">
          <button class="play-btn" aria-label="Play">
            <i class="fas fa-play"></i>
          </button>
        </div>
      </div>
      <div class="song-info">
        <h3 class="song-title">${song.trackName || 'Unknown Song'}</h3>
        <p class="song-artist">${song.artistName || 'Unknown Artist'}</p>
        <div class="audio-progress">
          <div class="progress-bar"></div>
        </div>
        <div class="song-controls">
          <div class="song-actions">
            <button class="action-btn remove-from-playlist" data-trackid="${song.trackId}" aria-label="Remove from playlist">
              <i class="fas fa-trash"></i>
            </button>
            <button class="action-btn share-song" aria-label="Share song">
              <i class="fas fa-share-alt"></i>
            </button>
          </div>
        </div>
      </div>
    `;
    
    playlistContainer.appendChild(songDiv);
    
    // Complete song object with additional data
    const completeSong = {
      ...song,
      element: songDiv,
      progressBar: songDiv.querySelector('.progress-bar'),
      index: index
    };
    
    // Play button click event
    const playBtn = songDiv.querySelector('.play-btn');
    playBtn.addEventListener('click', () => {
      playerState.currentIndex = index;
      playSong(completeSong);
    });
    
    // Remove from playlist button click event
    const removeBtn = songDiv.querySelector('.remove-from-playlist');
    removeBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      removeFromPlaylist(song.trackId);
    });
    
    // Share button click event
    const shareBtn = songDiv.querySelector('.share-song');
    shareBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      shareSong(completeSong);
    });
  });
}

// Remove song from playlist
function removeFromPlaylist(trackId) {
  let playlist = JSON.parse(localStorage.getItem("playlist")) || [];
  const songToRemove = playlist.find(song => song.trackId === trackId);
  
  if (songToRemove) {
    playlist = playlist.filter(song => song.trackId !== trackId);
    localStorage.setItem("playlist", JSON.stringify(playlist));
    
    // Update player state
    playerState.playlist = playlist;
    
    // Show toast
    showToast(`"${songToRemove.trackName}" removed from your library`, 'success');
    
    // Refresh playlist
    loadPlaylist();
  }
}

// Clear entire playlist
function clearPlaylist() {
  if (confirm('Are you sure you want to clear your entire library?')) {
    localStorage.removeItem("playlist");
    playerState.playlist = [];
    showToast('Your library has been cleared', 'success');
    loadPlaylist();
  }
}

// Sort playlist
function sortPlaylist() {
  let playlist = JSON.parse(localStorage.getItem("playlist")) || [];
  
  if (playlist.length <= 1) return;
  
  // Cycle through sort options: alphabetical → artist → date added
  const currentSort = localStorage.getItem("playlistSort") || "date";
  let newSort;
  
  switch (currentSort) {
    case "date":
      playlist.sort((a, b) => a.trackName.localeCompare(b.trackName));
      newSort = "name";
      showToast('Sorted by song name', 'info');
      break;
    case "name":
      playlist.sort((a, b) => a.artistName.localeCompare(b.artistName));
      newSort = "artist";
      showToast('Sorted by artist name', 'info');
      break;
    case "artist":
      playlist.sort((a, b) => new Date(b.date) - new Date(a.date));
      newSort = "date";
      showToast('Sorted by date added', 'info');
      break;
  }
  
  localStorage.setItem("playlistSort", newSort);
  localStorage.setItem("playlist", JSON.stringify(playlist));
  
  // Update player state
  playerState.playlist = playlist;
  
  // Refresh playlist view
  loadPlaylist();
}

// Add song to history
function addToHistory(song) {
  let history = JSON.parse(localStorage.getItem("musicHistory")) || [];
  
  // Remove the song if it already exists in history
  history = history.filter(item => item.trackId !== song.trackId);
  
  // Add song to the beginning of the array
  history.unshift({
    trackId: song.trackId,
    trackName: song.trackName,
    artistName: song.artistName,
    artworkUrl100: song.artworkUrl100,
    previewUrl: song.previewUrl,
    timestamp: new Date().toISOString()
  });
  
  // Limit history size
  if (history.length > 50) {
    history = history.slice(0, 50);
  }
  
  localStorage.setItem("musicHistory", JSON.stringify(history));
}

// Share song (simulated functionality)
function shareSong(song) {
  // In a real app, this would integrate with the Web Share API
  // or create a shareable link
  
  // For now, we'll simulate by showing a toast
  showToast(`Share link for "${song.trackName}" copied to clipboard!`, 'success');
  
  // Copy a simulated link to clipboard
  const shareText = `Check out "${song.trackName}" by ${song.artistName} on MusicHub!`;
  
  try {
    navigator.clipboard.writeText(shareText);
  } catch (err) {
    console.error('Failed to copy to clipboard:', err);
  }
}

// === TOAST NOTIFICATIONS ===
function showToast(message, type = 'info') {
  const toastContainer = document.getElementById('toast-container');
  const toast = document.createElement('div');
  toast.className = `toast ${type}`;
  
  let icon = 'info-circle';
  if (type === 'success') icon = 'check-circle';
  if (type === 'error') icon = 'exclamation-circle';
  
  toast.innerHTML = `
    <i class="fas fa-${icon}"></i>
    <span>${message}</span>
  `;
  
  toastContainer.appendChild(toast);
  
  // Remove toast after 3 seconds
  setTimeout(() => {
    toast.style.opacity = '0';
    setTimeout(() => {
      toast.remove();
    }, 300);
  }, 3000);
}

// Populate genre cards
function loadGenreCards() {
  const genres = [
    { name: "Pop", icon: "music", color: "#f94144" },
    { name: "Rock", icon: "guitar", color: "#f3722c" },
    { name: "Hip Hop", icon: "headphones", color: "#f8961e" },
    { name: "Electronic", icon: "sliders-h", color: "#f9c74f" },
    { name: "Jazz", icon: "saxophone", color: "#90be6d" },
    { name: "Classical", icon: "scroll", color: "#43aa8b" },
    { name: "R&B", icon: "record-vinyl", color: "#577590" },
    { name: "Country", icon: "hat-cowboy", color: "#0a9396" }
  ];
  
  genresContainer.innerHTML = "";
  
  genres.forEach(genre => {
    const genreCard = document.createElement("div");
    genreCard.classList.add("song"); // Reuse song card styling
    
    genreCard.innerHTML = `
      <div class="song-image" style="background-color: ${genre.color}; display: flex; align-items: center; justify-content: center;">
        <i class="fas fa-${genre.icon}" style="font-size: 64px; color: white;"></i>
      </div>
      <div class="song-info">
        <h3 class="song-title">${genre.name}</h3>
        <p class="song-artist">Explore genre</p>
      </div>
    `;
    
    genresContainer.appendChild(genreCard);
    
    // Add click event
    genreCard.addEventListener('click', () => {
      // Switch to home section
      navLinks.forEach(link => {
        if (link.dataset.section === "home") {
          link.click();
        }
      });
      
      // Search for this genre
      fetchMusic(genre.name, musicContainer);
      
      // Update search input
      searchInput.value = genre.name;
    });
  });
}

// === EVENT LISTENERS ===
// Search functionality
searchInput.addEventListener("keypress", (event) => {
  if (event.key === "Enter") {
    fetchMusic(searchInput.value, musicContainer);
    
    // Close mobile search if open
    searchContainer.classList.remove("active");
  }
});

// Player control listeners
playPauseBtn.addEventListener('click', togglePlayPause);
prevBtn.addEventListener('click', playPrevious);
nextBtn.addEventListener('click', playNext);
shuffleBtn.addEventListener('click', toggleShuffle);
repeatBtn.addEventListener('click', toggleRepeat);
muteBtn.addEventListener('click', toggleMute);

// Progress bar listener
playerProgressBar.addEventListener('click', setProgress);

// Volume slider listener
volumeSlider.addEventListener('click', setVolume);

// Audio player event listeners
audioPlayer.addEventListener('timeupdate', updateProgress);
audioPlayer.addEventListener('ended', () => {
  if (playerState.isRepeat) {
    // Repeat the same song
    audioPlayer.currentTime = 0;
    audioPlayer.play();
  } else {
    // Play next song
    playNext();
  }
});

audioPlayer.addEventListener('loadedmetadata', () => {
  // Set initial duration display
  durationEl.textContent = formatTime(audioPlayer.duration);
});

// Playlist section button listeners
document.getElementById("clear-playlist").addEventListener('click', clearPlaylist);
document.getElementById("sort-playlist").addEventListener('click', sortPlaylist);

// Discover section filter
document.getElementById("discover-filter").addEventListener('change', (e) => {
  fetchMusic(e.target.value === 'all' ? 'latest' : e.target.value, musicContainer);
});

// Refresh discover button
document.getElementById("refresh-discover").addEventListener('click', () => {
  const filter = document.getElementById("discover-filter").value;
  fetchMusic(filter === 'all' ? 'latest' : filter, musicContainer);
});

// Trending period selector
document.getElementById("trending-period").addEventListener('change', (e) => {
  let query = 'top 100';
  switch (e.target.value) {
    case 'day':
      query = 'today hits';
      break;
    case 'week':
      query = 'top 100';
      break;
    case 'month':
      query = 'month hits';
      break;
  }
  fetchMusic(query, trendingContainer);
});

// Refresh trending button
document.getElementById("refresh-trending").addEventListener('click', () => {
  const period = document.getElementById("trending-period").value;
  let query = 'top 100';
  switch (period) {
    case 'day':
      query = 'today hits';
      break;
    case 'week':
      query = 'top 100';
      break;
    case 'month':
      query = 'month hits';
      break;
  }
  fetchMusic(query, trendingContainer);
});

// === KEYBOARD SHORTCUTS ===
document.addEventListener('keydown', (e) => {
  // Ignore if in input field
  if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') return;
  
  switch (e.key) {
    case ' ': // Space bar - play/pause
      e.preventDefault();
      togglePlayPause();
      break;
    case 'ArrowRight': // Right arrow - next song
      if (e.ctrlKey || e.metaKey) playNext();
      break;
    case 'ArrowLeft': // Left arrow - previous song
      if (e.ctrlKey || e.metaKey) playPrevious();
      break;
    case 'm': // M - mute/unmute
      toggleMute();
      break;
  }
});

// === INITIALIZATION ===
// Set initial volume from saved preference
const savedVolume = parseFloat(localStorage.getItem('volume'));
if (!isNaN(savedVolume)) {
  audioPlayer.volume = savedVolume;
  volumeProgress.style.width = `${savedVolume * 100}%`;
  updateVolumeIcon(savedVolume);
}

// Load initial data
window.addEventListener('DOMContentLoaded', () => {
  // Load different sections
  fetchMusic('latest', musicContainer);
  fetchMusic('top 100', trendingContainer);
  loadPlaylist();
  loadGenreCards();
  
  // Load player state
  playerState.playlist = JSON.parse(localStorage.getItem("playlist")) || [];
});