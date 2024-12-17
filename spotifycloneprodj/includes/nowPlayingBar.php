<?php
$songQuery = mysqli_query($con, "SELECT * FROM songs ORDER BY RAND() LIMIT 10");

$resultArray = array();

while ($row = mysqli_fetch_array($songQuery)) {
    array_push($resultArray, $row['id']);
}

$jsonArray = json_encode($resultArray);
?>

<script>
    $(document).ready(function() {
        currentPlaylist = <?php echo $jsonArray; ?>;
        audioElement = new Audio();
        setTrack(currentPlaylist[0], currentPlaylist, false);


        
    });

    function setTrack(trackId, newPlaylist, play) {
        $.post("includes/handlers/ajax/getSongJson.php", {
                songId: trackId
            })
            .done(function(data) {
                const track = parseJson(data, "song");
                if (track) {
                    console.log("Track data loaded:", track); // Debug log
                    $(".trackName span").text(track.title);

                    fetchArtistData(track.artist);
                    fetchAlbumData(track.album);

                    audioElement.setTrack(track);
                    if (play) audioElement.play();
                } else {
                    console.error("Invalid track data:", data);
                }
            })
            .fail(function() {
                console.error("Failed to fetch song data.");
            });
    }


    function fetchArtistData(artistId) {
        $.post("includes/handlers/ajax/getArtistJson.php", {
                artistId: artistId
            })
            .done(function(data) {
                let artist = parseJson(data, "artist");
                if (artist) $(".artistName span").text(artist.name);
            })
            .fail(function() {
                console.error("Failed to fetch artist data.");
            });
    }

    function fetchAlbumData(albumId) {
        $.post("includes/handlers/ajax/getAlbumJson.php", {
                albumId: albumId
            })
            .done(function(data) {
                let album = parseJson(data, "album");
                if (album) $(".albumLink img").attr("src", album.artworkPath);
            })
            .fail(function() {
                console.error("Failed to fetch album data.");
            });
    }

    function parseJson(data, type) {
        try {
            const parsed = JSON.parse(data);
            if (!parsed || typeof parsed !== "object") throw new Error();
            return parsed;
        } catch {
            console.error(`Invalid ${type} data:`, data);
            return null;
        }
    }

    function playSong() {
        if (audioElement.audio.currentTime === 0) {
            $.post("includes/handlers/ajax/updatePlays.php", {
                    songId: currentPlaylist[0]
                })
                .done(function(response) {
                    const result = JSON.parse(response);
                    if (result.success) {
                        console.log(result.message);
                    } else {
                        console.error(result.error);
                    }
                })
                .fail(function() {
                    console.error("Failed to update play count.");
                });
        }

        $(".controlButton.play").hide();
        $(".controlButton.pause").show();
        audioElement.play();
    }



    function pauseSong() {
        $(".controlButton.play").show();
        $(".controlButton.pause").hide();
        audioElement.pause();
    }
</script>




<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">
        <!-- Left Section (Album Info) -->
        <div id="nowPlayingLeft">
            <div class="content">
                <span class="albumLink">
                    <img src="" class="albumArtwork" alt="Album Artwork">
                </span>
                <div class="trackInfo">
                    <span class="trackName">
                        <span></span>
                    </span>
                    <span class="artistName">
                        <span></span>
                    </span>
                </div>
            </div>
        </div>

        <!-- Center Section (Playback Controls) -->
        <div id="nowPlayingCenter">
            <div class="content playerControls">
                <div class="buttons">
                    <button class="controlButton shuffle" title="Shuffle button">
                        <img src="assets/images/icons/shuffle.png" alt="Shuffle">
                    </button>
                    <button class="controlButton previous" title="Previous button">
                        <img src="assets/images/icons/previous.png" alt="Previous">
                    </button>
                    <button class="controlButton play" title="Play button" onclick="playSong()">
                        <img src="assets/images/icons/play.png" alt="Play">
                    </button>
                    <button class="controlButton pause" title="Pause button" style="display: none;" onclick="pauseSong()">
                        <img src="assets/images/icons/pause.png" alt="Pause">
                    </button>
                    <button class="controlButton next" title="Next button">
                        <img src="assets/images/icons/next.png" alt="Next">
                    </button>
                    <button class="controlButton repeat" title="Repeat button">
                        <img src="assets/images/icons/repeat.png" alt="Repeat">
                    </button>
                </div>

                <!-- Playback Bar -->
                <div class="playbackControls">
                    <span class="progressTime current">0.00</span>
                    <div class="progressBar">
                        <div class="progressBarBg">
                            <div class="progress"></div>
                        </div>
                    </div>
                    <span class="progressTime remaining">0.00</span>
                </div>
            </div>
        </div>

        <!-- Right Section (Volume Control) -->
        <div id="nowPlayingRight">
            <div class="volumeBar">
                <button class="controlButton volume" title="Volume button">
                    <img src="assets/images/icons/volume.png" alt="Volume">
                </button>
                <div class="progressBar">
                    <div class="progressBarBg">
                        <div class="progress"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>