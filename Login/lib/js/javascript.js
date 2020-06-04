// Máscaras do formulário de cadastro
$('#cpf, #dataNascimento').on('focus', function(){
    var id=$(this).attr("id");
    if(id == "cpf"){VMasker(document.querySelector('#cpf')).maskPattern("999.999.999-99");}
    if(id == "dataNascimento"){VMasker(document.querySelector('#dataNascimento')).maskPattern("99/99/9999");}
})

// reCAPTCHA DO GOOLE

function getCaptcha()
{
        grecaptcha.ready(function() {
          grecaptcha.execute('6Lf1a_oUAAAAAJXPQbSVe55HM8uaKUG3z29_mNfB', {action: 'homepage'}).then(function(token) {
            const gRecaptchaResponse=document.querySelector("#g-recaptcha-response").value=token;
        });
    });
};

getCaptcha();

// RETORNO DO ROOT (ENDEREÇO)

function getRoot()
{
    var root = "http://"+document.location.hostname+"/Login/";
    return root;
}



// AJAX DO FORMULÁRIO DE CADASTRO

$("#formCadastro").on("submit", function(event){
    event.preventDefault();
    var dados=$(this).serialize();

    $.ajax({
        url: getRoot()+'controllers/controllerCadastro',
        type: 'post',
        dataType: 'json',
        data: dados,
        success: function(response) {
            $('.retornoCad').empty();
            if(response.retorno == 'erro'){
                $('.retornoCad').empty();
                getCaptcha();
                $.each(response.erros, function(key, value){
                    $('.retornoCad').append(value+'<br>');
                });
            }else{
                $('.retornoCad').append('Usuário Cadastrado com Sucesso!');
            }
        }
    });
});


// AJAX DO FORMULÁRIO DE ESQUECI-MINHA-SENHA

$("#formSenha").on("submit", function(event){
    event.preventDefault();
    var dados=$(this).serialize();

    $.ajax({
        url: getRoot()+'controllers/controllerSenha',
        type: 'post',
        dataType: 'json',
        data: dados,
        success: function(response) {
            if(response.retorno == 'success'){
                $('.retornoSen').empty();
                $('.retornoSen2').empty();
                $('.retornoSen2').html("Redefinição de senha enviada!");
            }else{
                getCaptcha();
                $('.retornoSen').empty();
                $('.retornoSen2').empty();
                $.each(response.erros, function(key, value){
                    $('.retornoSen').append(value+'<br>');
                });
            }
        }
    });
});

// AJAX DO FORMULÁRIO DE REDEFINIR SENHA

$("#formSenha2").on("submit", function(event){
    event.preventDefault();
    var dados=$(this).serialize();

    $.ajax({
        url: getRoot()+'controllers/controllerRedefinirSenha',
        type: 'post',
        dataType: 'json',
        data: dados,
        success: function(response) {
            if(response.retorno == 'success'){
                alert("Senha Redefinida com sucesso!");
                window.location.href=response.page;
            }else{
                $('.retornoSen').empty();
                $.each(response.erros, function(key, value){
                    $('.retornoSen').append(value+'<br>');
                });
            }
        }
    });
});


// AJAX DO FORMULÁRIO DE LOGIN

$("#formLogin").on("submit", function(event){
    event.preventDefault();
    var dados=$(this).serialize();

    $.ajax({
        url: getRoot()+'controllers/controllerLogin',
        type: 'post',
        dataType: 'json',
        data: dados,
        success: function(response) {
            if(response.retorno == 'success'){
                window.location.href=response.page;
            }else{
                getCaptcha();
                if(response.tentativas == true){
                    $('.loginFormulario').hide();
                }
                $('.resultadoForm').empty();
                $.each(response.erros, function(key, value){
                    $('.resultadoForm').append(value+'<br>');
                })
            }
        }
    });
});

// CAPSLOCK ATIVO NO LOGIN!

$("#senha").keypress(function(e){
    kc=e.keyCode?e.keyCode:e.which;
    sk=e.shiftKey?e.shiftKey:((kc==16)?true:false);
    if(((kc>=65 && kc<=90) && !sk)||(kc>=97 && kc<=122) && sk){
        $(".resultadoForm").html("CapsLock Ligado !");
    }else{
        $(".resultadoForm").empty();
    }
});