<?php
    require_once("templates/header.php");
    require_once("dao/movieDAO.php");

    //DAO dos filmes
    $movieDao = new MovieDAO($conn, $app);

    //Resgatar busca do usuário
    $q = filter_input(INPUT_GET, "q");
    $movies = $movieDao->findByTitle($q);
?>
<!--Main-->
    <div id="main-container" class="container-fluid">
        <h2 class="section-title" id="search-title">Você buscou por: <span id="search-result"><?=$q?></span></h2>
        <p class="section-description">Resultados:</p>
        <div class="movies-container">
            <?php foreach($movies as $movie): ?>
                <?php require("templates/movie_card.php")?>
            <?php endforeach; ?>
            <?php if(count($movies) === 0): ?>
                <p class="empty-list">Nenhum filme encontrado. <a href="<?=$app?>" class="back-link">Voltar</a></a></p>
            <?php endif;?>              
        </div>  
    </div>
<!--End-Main-->
<?php
    require_once("templates/footer.php");
?>
