<?
$msgError = $msgError ? : ($_SESSION[DEFAULT_ERROR_SESSION_ATTRIBUTE_NAME] ? : 0);
$msgInfo = $msgInfo ? : ($_SESSION[DEFAULT_INFO_SESSION_ATTRIBUTE_NAME] ? : 0);
$msgWarning = $msgWarning ? : ($_SESSION[DEFAULT_WARNING_SESSION_ATTRIBUTE_NAME] ? : 0);

unset($_SESSION[DEFAULT_ERROR_SESSION_ATTRIBUTE_NAME]);
unset($_SESSION[DEFAULT_INFO_SESSION_ATTRIBUTE_NAME]);
unset($_SESSION[DEFAULT_WARNING_SESSION_ATTRIBUTE_NAME]);
?>

<? if ($msgError) {
foreach ($msgError as $msg) { ?>
<div class="msg error"><?= $msg ?></div>
<? } ?><br clear="all" /><? } ?>

<? if ($msgInfo) {
foreach ($msgInfo as $msg) { ?>
<div class="msg info"><?= $msg ?></div>
<? } ?><br clear="all" /><? } ?>

<? if ($msgWarning) {
foreach ($msgWarning as $msg) { ?>
<div class="msg warning"><?= $msg ?></div>
<? } ?><br clear="all" /><? } ?>