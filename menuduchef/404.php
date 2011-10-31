<? include("include/header.php"); ?>

<h2>404 - Página não encontrada - <u><?= $_SESSION['request_fail'] ?: $_SERVER["REQUEST_URI"] ?></u></h2>
<a href="" title="Ir para a página inicial">Ir para a página inicial</a>

<? unset($_SESSION['request_fail']); ?>

<? include("include/footer.php"); ?>