<label class="normal">E-mail:</label>
<input class="formfield w50" type="text" name="email" autocomplete="off" value="<?= $obj->email ?>" maxlength="255" />

<? if($obj->id) { ?>
    <input class="adjacent clear-left top10" type="checkbox" name="modificarSenha" id="modificarSenha" value="1" />
    <label class="adjacent top10" for="modificarSenha">Modificar senha</label>
<? } ?>

<span class="left w100" id="areaModificarSenha" <? if($obj->id) { ?>style="display: none"<? } ?>>
    <label class="normal">Senha:</label>
    <input class="formfield w15" type="password" name="senha" autocomplete="off" maxlength="100" />
    
    <label class="normal">Repita a senha:</label>
    <input class="formfield w15" type="password" name="senha_rep" autocomplete="off" maxlength="100" />
</span>

<script type="text/javascript">
    $(function() {
	$('#modificarSenha').change(permitirModificarSenha);
    });
</script>
