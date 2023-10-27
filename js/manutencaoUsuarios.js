//Envia os dados do Formulário de Novo Usuário via Post
$(document).ready(function () {
    $('#formNovoUsuario').on('submit', function(e){
      e.preventDefault();
      //alert("Dentro do script de enviar post");
      //Recebe os dados do Formulário
      var dados = $('#formNovoUsuario').serialize();
      //alert(dados);
      $.post("salvarUsuario.php", dados, function(retorno){
        //alert(retorno);
        if (retorno['erro']){ //Erro no Cadastro
            $("#msgCadUsrModal").html(retorno['msg']);  //Mensagem no Modal
        } else { //Cadastro realizado com sucesso
            //Mensagem na tela Principal vai via SESSION
            //Limpar campos
			$('#formNovoUsuario')[0].reset();
							
			//Fechar janela modal Novo Usuário
			$('#ModalNovoUsuario').modal('hide');
            
            //Chama a página de Manutenção de Usuários e mostra a msg de Sucesso.            
            location.reload(true);
        }
      });
    });
 });

$(document).ready(function () {
    $('#ModalNovoUsuario').on('hidden.bs.modal', function () {
        $('#formNovoUsuario')[0].reset();
        $("#msgCadUsrModal").html('');
    });
});
 
//Passa parâmetro para o Modal doEditar Usuário
$('#ModalEditarUsuario').on('show.bs.modal', function (event) {      
    var button = $(event.relatedTarget); //Botão que ativou o Modal
    var recipientLogin      = button.data('login');
    var recipientNome       = button.data('nome');
    var recipientEmail      = button.data('email');
    var recipientPermissao  = button.data('permissao');
    //alert(recipientLogin);
    //alert(recipientNome);
    var modal = $(this);
    //Pega o valor armazenado no recipient e substitui no modal onde o #id = o id do campo no modal 
    modal.find('#login').val(recipientLogin);
    modal.find('#nome').val(recipientNome);
    modal.find('#email').val(recipientEmail);
    modal.find('#permissao').val(recipientPermissao);
    $("#msgEdtUsrModal").html(""); //Limpa o campo de mensagem de erro
    $('#nome').focus();
});

//Envia dados do Formulário dentro do Modal Editar para o back-end via Post
$(document).ready(function () {
    $('#formEditarUsuario').on('submit', function(e){
      e.preventDefault();
      //alert("Dentro do script de enviar post");
      //Recebe os dados do Formulário
      var dados = $('#formEditarUsuario').serialize();
      //alert(dados);
      $.post('salvarUsuarioEditar.php', dados, function(retorno){
        //alert(retorno);
        if (retorno['erro']){ //Erro no Salvar Editar
            $("#msgEdtUsrModal").html(retorno['msg']);  //Mensagem no Modal
        } else { //Alteração realizada com sucesso
            $("#msgManutUsr").html(retorno['msg']); //Mensagem na tela Principal
            //Limpar campos
			$('#formEditarUsuario')[0].reset();	
			//Fechar janela modal Editar Usuário
			$('#ModalEditarUsuario').modal('hide');
            //Chama a página de Manutenção de Usuários e mostra a msg de Sucesso.
            location.reload(true);
        }
      });
    });
});        

//Passa parâmetros para o Modal usado no Ressetar Senha
$('#ModalRessetarSenha').on('show.bs.modal', function (event) {      
    var button = $(event.relatedTarget); //Botão que ativou o Modal
    var recipientLogin      = button.data('login');
    var recipientNome       = button.data('nome');
    //alert(recipientLogin);
    //alert(recipientNome);
    var modal = $(this);
    //Pega o valor armazenado no recipient e substitui no modal onde o #id = o id do campo no modal 
    modal.find('#login').val(recipientLogin);
    modal.find('#nome').val(recipientNome);
});

//Envia dados do Formulário dentro do Modal Ressetar Senha para o back-end via Post
$(document).ready(function () {
    $('#formRessetarSenha').on('submit', function(e){
      e.preventDefault();
      //alert("Dentro do script de enviar post");
      //Recebe os dados do Formulário
      var dados = $('#formRessetarSenha').serialize();
      //alert(dados);
      $.post('ressetarSenhaUsuario.php', dados, function(retorno){
        //alert(retorno);
        if (retorno['erro']){ //Erro de Validação
            $("#msgRstUsrModal").html(retorno['msg']);  //Mensagem no Modal
        }else { //Alteração realizada com sucesso
            //Limpar campos
			$('#formRessetarSenha')[0].reset();	
			//Fechar janela modal Editar Usuário
			$('#ModalRessetarSenha').modal('hide');
            //Chama a página de Manutenção de Usuários e mostra a msg de Sucesso via SESSION
            location.reload(true);
        }
      });
    });
});        

//Passa parâmetros para o Modal usado no Excluir Usuário
$('#ModalExcluirUsuario').on('show.bs.modal', function (event) {      
    var button = $(event.relatedTarget); //Botão que ativou o Modal
    var recipientLogin      = button.data('login');
    var recipientNome       = button.data('nome');
    //alert(recipientLogin);
    //alert(recipientNome);
    var modal = $(this);
    //Pega o valor armazenado no recipient e substitui no modal onde o #id = o id do campo no modal 
    modal.find('#logintxt').text(recipientLogin); //Esse campo é um h5 no Modal
    modal.find('#login').val(recipientLogin); //Esse campo um input hidden    
    modal.find('#nometxt').text(recipientNome); //Esse campo é um h5 no Modal

});

//Envia dados do Formulário dentro do Modal Excluir para o back-end via Post
$(document).ready(function () {
    $('#ModalExcluirUsuario').on('submit', function(e){
      e.preventDefault();
      //alert("Dentro do script de enviar post");
      //Recebe os dados do Formulário
      var dados = $('#formExcluirUsuario').serialize();
      //alert(dados);
      $.post('excluirUsuario.php', dados, function(retorno){
        //alert(retorno);
        if (retorno['erro']){ //Erro de Validação
            $("#msgExcUsuario").html(retorno['msg']);  //Mensagem no Modal
        }else { //Exclusão realizada com sucesso
            //Limpar campos
			$('#formRessetarSenha')[0].reset();	
			//Fechar janela modal Excluir Usuário
			$('#ModalExcluirUsuario').modal('hide');
            //Chama a página de Manutenção de Usuários e mostra a msg de Sucesso via SESSION
            location.reload(true);
        }
      });
    });
});  
