<?php

require_once("models/movie.php");
require_once("models/message.php");

//Review DAO
require_once("dao/reviewDAO.php");
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

        //Ratings do filme
        $reviewDao = new ReviewDAO($this->conn, $this->url);

        $rating = $reviewDao->getRatings($movie->id);
        $movie->rating = $rating;

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
        $movie = [];

        $criteria = $this->conn->prepare("SELECT * FROM movies WHERE id = :id");
        $criteria->bindParam(":id", $id);
        $criteria->execute();

        if($criteria->rowCount() > 0) {

            $movieData = $criteria->fetch();
            $movie = $this->buildMovie($movieData);

            return $movie;

        } else {
            return false;
        }
    }

    public function findByTitle($title) {
        $movies = [];

        $criteria = $this->conn->prepare("SELECT * FROM movies WHERE title LIKE :title");
        $criteria->bindValue(":title", '%'.$title.'%');
        $criteria->execute();

        if($criteria->rowCount() > 0) {

            $moviesArray = $criteria->fetchAll();

            foreach($moviesArray as $movie){
                $movies[] = $this->buildMovie($movie);
            }
        }
        return $movies;
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

        $criteria = $this->conn->prepare("UPDATE movies SET
        title = :title,
        description = :description,
        image = :image,
        category = :category,
        trailer = :trailer,
        length = :length
        WHERE id = :id
        ");

        $criteria->bindParam(":title", $movie->title);
        $criteria->bindParam(":description", $movie->description);
        $criteria->bindParam(":image", $movie->image);
        $criteria->bindParam(":trailer", $movie->trailer);
        $criteria->bindParam(":category", $movie->category);
        $criteria->bindParam(":length", $movie->length);
        $criteria->bindParam(":id", $movie->id);

        $criteria->execute();
        //Filme Adicionado
        $this->message->setMessage("Seu filme foi atualizado com sucesso!", "success", "dashboard.php");
    }

    public function destroy($id) {
        $criteria = $this->conn->prepare("DELETE FROM movies WHERE id = :id");

        $criteria->bindParam(":id", $id);
        $criteria->execute();

        //Remover filme 
        $this->message->setMessage("Seu filme foi removido com sucesso!", "success", "dashboard.php");
    }

}
