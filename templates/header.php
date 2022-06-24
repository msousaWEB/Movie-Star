<?php
    require_once("globals.php");
    require_once("db.php");
    require_once("models/message.php");
    require_once("controllers/userController.php");

    $message = new Message($BASE_URL);

    $flassMessage = $message->getMessage();

    if(!empty($flassMessage["msg"])){
        //Limpar mensagem
        $message->clearMessage();
    }

    $userDao = new UserDAO($conn, $BASE_URL);
    $userData = $userDao->verifyToken(false);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MovieStar</title>
    <link rel="short icon" href="<?=$BASE_URL?>img/moviestar.ico">
    <!--Bootstrap--> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/css/bootstrap.css" integrity="sha512-Ty5JVU2Gi9x9IdqyHN0ykhPakXQuXgGY5ZzmhgZJapf3CpmQgbuhGxmI4tsc8YaXM+kibfrZ+CNX4fur14XNRg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--FontAwesome--> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--CSS-->
    <link rel="stylesheet" href="<?=$BASE_URL?>css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <nav id="main-navbar" class="navbar navbar-expand-lg">
            <a href="<?=$BASE_URL?>" class="navbar-brand">
                <img src="<?=$BASE_URL?>img/logo.svg" alt="MovieStar" id="logo">
                <span id="moviestar-title">MovieStar</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>
            <form action="" method="GET" id="search-form" class="form-inline my-2 my-lg-0">
                <input type="text" name="q" id="search" class="form-control mb-2" type="search" placeholder="Buscar Filmes" aria-label="Search">
                <button class="btn my-2 my-sm-0" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav">
                    <?php if ($userData): ?>  

                    <li class="nav-item">
                        <a href="<?=$BASE_URL?>new_movie.php" class="nav-link">
                            <i class="far fa-plus-square"></i> Adicionar
                        </a>
                    </li>      
                    <li class="nav-item">
                        <a href="<?=$BASE_URL?>dashboard.php" class="nav-link">Meus Filmes</a>
                    </li>      
                    <li class="nav-item">
                        <a href="<?=$BASE_URL?>edit_profile.php" class="nav-link bold">
                            <?= $userData->name?>
                        </a>
                    </li>      
                    <li class="nav-item">
                        <a href="<?=$BASE_URL?>logout.php" class="nav-link">Sair</a>
                    </li>    

                    <?php else: ?>  
                    <li class="nav-item">
                        <a href="<?=$BASE_URL?>auth.php" class="btn card-btn">Entrar</a>
                    </li>    
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </header>

    <?php if(!empty($flassMessage['msg'])):?>
        <div class="msg-container">
            <p class="msg <?=$flassMessage["type"]?>"><?=$flassMessage["msg"]?></p>  
        </div>
    <?php endif;?> 
    