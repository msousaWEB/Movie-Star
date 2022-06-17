<?php
  require_once("templates/header.php");

  require_once("models/User.php");
  require_once("dao/UserDAO.php");

  $user = new User();
  $userDao = new UserDao($conn, $BASE_URL);

  $userData = $userDao->verifyToken(true);

  $fullName = $user->getFullName($userData);

  if($userData->image == "") {
    $userData->image = "user.png";
  }

?>
<div id="main-container" class="container-fluid">
    <div class="title" style="text-align: center;"><h1><?= $fullName ?></h1></div>  
    <div class="row">
        <div class="col">
            <div class="accordion" id="accordionExample">
                <!------------------ALTERAR NOMES------------------>
                <div class="card">
                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0 pull-left">
                            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Alterar nome
                            </button>
                        </h5>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                        <div class="card-body">
                            <form action="<?= $BASE_URL ?>user_process.php" method="POST">
                                <input type="hidden" name="type" value="update">
                                    <div class="form-group">
                                        <label for="name">Nome:</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Digite o seu nome" value="<?= $userData->name ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="lastname">Sobrenome:</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Digite o seu sobrenome" value="<?= $userData->lastname ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">E-mail:</label>
                                        <input type="text" readonly class="form-control disabled" id="email" name="email" placeholder="Digite o seu email" value="<?= $userData->email ?>">
                                    </div>
                                <input type="submit" class="btn card-btn" value="Alterar">
                            </form>
                        </div>
                    </div>
                </div>

                    <!------------------FOTO E BIO------------------>

                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Alterar foto de perfil
                            </button>
                        </h5>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                        <div class="card-body">
                            <form action="<?= $BASE_URL ?>user_process.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="type" value="update_profile">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label for="image">Selecione uma imagem:</label>
                                                <input type="file" class="form-control-file" name="image">
                                            </div>
                                            <div class="form-group">
                                                <label for="bio">Sobre você:</label>
                                                <textarea class="form-control textbio" name="bio" id="bio" rows="2" placeholder="Conte quem você é, o que faz e onde trabalha..."><?= $userData->bio ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div id="profile-image-container" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')"></div>
                                        </div>
                                    </div>
                                <input type="submit" class="btn card-btn" value="Alterar">
                            </form>
                        </div>
                    </div>
                </div>

                <!------------------ALTERAR SENHA------------------>

                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h5 class="mb-0">
                            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Alterar senha
                            </button>
                        </h5>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                        <div class="card-body">
                            <div class="change-password-container">
                                <form action="<?= $BASE_URL ?>user_process.php" method="POST">
                                    <input type="hidden" name="type" value="change_password">
                                    <div class="form-group">
                                        <label for="password">Senha:</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Digite a sua nova senha">
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_password">Confirmação de senha:</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirme a sua nova senha">
                                    </div>
                                    <input type="submit" class="btn card-btn" style="padding: auto;" value="Alterar Senha">
                                </form>
                            </div>
                            </div>
                    </div>
                </div>
                </div>
        </div>
        <div class="col">
            <div class="profile-user-status">
                <div class="row profile-image">
                    <div id="profile-image-user" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $userData->image ?>')"></div>
                </div>
                <div class="title" style="text-align: center;"><h4><?= $fullName ?></h4></div>
                <div class="mx-auto" style="width: 400px;">
                    <label for="bio">Biografia:</label>
                    <textarea class="form-control textbio" readonly disabled name="bio" id="bio"><?= $userData->bio ?></textarea>
                </div>
                <div class="mx-auto" style="width: 400px;">
                    <label for="email">Contato:</label>
                    <input type="text" readonly class="form-control" id="email" name="email" placeholder="Digite o seu email" value="<?= $userData->email ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<?php
  require_once("templates/footer.php");
?>