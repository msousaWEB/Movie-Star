<?php
require_once("models/review.php");
require_once("models/message.php");
require_once("dao/userDAO.php");

class ReviewDAO implements ReviewDAOInterface {
    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url) {
        $this->conn = $conn;
        $this->url = $url;
        $this->message = new Message($url);
    }

    public function buildReview($data) {
        $reviewObject = new Review();

        $reviewObject->id = $data["id"];
        $reviewObject->rating = $data["rating"];
        $reviewObject->review = $data["review"];
        $reviewObject->users_id = $data["users_id"];
        $reviewObject->movies_id = $data["movies_id"];

        return $reviewObject;
    }
    public function create(Review $review) {
        $criteria = $this->conn->prepare("INSERT INTO reviews (
            rating, review, movies_id, users_id
          ) VALUES (
            :rating, :review, :movies_id, :users_id
          )");

        $criteria->bindParam(":rating", $review->rating);
        $criteria->bindParam(":review", $review->review);
        $criteria->bindParam(":movies_id", $review->movies_id);
        $criteria->bindParam(":users_id", $review->users_id);

        $criteria->execute();

        //Filme Adicionado
        $this->message->setMessage("Seu comentário foi adicionado!", "success", "back");
    }
    public function getMoviesReview($id) {
        $reviews = [];

        $criteria = $this->conn->prepare("SELECT * FROM reviews WHERE movies_id = :movies_id");

        $criteria->bindParam(":movies_id", $id);
        $criteria->execute();

        if($criteria->rowCount() > 0) {
            $reviewsData = $criteria->fetchAll();
            $userDao = new UserDAO($this->conn, $this->url);

            foreach($reviewsData as $review) {
                $reviewsObject = $this->buildReview($review);

                //Dados do usuário
                $user = $userDao->findById($reviewsObject->users_id);

                $reviewsObject->user = $user;

                $reviews[] = $reviewsObject;
            }
        }

        return $reviews;
    }
    public function hasAlreadyReviewed($id, $userID) {
        $criteria = $this->conn->prepare("SELECT * FROM reviews WHERE movies_id = :movies_id AND users_id = :users_id");

        $criteria->bindParam(":movies_id", $id);
        $criteria->bindParam(":users_id", $userID);

        $criteria->execute();

        if($criteria->rowCount() > 0){
            return true;
        } else {
            return false;
        }
    }
    public function getRatings($id) {

        $criteria = $this->conn->prepare("SELECT * FROM reviews WHERE movies_id = :movies_id");
  
        $criteria->bindParam(":movies_id", $id);
  
        $criteria->execute();
  
        if($criteria->rowCount() > 0) {
  
          $rating = 0;
  
          $reviews = $criteria->fetchAll();
  
          foreach($reviews as $review) {
            $rating += $review["rating"];
          }
  
          $rating = $rating / count($reviews);
  
        } else {
  
          $rating = "Não avaliado";
  
        }
  
        return $rating;
  
    }
}