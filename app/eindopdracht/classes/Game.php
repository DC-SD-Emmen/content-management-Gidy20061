
<?php

class Game {
    private $id;
    private $title;
    private $genre;
    private $platform;
    private $release_year;
    private $rating;
    private $foto;

    public function __construct($row)
    {
        // Ervan uitgaande dat $row een associatieve array is met sleutels die overeenkomen met kolomnamen
        $this->id = $row['id'] ?? null;
        $this->title = $row['title'] ?? null;
        $this->genre = $row['genre'] ?? null;
        $this->platform = $row['platform'] ?? null;
        $this->release_year = $row['release_year'] ?? null;
        $this->rating = $row['rating'] ?? null;
        $this->foto = $row['foto'] ?? null;
    }

    public function set_id($id)
    {
        $this->id = $id;
    }

    function get_id()
    {
        return $this->id;
    }


    public function set_title($title)
    {
        $this->title = $title;
    }

    function get_title()
    {
        return $this->title;
    }


    public function set_genre($genre)
    {
        $this->genre = $genre;
    }

    function get_genre()
    {
        return $this->genre;
    }

    public function set_platforms($platform)
    {
        $this->platform = $platform;
    }

    function get_platform()
    {
        return $this->platform;
    }


    public function set_foto($foto)
    {
        $this->foto = $foto;
    }

    function get_foto()
    {
        return $this->foto;
    }


    public function set_release_year($release_year)
    {
        $this->release_year = $release_year;
    }

    function get_release_year()
    {
        return $this->release_year;
    }

    public function set_rating($rating)
    {
        $this->rating = $rating;
    }

    function get_rating()
    {
        return $this->rating;
    }
}

?>

