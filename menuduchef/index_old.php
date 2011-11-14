<? include("include/header.php"); ?>

<h2><?= SITE_TITLE ?></h2>

<form action="php/controller/login" method="post">
    <label for="email" class="normal">E-mail:</label>
    <input type="text" id="email" name="email" maxlength="50" />
    <label for="senha" class="normal">Senha:</label>
    <input type="password" id="senha" name="senha" maxlength="50" />
    <input class="btn" type="submit" value="Entrar" />
</form>

<? include("include/footer.php"); ?>