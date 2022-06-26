<?php
    require_once("templates/header.php");

    //Verifica se usuário está autenticado.
    require_once("models/user.php");
    require_once("dao/userDAO.php");
    require_once("dao/movieDAO.php");

    $user = new User();
    $userDao = new UserDAO($conn, $app);
    $movieDao = new MovieDAO($conn, $app);

    //Receber id do usuário
    $id = filter_input(INPUT_GET, "id");

    if(empty($id)){
        if($userData->id){
            $id = $userData->id;
        } else {
            $message->setMessage("Usuário não encontrado!", "error", "index.php");
        }
    } else {
        $userData = $userDao->findById($id);
        
        //Se não encontrar:
        if(!$userData){
            $message->setMessage("Usuário não encontrado!", "error", "index.php");
        }
    }

    $fullName = $user->getFullName($userData);

    if($userData->image == "") {
      $userData->image = "user.png";
    }

    //Filmes deste usuário
    $userMovies = $movieDao->getMoviesByUserId($id);

?>
<div id="main-container" class="container-fluid">
    <div class="col-md-8 offset-md-2">
        <div class="row profile-container">
            <div class="col-md-12 about-container">
                <h1 class="page-title"><?=$fullName?></h1>
                <div id="profile-image-container" class="profile-image" style="background-image: url('<?= $app ?>img/users/<?= $userData->image ?>')"></div>
                <h3 class="about-title">Bio:</h3>
                <?php if(!empty($userData->bio)):?>
                    <p class="profile-description"><?=$userData->bio?></p>
                <?php else: ?>
                    <p class="profile-description">Este usuário ainda não adicionou uma biografia.</p>
                <?php endif; ?>
            </div>
            <div class="col-md-12 added-movies-container">
                <h3>Filmes adicionados:</h3>
                <div class="movies-container">
                    <?php foreach($userMovies as $movie):?>
                        <?php require("templates/movie_card.php");?>
                    <?php endforeach;?>
                    <?php if(count($userMovies) === 0): ?>
                        <p class="empty-list">Nenhum filme adicionado.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    require_once("templates/footer.php");
?>