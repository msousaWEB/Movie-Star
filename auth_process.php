<?php
 
 require_once("models/user.php");
 require_once("dao/UserDAO.php");
 require_once("globals.php");
 require_once("db.php");
 require_once("models/message.php");

 $message = new Message($BASE_URL);
 $userDAO = new UserDAO($conn, $BASE_URL);

 // Mostra o tipo de FORM

 $type = filter_input(INPUT_POST, "type");

 // Verifica o tipo de FORM
  if($type == "register") {

      $name             = filter_input(INPUT_POST, "name");
      $lastname         = filter_input(INPUT_POST, "lastname");
      $email            = filter_input(INPUT_POST, "email");
      $password         = filter_input(INPUT_POST, "password");
      $confirm_password = filter_input(INPUT_POST, "confirm_password");

      //Verificar dados mínimos
      if($name && $lastname && $email && $password) {
          //Verificar senhas
          if($password === $confirm_password){
                //Verificar Usuário já cadastrado
                if($userDAO->findByEmail($email) === false) {
                    $user = new User();

                    //Criação de token / senha
                    $userToken     = $user->generateToken();
                    $finalPassword = $user->generatePassword($password);

                    $user->name     = $name;
                    $user->lastname = $lastname;
                    $user->email    = $email;
                    $user->password = $finalPassword;
                    $user->token    = $userToken;

                    $authUser = true;

                    $userDAO->create($user, $authUser);

                } else {
                    //Usuário já cadastrado
                    $message->setMessage("Este e-mail já está cadastrado!", "error", "back");
                }
            }else {
            //MSG de senhas incorretos
            $message->setMessage("As senhas não são iguais!", "error", "back");
          }
        } else {
          //MSG de dados faltando
          $message->setMessage("Preencha todos os campos!", "error", "back");
        }

    }elseif($type == "login") {
        $email    = filter_input(INPUT_POST, "email");
        $password = filter_input(INPUT_POST, "password");

        //Tentativa de autenticação
        if($userDAO->authenticateUser($email, $password)) {

          $message->setMessage("", "", "editprofile.php");

        } else {
          //Redireciona caso houver falha
          $message->setMessage("Email ou senha incorretos!", "error", "back");
        }
    } else {
          $message->setMessage("Login inválido!", "error", "index.php");
    }