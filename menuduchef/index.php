<? include("include/header.php"); ?>

<h2><?= SITE_TITLE ?></h2>

<form action="php/controller/login" method="post">
    E-mail:
    <input type="text" name="email" maxlength="50" /><br />
    Senha:
    <input type="password" name="senha" maxlength="50" /><br /><br />
    <input type="submit" value="Entrar" />
</form>

<? include("include/footer.php"); ?>