<?php
    require_once("models/user.php");
    require_once("dao/UserDAO.php");
    require_once("dao/MovieDAO.php");
    require_once("globals.php");
    require_once("db.php");
    require_once("models/message.php");
   
    $message = new Message($BASE_URL);
    $userDAO = new UserDAO($conn, $BASE_URL);
    $movieDao = new MovieDAO($conn, $BASE_URL);

    //Resgata o tipo do FORM
    $type = filter_input(INPUT_POST, "type");

    //Resgata dados do usuário
    $userData = $userDAO->verifyToken();

if ($type === "create"){

    //Receber os inputs
    $title       = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");
    $trailer     = filter_input(INPUT_POST, "trailer");
    $category    = filter_input(INPUT_POST, "category");
    $length      = filter_input(INPUT_POST, "length");

    $movie = new Movie();

    //Validações mínimas
    if(!empty($title) && !empty($description) && !empty($category) && !empty($length)){
        $movie->title       = $title;
        $movie->description = $description;
        $movie->trailer     = $trailer;
        $movie->category    = $category;
        $movie->length      = $length;
        $movie->users_id    = $userData->id;

        //UPLOAD DE POSTER
        if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])){
           
            $image = $_FILES["image"];
            $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
            $jpgArray = ["image/jpeg", "image/jpg"];

            //Checar tipo da imagem
            if(in_array($image["type"], $imageTypes)){
                
                //Checar JPG
                if(in_array($image["type"], $jpgArray)){
                    $imageFile = imagecreatefromjpeg($image["tmp_name"]);

                  // PNG  
                } else {
                    $imageFile = imagecreatefrompng($image["tmp_name"]);
                }

                //Gerar nome da imagem
                $imageName = $movie->imageGenerateName();

                imagejpeg($imageFile, "./img/movies/" . $imageName, 100);
                $movie->image = $imageName;

            } else {
                $message->setMessage("Tipo de imagem inválida!", "error", "back");
            }
        }

        $movieDao->create($movie);

    } else {
        $message->setMessage("Informações requeridas faltando!", "error", "back");
    }
} else {
     $message->setMessage("Informações invalidas!", "error", "index.php");
}