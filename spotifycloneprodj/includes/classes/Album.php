<?php
class Album
{
    private $con;
    private $id;
    private $title;
    private $artistId;
    private $genre;
    private $artworkPath;

    public function __construct($con, $id)
    {
        $this->con = $con;
        $this->id = $id;

        $query = mysqli_query($this->con, "SELECT * FROM albums WHERE id='$this->id'");
        $album = mysqli_fetch_array($query);

        $this->title = $album['title'];
        $this->artistId = $album['artist']; // Assuming 'artist' is the correct column name
        $this->genre = $album['genre'];
        $this->artworkPath = $album['artworkPath'];
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getArtist()
    {
        return new Artist($this->con, $this->artistId);
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function getArtworkPath()
    {
        return $this->artworkPath;
    }

    public function getNumberOfSongs()
    {
        $query = mysqli_query($this->con, "SELECT id FROM songs WHERE album='$this->id'");
        return mysqli_num_rows($query);
    }

    public function getSongIds()
    {
        $array = []; // Initialize $array as an empty array
        $query = mysqli_query($this->con, "SELECT id FROM songs WHERE album='$this->id' ORDER BY albumorder ASC");

        while ($row = mysqli_fetch_array($query)) {
            array_push($array, $row['id']);
        }

        return $array;
    }
}
