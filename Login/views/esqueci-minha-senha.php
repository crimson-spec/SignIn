<?php \Classes\ClassLayout::setHead('Esqueci minha senha', 'solicitar renovação de senha'); ?>

<div class="fundo"></div>

    
    <form name="formSenha" id="formSenha" action="<?php echo DIRPAGE.'controllers/controllerSenha';?>" method="POST">
        <div class="login">
            <div class="float w100 center"><strong>Esqueci Minha Senha</strong></div>
            <div class="resultadoForm retornoSen float w100 center"></div>
            <div class="resultadoForm retornoSen2 float w100 center" style="color:yellowgreen;"></div>

            <div class="loginFormulario" float w100>
                <input class="float w100 h40" type="email" name="email" id="email" placeholder="Email:" required>
                <input class="float w100 h40" type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" 
            required>
                <input class="float w100 h40" type="submit" value="Enviar">
            </div>
        </div>
    </form>

<?php \Classes\ClassLayout::setFooter(); ?>