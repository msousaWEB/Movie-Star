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
} elseif ($type === "delete"){
    //Recebe os dados do form
    $id = filter_input(INPUT_POST, "id");
    $movie = $movieDao->findById($id);

    if($movie) {
        //Verificar se o filme é deste usuário
        if($movie->users_id === $userData->id) {
            $movieDao->destroy($movie->id);
        } else {
            $message->setMessage("Você não tem permissão para realizar esta ação!", "error", "dashboard.php");
        }
    } else {
        $message->setMessage("Você não tem permissão para realizar esta ação!", "error", "dashboard.php");
    }

} elseif ($type === "update"){
    //Receber os inputs
    $title       = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");
    $trailer     = filter_input(INPUT_POST, "trailer");
    $category    = filter_input(INPUT_POST, "category");
    $length      = filter_input(INPUT_POST, "length");
    $id          = filter_input(INPUT_POST, "id");

    $movieData = $movieDao->findById($id);

    //Verifica se encontrou o filme
    if($movieData) {
         //Verificar se o filme é deste usuário
         if($movieData->users_id === $userData->id) {
            if(!empty($title) && !empty($description) && !empty($category) && !empty($length)){
                $movieData->title       = $title;
                $movieData->description = $description;
                $movieData->trailer     = $trailer;
                $movieData->category    = $category;
                $movieData->length      = $length;

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
                        $movie = new Movie();
                        $imageName = $movie->imageGenerateName();

                        imagejpeg($imageFile, "./img/movies/" . $imageName, 100);
                        $movieData->image = $imageName;

                    } else {
                        $message->setMessage("Tipo de imagem inválida!", "error", "back");
                    }
                }

                $movieDao->update($movieData);
            } else {
                $message->setMessage("Os campos necessários estão vazios!", "error", "dashboard.php");
            }
        } else {
            $message->setMessage("Você não tem permissão para realizar esta ação!", "error", "dashboard.php");
        }
    } else {
        $message->setMessage("Você não tem permissão para realizar esta ação!", "error", "dashboard.php");
    }
} else {
     $message->setMessage("Informações invalidas!", "error", "index.php");
}