<?php
    if(empty($movie->image)) {
        $movie->image = "movie_cover.jpg";
    }
?>

<div class="card movie-card">
    <div class="card-img-top" style="background-image: url('<?= $app ?>img/movies/<?= $movie->image ?>')"></div>
    <div class="card-body">
        <p class="card-rating"><i class="fas fa-star"></i><span class="rating"><?=$movie->rating?></span></p>
        <h5 class="card-title">
            <a href="<?= $app ?>movie.php?id=<?= $movie->id ?>"><?= $movie->title ?></a>
        </h5>
        <a href="<?= $app ?>movie.php?id=<?= $movie->id ?>" class="btn btn-primary rate-btn">Avaliar Filme</a>
        <a href="<?= $app ?>movie.php?id=<?= $movie->id ?>" class="btn card-btn">Conheça o filme!</a>
    </div>
</div>