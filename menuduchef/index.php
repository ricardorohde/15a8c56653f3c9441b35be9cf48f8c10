<? include("include/header.php"); ?>

<h2>Menu du Chef</h2>

<form action="admin/" method="post">
    <?// Apagar depois a linha abaixo ?>
    <font color="red"><strong>Login ainda não foi implementado. Para entrar no sistema, basta clicar em "Entrar" sem preencher os campos.</strong></font><br /><br />
    Login:
    <input type="text" name="login" maxlength="100" /><br />
    Senha:
    <input type="password" name="senha" maxlength="100" /><br /><br />
    <input type="submit" value="Entrar" />
</form>

<? include("include/footer.php"); ?>