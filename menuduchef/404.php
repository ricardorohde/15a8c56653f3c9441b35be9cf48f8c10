<? include("include/header.php"); ?>

<h2>404 - P�gina n�o encontrada - <u><?= $_SESSION['request_fail'] ?: $_SERVER["REQUEST_URI"] ?></u></h2>
<a href="" title="Ir para a p�gina inicial">Ir para a p�gina inicial</a>

<? unset($_SESSION['request_fail']); ?>

<? include("include/footer.php"); ?>