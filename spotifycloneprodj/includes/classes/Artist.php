<?php
class Artist
{
    private $con;
    private $id;

    public function __construct($con, $id) {
        $this->con = $con;
        $this->id = $id;
    }

    public function getName() {
        $artistQuery = mysqli_query($this->con, "SELECT name FROM artists WHERE id='$this->id'");
        if (!$artistQuery) {
            die("Query failed: " . mysqli_error($this->con)); // Error handling
        }

        $artist = mysqli_fetch_array($artistQuery);
        return $artist['name'] ?? null; // Safeguard in case 'name' is not found
    }
}
?>

