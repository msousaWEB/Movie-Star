<?php
 require_once("models/user.php");
 require_once("dao/UserDAO.php");
 require_once("globals.php");
 require_once("db.php");
 require_once("models/message.php");

 $message = new Message($BASE_URL);
 $userDAO = new UserDAO($conn, $BASE_URL);

 //Resgata o tipo do FORM
 $type = filter_input(INPUT_POST, "type");

 //Atualizar nome
 if($type === "update") {

    //Resgata dados do usuário
    $userData = $userDAO->verifyToken();

    //Receber dados do POST
    $name       = filter_input(INPUT_POST, "name");
    $lastname   = filter_input(INPUT_POST, "lastname");
    $email      = filter_input(INPUT_POST, "email");

    //Criar novo objeto de usuário
    $user = new User();

    //Preencher os dados do usuário
    $userData->name     = $name;
    $userData->lastname = $lastname;
    $userData->email    = $email;

    $userDAO->update($userData);

    //Alterar senha do usuário
 } elseif ($type === "update_profile") {
    //Resgata dados do usuário
    $userData = $userDAO->verifyToken();
    $bio        = filter_input(INPUT_POST, "bio");

    //Criar novo objeto de usuário
    $user = new User();

    //Upload de imagem
    if(isset($_FILES["image"]) && !empty($_FILES["image"]["tmp_name"])) {
      
        $image = $_FILES["image"];
        $imageTypes = ["image/jpeg", "image/jpg", "image/png"];
        $jpgArray = ["image/jpeg", "image/jpg"];
  
        // Checagem de tipo de imagem
        if(in_array($image["type"], $imageTypes)) {
  
          // Checar jpg
          if(in_array($image, $jpgArray)) {
  
            $imageFile = imagecreatefromjpeg($image["tmp_name"]);
  
          // Imagem png
          } else {
  
            $imageFile = imagecreatefrompng($image["tmp_name"]);
  
          }
  
          $imageName = $user->imageGenerateName();
          imagejpeg($imageFile, "./img/users/" . $imageName, 100);
          $userData->image = $imageName;
  
        } else {
  
          $message->setMessage("Imagem inválida!", "error", "back");
  
        }
  
      }
    
    //Preencher os dados da bio e foto do usuário
    $userData->bio      = $bio;
    $userDAO->update($userData);
  
   
  //Alterar a senha do Usuário
 } elseif ($type === "change_password") {

  //Receber os dados do post
  $password         = filter_input(INPUT_POST,"password");
  $confirmPassword  = filter_input(INPUT_POST, "confirm_password");
  //Resgata dados do usuário
  $userData = $userDAO->verifyToken();
  $id = $userData->id;

  if($password == $confirmPassword){
    // Cria um novo objeto do usuário
    $user = new User();
    $finalPassword = $user->generatePassword($password);

    $user->password = $finalPassword;
    $user->id       = $id;

    $userDAO->changePassword($user);

  } else {
    $message->setMessage("As senhas não conferem!", "error", "editprofile.php");
  }


} else {
    $message->setMessage("Informações invalidas!", "error", "editprofile.php");
 }