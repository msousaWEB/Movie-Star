<?php
    require_once("templates/header.php");
    require_once("models/user.php");
    require_once("dao/userDAO.php");
    require_once("dao/movieDAO.php");
  
    $user = new User();
    $userDao = new UserDao($conn, $BASE_URL);
    $movieDao = new MovieDao($conn, $BASE_URL);
  
    $userData = $userDao->verifyToken(true);
    $userMovies = $movieDao->getMoviesByUserId($userData->id);
?>

<div id="main-container" class="container-fluid">
    <h2 class="section-title">Seus Filmes</h2>
    <p class="section-description">Adicione ou edite as informações sobre seus filmes!</p>
    <div class="col-md-12" id="add-movie-container">
        <a href="<?= $BASE_URL ?>new_movie.php" class="btn card-btn">
            <i class="fas fa-plus"></i> Adicione mais filmes!
        </a>
    </div>
    <div class="col-md-12" id="movies-dashboard">
        <table class="table">
            <thead>
                <th scope="col">Título</th>
                <th scope="col">Categoria</th>
                <th scope="col">Nota</th>
                <th scope="col" class="actions-column">Ações</th>
            </thead>
            <tbody>
                <?php foreach($userMovies as $movie): ?>
                <tr>
                    <td><a href="<?=$BASE_URL?>movie.php?id=<?= $movie->id ?>" class="table-movie-title"><?= $movie->title ?></a></td>
                    <td scope="row"><?= $movie->category ?></td>
                    <td><i class="fas fa-star"></i> 9</td>
                    <td class="actions-column">
                       <!-- Botão para acionar modal -->
                        <button type="button" class="btn edit-btn" data-toggle="modal" data-target="#editmovie<?=$movie->id?>"><i class="far fa-edit"></i></button>

                        <!-- Modal -->
                        <div class="modal fade" id="editmovie<?=$movie->id?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form id="edit-movie-form" action="<?=$BASE_URL?>movie_process.php" method="POST" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="container-fluid">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <h3 class="section-title">Editar: <?=$movie->title?></h3>
                                                            <input type="hidden" name="type" value="update">
                                                            <input type="hidden" name="id" value="<?=$movie->id?>">
                                                            <div class="form-group">
                                                                <label for="title">Título:</label>
                                                                <input type="text" class="form-control" id="title" name="title" placeholder="Título do seu filme..." value="<?=$movie->title?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="image">Pôster do filme:</label>
                                                                <input type="file" class="form-control-file" id="image" name="image">
                                                            </div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="length">Duração:</label>
                                                                        <input type="text" class="form-control" id="length" name="length" placeholder="Duração do filme..." value="<?=$movie->length?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="form-group">
                                                                        <label for="category">Categoria:</label>
                                                                        <select name="category" id="category" class="form-control category-control">
                                                                            <option value="">Selecione</option>
                                                                            <option class="option-category" value="Ação" <?=$movie->category === "Ação" ? "selected" : ""?>>Ação</option>
                                                                            <option class="option-category" value="Animação" <?=$movie->category === "Animação" ? "selected" : ""?>>Animação</option>
                                                                            <option class="option-category" value="Terror" <?=$movie->category === "Terror" ? "selected" : ""?>>Terror</option>
                                                                            <option class="option-category" value="Comédia" <?=$movie->category === "Comédia" ? "selected" : ""?>>Comédia</option>
                                                                            <option class="option-category" value="Ficção Científica" <?=$movie->category === "Ficção Científica" ? "selected" : ""?>>Ficção Científica</option>
                                                                            <option class="option-category" value="Romance" <?=$movie->category === "Romance" ? "selected" : ""?>>Romance</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="trailer">Trailer do Filme:</label>
                                                                <input type="text" class="form-control" id="trailer" name="trailer" placeholder="Insira o link do trailer..." value="<?=$movie->trailer?>">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="description">Sinopse:</label>
                                                                <textarea name="description" id="description" rows="3" class="form-control" placeholder="Editar sinopse"><?=$movie->description?></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                            <input type="submit" class="btn card-btn" value="Salvar">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                     <!--    -->
                        <form action="<?=$BASE_URL?>movie_process.php" method="POST">
                            <input type="hidden" name="type" value="delete">
                            <input type="hidden" name="id" value="<?= $movie->id ?>"> 
                            <button type="submit" class="delete-btn">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script type="text/javascript">
$('#editmovie').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Botão que acionou o modal
  var recipient = button.data('whatever') // Extrai informação dos atributos data-*
  // Se necessário, você pode iniciar uma requisição AJAX aqui e, então, fazer a atualização em um callback.
  // Atualiza o conteúdo do modal. Nós vamos usar jQuery, aqui. No entanto, você poderia usar uma biblioteca de data binding ou outros métodos.
  var modal = $(this)
  modal.find('.modal-title').text('Nova mensagem para ' + recipient)
  modal.find('.modal-body input').val(recipient)
})
</script>


<?php
    require_once("templates/footer.php");
?>