<?php
$title = '02- Construct';
$description = 'Special method that initializes a new object upon creation';

include_once 'template/header.php';
echo "<section>";

class PlayList {
    public $name;
    public $artist = array();
    public $genre  = array();
    public $image  = array();
    public $year   = array();

    public function __construct($name) {
        $this->name = $name;
    }
    public function setPlayList($artist, $genre, $image, $year) {

        $this->artist[] = $artist;
        $this->genre[]  = $genre;
        $this->image[]  = $image;
        $this->year[]   = $year;
    }

   public function getPlayList() {
            echo "<h3> PlayList: $this->name </h3>";
            echo "<div style='display: flex; gap: 2rem; flex-direction: column'>";
                    for($i = 0; $i < count($this->artist); $i++) {
                        echo "<div style='display: flex; gap: 1rem'>";
                            echo "<img src='".$this->image[$i]."' width='120px'>";
                            echo "<div>";
                                echo "<h4> Artist: ".$this->artist[$i]."</h4>";
                                echo "<h5> Genre: ".$this->genre[$i]."</h5>";
                                echo "<h5> Year: ".$this->year[$i]."</h5>";
                            echo "</div>";
                        echo "</div>";
                    }
             echo   "</div>";
        }
    }
$pl = new PlayList('Merry Christmas');
$pl->setPlayList('Mariah Carey',  'Pop-Holiday', 'https://shorturl.at/fUokM', '1994');
$pl->setPlayList('James Pierpont', 'Pop', 'https://shorturl.at/43Tbh', '1857');
$pl->setPlayList('José Feliciano', 'Pop', 'https://shorturl.at/VggeE', '1970');
$pl->setPlayList('Ariana Grande', 'Pop', 'https://shorturl.at/QWh54', '2014');
$pl->setPlayList('Hugo Blanco ', 'Villancico', 'https://shorturl.at/RNIga', '1972');
$pl->getPlayList();



include_once 'template/footer.php';
