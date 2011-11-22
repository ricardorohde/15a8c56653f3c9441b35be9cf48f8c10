<?
$msgError = $msgError ? : ($_SESSION[DEFAULT_ERROR_SESSION_ATTRIBUTE_NAME] ? : 0);
$msgInfo = $msgInfo ? : ($_SESSION[DEFAULT_INFO_SESSION_ATTRIBUTE_NAME] ? : 0);
$msgWarning = $msgWarning ? : ($_SESSION[DEFAULT_WARNING_SESSION_ATTRIBUTE_NAME] ? : 0);

unset($_SESSION[DEFAULT_ERROR_SESSION_ATTRIBUTE_NAME]);
unset($_SESSION[DEFAULT_INFO_SESSION_ATTRIBUTE_NAME]);
unset($_SESSION[DEFAULT_WARNING_SESSION_ATTRIBUTE_NAME]);
?>

<? if($msgError || $msgInfo || $msgWarning) { ?>
<div id="messages">
    <script type="text/javascript">
	$(function() {
	    $('#close_messages').click(function() {
		$(this).parent().hide();
	    });
	});
    </script>
<? } ?>

<? if ($msgError) {
foreach ($msgError as $msg) { ?>
<div class="msg error">&raquo; <?= $msg ?></div>
<? } ?><? } ?>

<? if ($msgInfo) {
foreach ($msgInfo as $msg) { ?>
<div class="msg info">&raquo; <?= $msg ?></div>
<? } ?><? } ?>

<? if ($msgWarning) {
foreach ($msgWarning as $msg) { ?>
<div class="msg warning">&raquo; <?= $msg ?></div>
<? } ?><? } ?>

<? if($msgError || $msgInfo || $msgWarning) { ?>
    <a class="right" href="javascript:void(0)" id="close_messages">Fechar</a>
</div>
<? } ?>