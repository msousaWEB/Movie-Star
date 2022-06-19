<?php
    require_once("templates/header.php");
    require_once("dao/MovieDAO.php");

    //DAO dos filmes
    $movieDao = new MovieDAO($conn, $BASE_URL);

    $latestMovies       = $movieDao->getLatestMovies();
    $actionMovies       = $movieDao->getMoviesByCategory("Ação");
    $comedyMovies       = $movieDao->getMoviesByCategory("Comédia");
    $animationMovies    = $movieDao->getMoviesByCategory("Animação");
    $romanceMovies      = $movieDao->getMoviesByCategory("Romance");
    $horrorMovies       = $movieDao->getMoviesByCategory("Terror");
    $fictionMovies      = $movieDao->getMoviesByCategory("Ficção Científica");

?>
<!--Main-->
    <div id="main-container" class="container-fluid">
        <h2 class="section-title">Filmes novos</h2>
        <p class="section-description">Veja as críticas mais recentes no MovieStar!</p>
        <div class="movies-container">

            <?php foreach($latestMovies as $movie): ?>
                <?php require("templates/movie_card.php")?>
            <?php endforeach; ?>
            <?php if(count($latestMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes cadastrados.</p>
            <?php endif;?>   
            
        </div>
        <h2 class="section-title">Ação</h2>
        <p class="section-description">Veja filmes com muita ação!</p>
        <div class="movies-container">
            <?php foreach($actionMovies as $movie): ?>
                <?php require("templates/movie_card.php")?>
            <?php endforeach; ?>
            <?php if(count($actionMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes cadastrados.</p>
            <?php endif;?>   
        </div>
        <h2 class="section-title">Comédia</h2>
        <p class="section-description">Os filmes mais engraçados!</p>
        <div class="movies-container">
            <?php foreach($comedyMovies as $movie): ?>
                <?php require("templates/movie_card.php")?>
            <?php endforeach; ?>
            <?php if(count($comedyMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes cadastrados.</p>
            <?php endif;?>   
        </div>
        <h2 class="section-title">Animação</h2>
        <p class="section-description">Espaço kids!</p>
        <div class="movies-container">
            <?php foreach($animationMovies as $movie): ?>
                <?php require("templates/movie_card.php")?>
            <?php endforeach; ?>
            <?php if(count($animationMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes cadastrados.</p>
            <?php endif;?>   
        </div>
        <h2 class="section-title">Romance</h2>
        <p class="section-description">Os mais românticos!</p>
        <div class="movies-container">
            <?php foreach($romanceMovies as $movie): ?>
                <?php require("templates/movie_card.php")?>
            <?php endforeach; ?>
            <?php if(count($romanceMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes cadastrados.</p>
            <?php endif;?>   
        </div>
        <h2 class="section-title">Terror</h2>
        <p class="section-description">Filmes assustadores!</p>
        <div class="movies-container">
            <?php foreach($horrorMovies as $movie): ?>
                <?php require("templates/movie_card.php")?>
            <?php endforeach; ?>
            <?php if(count($horrorMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes cadastrados.</p>
            <?php endif;?>   
        </div>
        <h2 class="section-title">Ficção Científica</h2>
        <p class="section-description">Mergulhe na ficção!</p>
        <div class="movies-container">
            <?php foreach($fictionMovies as $movie): ?>
                <?php require("templates/movie_card.php")?>
            <?php endforeach; ?>
            <?php if(count($fictionMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes cadastrados.</p>
            <?php endif;?>   
        </div>
    </div>
<!--End-Main-->
<?php
    require_once("templates/footer.php");
?>
