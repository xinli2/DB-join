<?php
// Xin Li
class DatabaseAdaptor {
    private $DB; // The instance variable used in every method
    // Connect to an existing data based named 'first'
    public function __construct() {
        $dataBase = 'mysql:dbname=imdb_small;charset=utf8;host=127.0.0.1';
        $user = 'root';
        $password = ''; // Use the empty string with our XAMPP install
        try {
            $this->DB = new PDO ( $dataBase, $user, $password );
            $this->DB->setAttribute ( PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION );
        } catch ( PDOException $e ) {
            echo ('Error establishing Connection');
            exit ();
        }
    } // . . . continued
    
    public function getAllMovies () {
        $stmt = $this->DB->prepare( "SELECT * FROM movies" );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllActors () {
        $stmt = $this->DB->prepare( "SELECT * FROM actors" );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRoles ($first_name, $last_name) {
        $stmt = $this->DB->prepare( "SELECT * FROM roles JOIN actors ON actors.id = actor_id JOIN movies ON movies.id = movie_id where first_name = \"$first_name\" and last_name = \"$last_name\"" );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getMoviesReleasedSince($year) {
        $stmt = $this->DB->prepare("SELECT * FROM movies where year >= " . $year);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
$theDBA = new DatabaseAdaptor();
$arr = $theDBA->getRoles('Kevin', 'Bacon');
foreach ($arr as $value) {
    echo "$value[role]: '$value[name]'\r";
}
?>