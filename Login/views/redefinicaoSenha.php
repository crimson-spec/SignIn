<?php \Classes\ClassLayout::setHead('Redefinição Senha', 'Redefinir a senha do usuário'); ?>

<div class="fundo"></div>

    
    <form name="formSenha2" id="formSenha2" action="<?php echo DIRPAGE.'controllers/controllerRedefinirSenha';?>" method="POST">
        <div class="login">
            <div class="float w100 center"><strong>Redefina sua senha!</strong></div>
            <div class="resultadoForm retornoSen float w100 center"></div>

            <div class="loginFormulario" float w100>
                <input class="float w100 h40" type="hidden" name="email" id="email" value="<?php echo \Traits\TraitParseUrl::parseUrl(1); ?>">
                <input class="float w100 h40" type="hidden" name="token" id="token" value="<?php echo \Traits\TraitParseUrl::parseUrl(2); ?>">
                <input class="float w100 h40" type="password" name="senha" id="senha" placeholder="Senha Nova:" required>
                <input class="float w100 h40" type="password" name="senhaConf" id="senhaConf" placeholder="Repita Senha Nova:" required>
                <input class="float h40 center" type="submit" value="Redefinir">
            </div>
        </div>
    </form>

<?php \Classes\ClassLayout::setFooter(); ?>