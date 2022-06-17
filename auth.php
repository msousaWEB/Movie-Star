<?php
    require_once("templates/header.php");
?>
<!--Main-->
    <div id="main-container" class="container-fluid">
        <div class="col-md-12">
            <div class="row" id="auth-row">
                <div class="col-md-4" id="login-container">
                    <!--------------------------------------ENTRAR-------------------------------->
                    <h2>Entrar</h2>
                    <form action="<?=$BASE_URL?>auth_process.php" method="POST">
                    <input type="hidden" name="type" value="login">
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu E-mail">
                        </div>
                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Digite sua Senha">
                        </div>
                        <input type="submit" class="btn card-btn" value="Entrar">
                    </form>
                </div>
                <div class="col-md-4" id="register-container">
                    <!--------------------------------------CRIAR CONTA-------------------------------->
                    <h2>Criar Conta</h2>
                    <form action="<?=$BASE_URL?>auth_process.php" method="POST">
                        <input type="hidden" name="type" value="register">
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="Digite seu E-mail">
                        </div>
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Digite seu Nome">
                        </div>
                        
                        <div class="form-group">
                            <label for="lastname">Sobrenome</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Digite seu Sobrenome">
                        </div>
                        <div class="form-group">
                            <label for="password">Criar Senha</label>
                            <input type="password" class="form-control" id="password" name="password" minlength="4" required placeholder="Crie sua Senha">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirmar Senha</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" minlength="4" placeholder="Digite sua senha novamente">
                        </div>
                        <input type="submit" class="btn card-btn" value="Registrar">
                    </form>
                </div>
            </div>
        </div>
    </div>
<!--End-Main-->
<?php
    require_once("templates/footer.php");
?>
