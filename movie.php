<?php
    require_once("templates/header.php");
    require_once("models/movie.php");
    require_once("dao/movieDAO.php");
    require_once("dao/reviewDAO.php");

    $reviewDao = new ReviewDAO($conn, $app);
    $movieDao = new MovieDAO($conn, $app);
    //pegar id do filme
    $id = filter_input(INPUT_GET, "id");
    $movie;

    if(empty($id)) {
        $message->setMessage("Filme não encontrado!", "error", "index.php");
    } else {
        $movie = $movieDao->findById($id);
        //Verificar id do filme
        if(!$movie) {
            $message->setMessage("Filme não encontrado!", "error", "index.php");
        }
    }
    //Checar imagem do filme
    if($movie->image == "") {
        $movie->image = "movie_cover.jpg";
    }
    //Checar se o filme é do usuário
    $userOwnsMovie = false;
    if(!empty($userData)) {
        if($userData->id === $movie->users_id) {
            $userOwnsMovie = true;
        }

        $alreadyReviewed = $reviewDao->hasAlreadyReviewed($id, $userData->id);
    }
    //Resgatar Reviews
    $movieReviews = $reviewDao->getMoviesReview($movie->id);

    
?>

<div id="main-container" class="container-fluid">
    <div class="row">
        <div class="offset-md-1 col-md-6 movie-container">
            <h1 class="page-title"><?= $movie->title ?></h1>
            <p class="movie-details">
                <span>Duração: <?= $movie->length ?></span>
                <span class="pipe"></span>
                <span><?= $movie->category ?></span>
                <span class="pipe"></span>
                <span><i class="fas fa-star"></i><?=$movie->rating?></span>
            </p>
            <iframe src="<?= $movie->trailer ?>" width="560" height="315" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encryted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            <p><?= $movie->description ?></p>
        </div>
        <div class="col-md-4">
            <div class="movie-image-container" style="background-image: url('<?= $app ?>/img/movies/<?= $movie->image ?>');"></div>
        </div>
        <div class="offset-md-1 col-md-10" id="reviews-container">
            <h3 id="reviews-title">Avaliações: </h3>
            <!--Verificar se o usuario pode realizar review-->
            <?php if(!empty($userData) && !$userOwnsMovie && !$alreadyReviewed):?>
                <?php require("templates/rating_movies.php")?>
            <?php endif;?>
            <!--Foreach de comentários-->
            <?php foreach ($movieReviews as $review): ?>
                <?php require("templates/user_reviews.php"); ?>
            <?php endforeach;?>
            <?php if (count($movieReviews) == 0): ?>
                <p class="empty-list">Seja o primeiro a deixar um comentário para este filme!</p>
            <?php endif;?>
        </div>
    </div>
</div>

<?php
require_once("templates/footer.php");
?>