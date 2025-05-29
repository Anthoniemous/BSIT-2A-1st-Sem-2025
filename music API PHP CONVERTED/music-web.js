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
  volume: 1,
  queue: [], // Added for queuing songs
  history: [] // Track listening history
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
// Fetch Music from API with improved error handling and retry mechanism
async function fetchMusic(query = "pop", container, limit = 12) {
  try {
    showLoading(container);
    
    // Configure API request with retry mechanism
    const maxRetries = 3;
    let retries = 0;
    let success = false;
    let data;
    
    while (retries < maxRetries && !success) {
      try {
        const url = `https://itunes.apple.com/search?term=${encodeURIComponent(query)}&limit=${limit}&media=music`;
        const response = await fetch(url);
        
        if (!response.ok) {
          throw new Error(`API error: ${response.status}`);
        }
        
        data = await response.json();
        success = true;
      } catch (error) {
        retries += 1;
        if (retries >= maxRetries) {
          throw error;
        }
        // Wait before retry (exponential backoff)
        await new Promise(resolve => setTimeout(resolve, 1000 * retries));
      }
    }
    
    if (data.results && data.results.length > 0) {
      displayMusic(data.results, container);
      
      // Cache the results for faster reloading
      const cacheKey = `musicCache_${query}_${limit}`;
      localStorage.setItem(cacheKey, JSON.stringify({
        timestamp: Date.now(),
        data: data.results
      }));
    } else {
      showNoResults(container);
    }
  } catch (error) {
    console.error("Error fetching music:", error);
    
    // Try to load from cache if available
    const cacheKey = `musicCache_${query}_${limit}`;
    const cached = localStorage.getItem(cacheKey);
    
    if (cached) {
      try {
        const cachedData = JSON.parse(cached);
        // Use cache if less than 1 day old
        if (Date.now() - cachedData.timestamp < 86400000) {
          displayMusic(cachedData.data, container);
          showToast("Showing cached results", "info");
          return;
        }
      } catch (cacheError) {
        console.error("Cache error:", cacheError);
      }
    }
    
    showError(container, error.message);
  }
}

// Show loading state with improved animation
function showLoading(container) {
  container.innerHTML = `
    <div class="no-results">
      <i class="fas fa-spinner fa-spin"></i>
      <p>Loading songs...</p>
    </div>
  `;
}

// Show no results state with more helpful text
function showNoResults(container) {
  container.innerHTML = `
    <div class="no-results">
      <i class="fas fa-music"></i>
      <p>No songs found. Try a different search term or check your internet connection.</p>
      <button class="control-btn" onclick="window.location.reload()">
        <i class="fas fa-sync-alt"></i> Refresh
      </button>
    </div>
  `;
}

// Show error state with retry option
function showError(container, message) {
  container.innerHTML = `
    <div class="no-results">
      <i class="fas fa-exclamation-circle"></i>
      <p>Oops! Something went wrong.</p>
      <small>${message}</small>
      <button class="control-btn" style="margin-top: 15px;" onclick="window.location.reload()">
        <i class="fas fa-sync-alt"></i> Try Again
      </button>
    </div>
  `;
}

// Display Music in the UI with improved UI and accessibility
function displayMusic(songs, container) {
  container.innerHTML = "";
  
  // Filter out songs without preview URLs
  const validSongs = songs.filter(song => song.previewUrl);
  
  if (validSongs.length === 0) {
    showNoResults(container);
    return;
  }
  
  validSongs.forEach((song, index) => {
    const songDiv = document.createElement("div");
    songDiv.classList.add("song");
    songDiv.setAttribute("tabindex", "0"); // For keyboard navigation
    
    // Use higher resolution artwork if available
    const artworkUrl = song.artworkUrl100?.replace('100x100', '400x400') || song.artworkUrl100;
    
    songDiv.innerHTML = `
      <div class="song-image">
        <img src="${artworkUrl}" alt="${song.trackName || 'Unknown Song'}" loading="lazy">
        <div class="song-overlay">
          <button class="play-btn" aria-label="Play ${song.trackName || 'song'}">
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
            <button class="action-btn add-to-playlist" aria-label="Add to library">
              <i class="fas fa-plus"></i>
            </button>
            <button class="action-btn add-to-queue" aria-label="Add to queue">
              <i class="fas fa-list"></i>
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
    playBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      playSong(completeSong);
    });
    
    // Add entire song click event (not just the play button)
    songDiv.addEventListener('click', (e) => {
      // Don't trigger if clicking on action buttons
      if (!e.target.closest('.song-actions')) {
        playSong(completeSong);
      }
    });
    
    // Keyboard accessibility - play with Enter key
    songDiv.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        playSong(completeSong);
      }
    });
    
    // Add to playlist button click event
    const addToPlaylistBtn = songDiv.querySelector('.add-to-playlist');
    addToPlaylistBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      saveToPlaylist(completeSong);
    });

    // Add to queue button click event (NEW FEATURE)
    const addToQueueBtn = songDiv.querySelector('.add-to-queue');
    addToQueueBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      addToQueue(completeSong);
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
// Play selected song with improved error handling
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
    
    // Play audio with error handling
    audioPlayer.play().catch(err => {
      console.error('Error playing audio:', err);
      showToast('Error playing this song. Please try another.', 'error');
      
      // Try to recover
      setTimeout(() => {
        audioPlayer.play().catch(() => {
          showToast('Still having trouble playing audio. Please try a different song.', 'error');
        });
      }, 1000);
    });
    
    // Update UI
    playerState.isPlaying = true;
    playIcon.className = 'fas fa-pause';
    
    // Update song card UI if element exists
    if (song.element) {
      const playBtnIcon = song.element.querySelector('.play-btn i');
      if (playBtnIcon) playBtnIcon.className = 'fas fa-pause';
    }
    
    // Add to history
    addToHistory(song);
    
    // Update document title with song info
    document.title = `${song.trackName} - ${song.artistName} | MusicHub`;
    
    // Remove song from queue if it was in the queue
    playerState.queue = playerState.queue.filter(item => item.trackId !== song.trackId);
    updateQueueDisplay();
    
    // Add media session metadata for mobile and desktop media controls
    if ('mediaSession' in navigator) {
      navigator.mediaSession.metadata = new MediaMetadata({
        title: song.trackName || 'Unknown Song',
        artist: song.artistName || 'Unknown Artist',
        album: song.collectionName || '',
        artwork: [{ src: song.artworkUrl100, sizes: '100x100', type: 'image/jpeg' }]
      });
      
      navigator.mediaSession.setActionHandler('play', togglePlayPause);
      navigator.mediaSession.setActionHandler('pause', togglePlayPause);
      navigator.mediaSession.setActionHandler('previoustrack', playPrevious);
      navigator.mediaSession.setActionHandler('nexttrack', playNext);
    }
  } else {
    // Toggle play/pause for current song
    togglePlayPause();
  }
}

// Toggle Play/Pause with improved UI feedback
function togglePlayPause() {
  if (!playerState.currentSong) return;
  
  if (playerState.isPlaying) {
    audioPlayer.pause();
    playerState.isPlaying = false;
    playIcon.className = 'fas fa-play';
    if (playerState.currentSong.element) {
      const playBtnIcon = playerState.currentSong.element.querySelector('.play-btn i');
      if (playBtnIcon) playBtnIcon.className = 'fas fa-play';
    }
    
    // Update media session state
    if ('mediaSession' in navigator) {
      navigator.mediaSession.playbackState = 'paused';
    }
  } else {
    audioPlayer.play().catch(err => {
      console.error('Error resuming audio:', err);
      showToast('Error resuming playback', 'error');
    });
    playerState.isPlaying = true;
    playIcon.className = 'fas fa-pause';
    if (playerState.currentSong.element) {
      const playBtnIcon = playerState.currentSong.element.querySelector('.play-btn i');
      if (playBtnIcon) playBtnIcon.className = 'fas fa-pause';
    }
    
    // Update media session state
    if ('mediaSession' in navigator) {
      navigator.mediaSession.playbackState = 'playing';
    }
  }
}

// Format time (seconds to MM:SS) - Improved to handle edge cases
function formatTime(seconds) {
  if (isNaN(seconds) || !isFinite(seconds)) return '0:00';
  
  const minutes = Math.floor(seconds / 60);
  const remainingSeconds = Math.floor(seconds % 60);
  return `${minutes}:${remainingSeconds < 10 ? '0' : ''}${remainingSeconds}`;
}

// Update progress bar with improved performance
function updateProgress() {
  if (!audioPlayer.duration) return;
  
  // Use requestAnimationFrame for smoother updates
  requestAnimationFrame(() => {
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
  });
}

// Play next song with improved queue support
function playNext() {
  // First, check if there are songs in the queue
  if (playerState.queue.length > 0) {
    // Play the first song in the queue
    const nextSong = playerState.queue.shift();
    playSong(nextSong);
    showToast(`Playing next in queue: "${nextSong.trackName}"`, 'info');
    updateQueueDisplay();
    return;
  }
  
  // If no queue or empty queue, use the playlist
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

// Play previous song with history support
function playPrevious() {
  if (!playerState.playlist || playerState.playlist.length === 0) return;
  
  // If current time > 3 seconds, restart song instead of previous
  if (audioPlayer.currentTime > 3) {
    audioPlayer.currentTime = 0;
    return;
  }
  
  // Try to play from history first if available
  if (playerState.history.length > 1) {
    // Skip current song (at index 0) and get previous (index 1)
    const previousSong = playerState.history[1];
    
    // Remove current song from history as we're going back
    playerState.history.shift();
    
    // Find song in playlist to get correct index
    const songIndex = playerState.playlist.findIndex(
      song => song.trackId === previousSong.trackId
    );
    
    if (songIndex !== -1) {
      playerState.currentIndex = songIndex;
      // Don't call addToHistory here to avoid creating a loop
      playerState.currentSong = playerState.playlist[songIndex];
      
      // Set audio source
      audioPlayer.src = previousSong.previewUrl;
      audioPlayer.load();
      
      // Update player UI
      currentSongImg.src = previousSong.artworkUrl100?.replace('100x100', '400x400') || previousSong.artworkUrl100;
      currentSongTitle.textContent = previousSong.trackName || 'Unknown Song';
      currentSongArtist.textContent = previousSong.artistName || 'Unknown Artist';
      
      // Play audio
      audioPlayer.play().catch(err => {
        console.error('Error playing audio:', err);
        // Fall back to standard previous logic
        standardPreviousLogic();
      });
      
      playerState.isPlaying = true;
      playIcon.className = 'fas fa-pause';
      return;
    }
  }
  
  // Fall back to standard previous logic
  standardPreviousLogic();
  
  function standardPreviousLogic() {
    let prevIndex = playerState.currentIndex - 1;
    
    // Loop to end if at start
    if (prevIndex < 0) {
      prevIndex = playerState.playlist.length - 1;
    }
    
    playerState.currentIndex = prevIndex;
    playSong(playerState.playlist[prevIndex]);
  }
}

// Set progress when clicking on progress bar - with improved usability
function setProgress(e) {
  const width = this.clientWidth;
  const clickX = e.offsetX;
  const duration = audioPlayer.duration;
  
  if (isNaN(duration) || !isFinite(duration)) return;
  
  // Calculate the new time
  const newTime = (clickX / width) * duration;
  
  // Only update if it's a valid time
  if (isFinite(newTime) && newTime >= 0 && newTime <= duration) {
    audioPlayer.currentTime = newTime;
    
    // Update UI immediately for responsiveness
    const progressPercent = (newTime / duration) * 100;
    playerProgress.style.width = `${progressPercent}%`;
    currentTimeEl.textContent = formatTime(newTime);
  }
}

// Set volume when clicking on volume slider - with improved usability
function setVolume(e) {
  const width = this.clientWidth;
  const clickX = e.offsetX;
  const volume = Math.max(0, Math.min(1, clickX / width)); // Clamp between 0 and 1
  
  updateVolume(volume);
}

// Update volume function (extracted for reuse)
function updateVolume(volume) {
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

// Toggle mute with improved state tracking
function toggleMute() {
  if (audioPlayer.volume > 0) {
    // Store current volume before muting
    playerState.lastVolume = audioPlayer.volume;
    updateVolume(0);
  } else {
    // Restore previous volume or default to 0.5
    const volume = playerState.lastVolume || 0.5;
    updateVolume(volume);
  }
}

// Toggle shuffle mode with state persistence
function toggleShuffle() {
  playerState.isShuffle = !playerState.isShuffle;
  shuffleBtn.classList.toggle('active');
  
  // Save preference
  localStorage.setItem('shuffle', playerState.isShuffle ? 'true' : 'false');
  
  showToast(`Shuffle ${playerState.isShuffle ? 'enabled' : 'disabled'}`, 'info');
}

// Toggle repeat mode with state persistence
function toggleRepeat() {
  playerState.isRepeat = !playerState.isRepeat;
  repeatBtn.classList.toggle('active');
  
  // Save preference
  localStorage.setItem('repeat', playerState.isRepeat ? 'true' : 'false');
  
  showToast(`Repeat ${playerState.isRepeat ? 'enabled' : 'disabled'}`, 'info');
}

// === QUEUE MANAGEMENT (NEW FEATURE) ===
// Add song to playback queue
function addToQueue(song) {
  // Add song to queue
  playerState.queue.push({
    trackId: song.trackId,
    trackName: song.trackName,
    artistName: song.artistName,
    artworkUrl100: song.artworkUrl100,
    previewUrl: song.previewUrl
  });
  
  // Show toast
  showToast(`"${song.trackName}" added to queue`, 'success');
  
  // Update queue display if visible
  updateQueueDisplay();
}

// Update queue display if queue section exists
function updateQueueDisplay() {
  const queueContainer = document.getElementById('queue-container');
  if (!queueContainer) return;
  
  if (playerState.queue.length === 0) {
    queueContainer.innerHTML = `
      <div class="no-results">
        <i class="fas fa-list"></i>
        <p>Your queue is empty. Add songs to play next.</p>
      </div>
    `;
    return;
  }
  
  queueContainer.innerHTML = "";
  
  // Create queue items
  playerState.queue.forEach((song, index) => {
    const queueItem = document.createElement('div');
    queueItem.className = 'queue-item';
    queueItem.innerHTML = `
      <img src="${song.artworkUrl100}" alt="${song.trackName}" width="40" height="40">
      <div class="queue-item-info">
        <div class="queue-item-title">${song.trackName}</div>
        <div class="queue-item-artist">${song.artistName}</div>
      </div>
      <div class="queue-item-actions">
        <button class="action-btn remove-from-queue" data-index="${index}" aria-label="Remove from queue">
          <i class="fas fa-times"></i>
        </button>
      </div>
    `;
    
    queueContainer.appendChild(queueItem);
    
    // Add event listener to remove button
    const removeBtn = queueItem.querySelector('.remove-from-queue');
    removeBtn.addEventListener('click', () => {
      playerState.queue.splice(index, 1);
      updateQueueDisplay();
      showToast('Removed from queue', 'info');
    });
  });
}

// Clear entire queue
function clearQueue() {
  playerState.queue = [];
  updateQueueDisplay();
  showToast('Queue cleared', 'info');
}

// === PLAYLIST MANAGEMENT ===
// Save to playlist with deduplication and improved metadata
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
      collectionName: song.collectionName || '',
      primaryGenreName: song.primaryGenreName || '',
      date: new Date().toISOString()
    });
    
    localStorage.setItem("playlist", JSON.stringify(playlist));
    showToast(`"${song.trackName}" added to your library`, 'success');
    
    // Update player state
    playerState.playlist = playlist;
    
    // Refresh playlist view if currently visible
    if (!document.getElementById("playlists").classList.contains("hidden")) {
      loadPlaylist();
    }
  } else {
    showToast(`"${song.trackName}" is already in your library`, 'info');
  }
}

// Load and display playlist with enhanced UI
function loadPlaylist() {
  const playlist = JSON.parse(localStorage.getItem("playlist")) || [];
  
  if (playlist.length === 0) {
    playlistContainer.innerHTML = `
      <div class="no-results">
        <i class="fas fa-music"></i>
        <p>Your library is empty. Start adding songs you love!</p>
        <button class="control-btn" id="discover-button" style="margin-top: 15px;">
          <i class="fas fa-compass"></i> Discover Music
        </button>
      </div>
    `;
    
    // Add event listener to discover button
    const discoverButton = document.getElementById('discover-button');
    if (discoverButton) {
      discoverButton.addEventListener('click', () => {
        // Switch to discover section
        navLinks.forEach(link => {
          if (link.dataset.section === "home") {
            link.click();
          }
        });
      });
    }
    return;
  }
  
  // Store in player state
  playerState.playlist = playlist;
  
  // Display playlist
  playlistContainer.innerHTML = "";
  playlist.forEach((song, index) => {
    const songDiv = document.createElement("div");
    songDiv.classList.add("song");
    songDiv.setAttribute("tabindex", "0"); // For keyboard navigation
    
    // Use higher resolution artwork if available
    const artworkUrl = song.artworkUrl100?.replace('100x100', '400x400') || song.artworkUrl100;
    
        songDiv.innerHTML = `
          <div class="song-image">
            <img src="${artworkUrl}" alt="${song.trackName || 'Unknown Song'}" loading="lazy">
            <div class="song-overlay">
              <button class="play-btn" aria-label="Play ${song.trackName || 'song'}">
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
                <button class="action-btn remove-from-playlist" data-trackid="${song.trackId}" aria-label="Remove from library">
                  <i class="fas fa-trash"></i>
                </button>
                <button class="action-btn add-to-queue" aria-label="Add to queue">
                  <i class="fas fa-list"></i>
                </button>
                <button class="action-btn share-song" aria-label="Share song">
                  <i class="fas fa-share-alt"></i>
                </button>
              </div>
            </div>
          </div>
        `;
      });
    }
    
    


    // User Profile Management Functions
document.addEventListener('DOMContentLoaded', function() {
    // User profile dropdown toggle
    const userProfileToggle = document.getElementById('user-profile-toggle');
    const userDropdown = document.getElementById('user-dropdown');
    const logoutBtn = document.getElementById('logout-btn');
    
    // Function to load user data from localStorage
    function loadUserData() {
        // Check if we have user data in localStorage or sessionStorage
        let userData = null;
        
        try {
            // Try to get data from localStorage
            const localData = localStorage.getItem('currentUser');
            if (localData) {
                userData = JSON.parse(localData);
            }
            
            // If not in localStorage, check sessionStorage
            if (!userData) {
                const sessionData = sessionStorage.getItem('currentUser');
                if (sessionData) {
                    userData = JSON.parse(sessionData);
                }
            }
            
            // If still no user data, check if we can extract from the users array
            if (!userData) {
                // This is specific to your application's structure
                // Here we're assuming users data is stored in localStorage
                const usersData = localStorage.getItem('users');
                if (usersData) {
                    const users = JSON.parse(usersData);
                    // For demo purposes, just get the first user
                    if (users && users.length > 0) {
                        userData = users[0];
                    }
                }
            }
            
            return userData;
        } catch (error) {
            console.error('Error loading user data:', error);
            return null;
        }
    }
    
    // Function to display user data
    function displayUserData() {
        const userData = loadUserData();
        const userDisplayName = document.getElementById('user-display-name');
        const userFullName = document.getElementById('user-full-name');
        const userEmail = document.getElementById('user-email');
        
        if (userData) {
            // Set display name (short version for the navbar)
            if (userData.firstName) {
                userDisplayName.textContent = userData.firstName;
            } else if (userData.username) {
                userDisplayName.textContent = userData.username;
            }
            
            // Set full name in dropdown
            if (userData.firstName && userData.lastName) {
                userFullName.textContent = `${userData.firstName} ${userData.lastName}`;
            } else if (userData.username) {
                userFullName.textContent = userData.username;
            }
            
            // Set email
            if (userData.primaryEmail) {
                userEmail.textContent = userData.primaryEmail;
            } else if (userData.email) {
                userEmail.textContent = userData.email;
            } else if (userData.secondaryEmail) {
                userEmail.textContent = userData.secondaryEmail;
            }
        } else {
            // Default values if no user data found
            userDisplayName.textContent = 'Guest';
            userFullName.textContent = 'Guest User';
            userEmail.textContent = 'Not signed in';
        }
    }
    
    // Toggle dropdown visibility
    if (userProfileToggle) {
        userProfileToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('show');
        });
    }
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (userDropdown.classList.contains('show') && !userDropdown.contains(e.target)) {
            userDropdown.classList.remove('show');
        }
    });
    
    // Logout functionality
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Clear user session
            localStorage.removeItem('currentUser');
            sessionStorage.removeItem('currentUser');
            
            // Create a toast notification
            createToast('Logged out successfully', 'success');
            
            // Redirect to login page after a short delay
            setTimeout(() => {
                window.location.href = 'login.php'; // Change to your login page
            }, 1500);
        });
    }
    
    // Function to create toast notifications
    function createToast(message, type = 'info') {
        const toastContainer = document.getElementById('toast-container');
        if (!toastContainer) return;
        
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerHTML = `
            <div class="toast-content">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-info-circle'}"></i>
                <span>${message}</span>
            </div>
            <button class="toast-close"><i class="fas fa-times"></i></button>
        `;
        
        toastContainer.appendChild(toast);
        
        // Add event listener to close button
        const closeBtn = toast.querySelector('.toast-close');
        closeBtn.addEventListener('click', () => {
            toast.classList.add('hiding');
            setTimeout(() => {
                toast.remove();
            }, 300);
        });
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            toast.classList.add('hiding');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 5000);
        
        // Animate in
        setTimeout(() => {
            toast.classList.add('show');
        }, 10);
    }
    
    // Load user data when page loads
    displayUserData();
});