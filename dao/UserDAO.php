<?php

require_once("models/user.php");
require_once("models/message.php");

class UserDAO implements userDAOInterface {

    private $conn;
    private $url;
    private $message;

    public function __construct(PDO $conn, $url) {
        $this->conn    = $conn;
        $this->url     = $url;
        $this->message = new Message($url);
    }

    public function buildUser($data) {

        $user = new User();

        $user->id         = $data['id'];
        $user->name       = $data['name'];
        $user->lastname   = $data['lastname'];
        $user->email      = $data['email'];
        $user->password   = $data['password'];
        $user->image      = $data['image'];
        $user->bio        = $data['bio'];
        $user->token      = $data['token'];

        return $user;

    }

    public function create(User $user, $authUser = false) {

        $criteria = $this->conn->prepare(
            "INSERT INTO users(
                name, 
                lastname, 
                email, 
                password, 
                token) VALUES (
                    :name, :lastname, :email, :password, :token
                )"
            );

        $criteria->bindParam(":name", $user->name); 
        $criteria->bindParam(":lastname", $user->lastname); 
        $criteria->bindParam(":email", $user->email); 
        $criteria->bindParam(":password", $user->password); 
        $criteria->bindParam(":token", $user->token); 

        $criteria->execute();

        //Autenticar usuário
        if($authUser){
            $this->setTokenToSession($user->token);
        }
    }

    public function update(User $user, $redirect = true) {
        $criteria = $this->conn->prepare("UPDATE users SET
        name = :name,
        lastname = :lastname,
        email = :email,
        image = :image,
        bio = :bio,
        token = :token
        WHERE id = :id
      ");

        $criteria->bindParam(":name", $user->name);
        $criteria->bindParam(":lastname", $user->lastname);
        $criteria->bindParam(":email", $user->email);
        $criteria->bindParam(":image", $user->image);
        $criteria->bindParam(":bio", $user->bio);
        $criteria->bindParam(":token", $user->token);
        $criteria->bindParam(":id", $user->id);

        $criteria->execute();

        if($redirect){
            //Redireciona para o perfil do usuário
            $this->message->setMessage("Dados atualizados!", "success", "editprofile.php");
        }
    }

    public function verifyToken($protected = false) {
        if(!empty($_SESSION["token"])){
            //Pegar token da sessão
            $token = $_SESSION["token"];
            $user  = $this->findByToken($token);

            if($user){
                return $user;
            } else if($protected){
                //Redireciona usuario sem token
                $this->message->setMessage("Faça a autenticação para ter acesso!", "error", "index.php");
            }
        }else if($protected){
            //Redireciona usuario sem token
            $this->message->setMessage("Faça a autenticação para ter acesso!", "error", "index.php");
        }
    }

    public function destroyToken()
    {
        //Remove token da sessão
        $_SESSION["token"] = "";

        //Redireciona após deslogar
        $this->message->setMessage("Você saiu!", "success","index.php");
    }

    public function setTokenToSession($token, $redirect = true) {

        //Salvar token na sessão
        $_SESSION["token"] = $token;

        if($redirect){
            //Redireciona para o perfil do usuario
            $this->message->setMessage("Seja bem-vindo(a)!", "success", "editprofile.php");
        }
    }

    public function authenticateUser($email, $password) {

        $user = $this->findByEmail($email);

        if($user){
            //Checar as senhas

            if(password_verify($password, $user->password)){
                //Gerar token e inserir na sessão

                $token = $user->generateToken();
                $this->setTokenToSession($token, false);

                //Atualizar token no usuário
                $user->token = $token;
                $this->update($user, false);

                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function findByEmail($email) {

        if($email != ""){

            $criteria = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
            $criteria->bindParam(":email", $email);
            $criteria->execute();

            if($criteria->rowCount() > 0){
                $data = $criteria->fetch();
                $user = $this->buildUser($data);

                return $user;
            }else{
                return false;
            }

        }else{
            return false;
        }
    }

    public function findById($id) {

    }

    public function findByToken($token) {

        if($token != ""){

            $criteria = $this->conn->prepare("SELECT * FROM users WHERE token = :token");
            $criteria->bindParam(":token", $token);
            $criteria->execute();

            if($criteria->rowCount() > 0){
                $data = $criteria->fetch();
                $user = $this->buildUser($data);

                return $user;
            }else{
                return false;
            }

        }else{
            return false;
        }
    }

    public function changePassword(User $user) {

        $criteria = $this->conn->prepare("UPDATE users SET password = :password WHERE id = :id");

        $criteria->bindParam(":password", $user->password);
        $criteria->bindParam(":id", $user->id);
        $criteria->execute();

        //Redireciona para o perfil do usuario
        $this->message->setMessage("Senha alterada com sucesso!", "success", "editprofile.php");
    }
}