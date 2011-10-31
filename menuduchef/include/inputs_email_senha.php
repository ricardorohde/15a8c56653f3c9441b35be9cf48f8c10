E-mail<br />
<input type="text" name="email" autocomplete="off" value="<?= $obj->email ?>" maxlength="255" /><br /><br />

<? if($obj->id) { ?>
    <input type="checkbox" name="modificarSenha" id="modificarSenha" value="1" />
    <label for="modificarSenha">Modificar senha</label>
    <br /><br />
<? } ?>

<span id="areaModificarSenha" <? if($obj->id) { ?>style="display: none"<? } ?>>
    Senha<br />
    <input type="password" name="senha" autocomplete="off" maxlength="100" /><br /><br />
    Repita a senha<br />
    <input type="password" name="senha_rep" autocomplete="off" maxlength="100" /><br clear="all" /><br />
</span>

<script type="text/javascript">
    $(function() {
	$('#modificarSenha').change(permitirModificarSenha);
    });
</script>
