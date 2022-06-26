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
    $alreadyReviewed = false;
    if(!empty($userData)) {
        if($userData->id === $movie->users_id) {
            $userOwnsMovie = true;
        }
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
                <span><i class="fas fa-star"></i> 9</span>
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
            <div class="col-md-12" id="review-form-container">
                <h4>Envie a sua avaliação!</h4>
                <p class="page-description">Deixe a sua nota e impressões sobre o filme!</p>
                <form  id="review-form" action="<?=$app?>review_process.php" method="POST">
                    <input type="hidden" name="type" value="create">
                    <input type="hidden" name="movies_id" value="<?= $movie->id ?>">
                    <div class="form-group">
                        <label for="rating">Nota do filme:</label>
                        <select name="rating" id="rating" class="form-control">
                            <option value="10">10</option>
                            <option value="9">9</option>
                            <option value="8">8</option>
                            <option value="7">7</option>
                            <option value="6">6</option>
                            <option value="5">5</option>
                            <option value="4">4</option>
                            <option value="3">3</option>
                            <option value="2">2</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="review">Seu comentário:</label>
                        <textarea class="form-control" name="review" id="review" rows="3" placeholder="Qual sua opinião sobre este filme?"></textarea>
                    </div>
                    <input type="submit" class="btn card-btn" value="Enviar">
                </form>
            </div>
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