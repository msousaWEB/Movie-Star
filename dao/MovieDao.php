<?php

require_once("models/movie.php");
require_once("models/Message.php");

//Review DAO

//Movie DAO
class MovieDAO implements MovieDAOInterface {
    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url) {
        $this->conn     = $conn;
        $this->url      = $url;
        $this->message  = new Message($url);
        
    }


    public function buildMovie($data) {
        $movie = new Movie();

        $movie->id          = $data["id"];
        $movie->title       = $data["title"];
        $movie->description = $data["description"];
        $movie->image       = $data["image"];
        $movie->trailer     = $data["trailer"];
        $movie->category    = $data["category"];
        $movie->length      = $data["length"];
        $movie->users_id    = $data["users_id"];

        return $movie;

    }

    public function findAll() {

    }

    public function getLatestMovies() {
        $movies = [];

        $criteria = $this->conn->query("SELECT * FROM movies ORDER BY id DESC");
        $criteria->execute();

        if($criteria->rowCount() > 0) {

            $moviesArray = $criteria->fetchAll();

            foreach($moviesArray as $movie){
                $movies[] = $this->buildMovie($movie);
            }
        }
        return $movies;
    }

    public function getMoviesByCategory($category) {
        $movies = [];

        $criteria = $this->conn->prepare("SELECT * FROM movies WHERE category = :category ORDER BY id DESC");
        $criteria->bindParam(":category", $category);
        $criteria->execute();

        if($criteria->rowCount() > 0) {

            $moviesArray = $criteria->fetchAll();

            foreach($moviesArray as $movie){
                $movies[] = $this->buildMovie($movie);
            }
        }
        return $movies;

    }

    public function getMoviesByUserId($id) {
        $movies = [];

        $criteria = $this->conn->prepare("SELECT * FROM movies WHERE users_id = :users_id");
        $criteria->bindParam(":users_id", $id);
        $criteria->execute();

        if($criteria->rowCount() > 0) {

            $moviesArray = $criteria->fetchAll();

            foreach($moviesArray as $movie){
                $movies[] = $this->buildMovie($movie);
            }
        }
        return $movies;
    }

    public function findById($id) {

    }

    public function findByTitle($title) {

    }

    public function create(Movie $movie) {

        $criteria = $this->conn->prepare("INSERT INTO movies (
            title, description, image, trailer, category, length, users_id
            ) VALUES (
                :title, :description, :image, :trailer, :category, :length, :users_id
            )");

        $criteria->bindParam(":title", $movie->title);
        $criteria->bindParam(":description", $movie->description);
        $criteria->bindParam(":image", $movie->image);
        $criteria->bindParam(":trailer", $movie->trailer);
        $criteria->bindParam(":category", $movie->category);
        $criteria->bindParam(":length", $movie->length);
        $criteria->bindParam(":users_id", $movie->users_id);

        $criteria->execute();

        //Filme Adicionado
        $this->message->setMessage("Seu filme foi adicionado com sucesso!", "success", "index.php");

    }

    public function update(Movie $movie) {

    }

    public function destroy($id) {

    }

}
