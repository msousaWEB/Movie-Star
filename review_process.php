<?php

  require_once("globals.php");
  require_once("db.php");
  require_once("models/movie.php");
  require_once("models/review.php");
  require_once("models/message.php");
  require_once("dao/userDAO.php");
  require_once("dao/movieDAO.php");
  require_once("dao/reviewDAO.php");

  $message = new Message($app);
  $userDao = new UserDAO($conn, $app);
  $movieDao = new MovieDAO($conn, $app);
  $reviewDao = new ReviewDAO($conn, $app);

  // Recebendo o tipo do formulário
  $type = filter_input(INPUT_POST, "type");

  // Resgata dados do usuário
  $userData = $userDao->verifyToken();

  if($type === "create") {

    // Recebendo dados do post
    $rating = filter_input(INPUT_POST, "rating");
    $review = filter_input(INPUT_POST, "review");
    $movies_id = filter_input(INPUT_POST, "movies_id");
    $users_id = $userData->id;

    $reviewObject = new Review();

    $movieData = $movieDao->findById($movies_id);

    // Validando se o filme existe
    if($movieData) {

      // Verificar dados mínimos
      if(!empty($rating) && !empty($review) && !empty($movies_id)) {

        $reviewObject->rating = $rating;
        $reviewObject->review = $review;
        $reviewObject->movies_id = $movies_id;
        $reviewObject->users_id = $users_id;

        $reviewDao->create($reviewObject);

      } else {

        $message->setMessage("Você precisa inserir a nota e o comentário!", "error", "back");

      }

    } else {

      $message->setMessage("Informações inválidas!", "error", "index.php");

    }

  } else {

    $message->setMessage("Informações inválidas!", "error", "index.php");

  }