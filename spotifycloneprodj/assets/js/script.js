var currentPlaylist = [];
var audioElement;
var mouseDown = false;

function formatTime(seconds) {
  var time = Math.round(seconds);
  var minutes = Math.floor(time / 60);
  var seconds = time - minutes * 60;

  if (seconds < 10) {
    extraZero = "0";
  } else {
    extraZero = "";
  }
  return minutes + ":" + extraZero + (seconds < 10 ? "0" : "") + seconds;
}

function updateTimeProgressBar(audio) {
  $(".progressTime.current").text(formatTime(audio.currentTime));
  $(".progressTime.remaining").text(
    formatTime(audio.duration - audio.currentTime)
  );

  var progress = (audio.currentTime / audio.duration) * 100;
  $(".playbackBar .progress").css("width", progress + "%");
}

function Audio() {
  this.currentlyPlaying = null;
  this.audio = document.createElement("audio");

  // Event listeners
  this.audio.addEventListener("canplay", () => {
    const duration = formatTime(this.audio.duration);
    console.log("Audio duration loaded:", this.audio.duration); // Debug log
    $(".progressTime.remaining").text(duration);
  });

  this.audio.addEventListener("timeupdate", function () {
    if (this.duration) {
      updateTimeProgressBar(this);
    }
  });

  this.audio.addEventListener("play", () => console.log("Playback started."));
  this.audio.addEventListener("pause", () => console.log("Playback paused."));
  this.audio.addEventListener("timeupdate", () => {
    const currentTime = formatTime(this.audio.currentTime);
    const duration = formatTime(this.audio.duration || 0);
    $(".progressTime.current").text(currentTime);
    $(".progressTime.remaining").text(duration); // Sync remaining time
  });

  this.audio.addEventListener("ended", () => console.log("Playback ended."));
  this.audio.addEventListener("error", (e) =>
    console.error("Audio loading error:", e)
  );

  // Set the track for playback
  this.setTrack = function (track) {
    if (!track || !track.path) {
      console.error("Invalid track data:", track);
      return;
    }
    this.currentlyPlaying = track;
    this.audio.src = track.path;
    console.log("Track set to:", track.path);
  };

  this.play = function () {
    this.audio
      .play()
      .then(() => console.log("Playback started successfully."))
      .catch((error) => {
        console.error("Playback error:", error);
        alert("Playback failed. Please check your audio settings.");
      });
  };

  this.pause = function () {
    this.audio.pause();
  };

  this.setVolume = function (volume) {
    this.audio.volume = Math.min(Math.max(volume, 0.0), 1.0);
    console.log("Volume set to:", this.audio.volume);
  };

  this.getCurrentTime = function () {
    return this.audio.currentTime;
  };

  this.getDuration = function () {
    return this.audio.duration || 0;
  };

  this.setCurrentTime = function (time) {
    if (time >= 0 && time <= this.getDuration()) {
      this.audio.currentTime = time;
      console.log("Current time set to:", time);
    } else {
      console.error("Invalid time value:", time);
    }
  };
}
