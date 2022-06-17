<?php
    require_once("templates/header.php");
    require_once("models/User.php");
    require_once("dao/UserDAO.php");
  
    $user = new User();
    $userDao = new UserDao($conn, $BASE_URL);
  
    $userData = $userDao->verifyToken(true);
?>
<!--Main-->
    <div id="main-container" class="container-fluid">
        <div class="offset-md-4 col-md-4 new-movie-container">
            <h3 class="page-title">Adicionar Filmes</h3>
            <p class="page-description">Compartilhe seus filmes favoritos e deixe a sua crítica!</p>
            <form action="<?= $BASE_URL ?>movie_process.php" id="add-movie-form" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="type" value="create">
                <div class="form-group">
                    <label for="title">Título:</label>
                    <input required type="text" class="form-control" id="title" name="title" placeholder="Título do filme...">
                </div>
                <div class="form-group">
                    <label for="image">Pôster do filme:</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>
               <div class="row">
                    <div class="col">
                        <div class="form-group">
                        <label for="length">Duração:</label>
                        <input required type="text" class="form-control" id="length" name="length" placeholder="Duração do filme...">
                        </div>
                    </div>
                    <div class="col">
                        
                <div class="form-group">
                    <label for="category">Categoria:</label>
                    <select required name="category" id="category" class="form-control category-control">
                        <option selected value="">Selecione</option>
                        <option class="option-category" value="Ação">Ação</option>
                        <option class="option-category" value="Romance">Animação</option>
                        <option class="option-category" value="Terror">Terror</option>
                        <option class="option-category" value="Comédia">Comédia</option>
                        <option class="option-category" value="Ficção Científica">Ficção Científica</option>
                        <option class="option-category" value="Romance">Romance</option>
                    </select>
                </div>
                    </div>
               </div>
                <div class="form-group">
                    <label for="trailer">Trailer do Filme:</label>
                    <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insira o link do trailer...">
                </div>
                <div class="form-group">
                    <label for="description">Sinopse:</label>
                    <textarea required name="description" id="description" rows="4" class="form-control" placeholder="Escreva uma descrição do filme..."></textarea>
                </div>
                <input type="submit" class="btn card-btn" value="Adicionar Filme">
            </form>
        </div>
    </div>
<!--End-Main-->
<?php
    require_once("templates/footer.php");
?>
