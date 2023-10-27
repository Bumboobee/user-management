<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="./public/css/bootstrap.min.css">
    <link rel="stylesheet" href="./public/css/login.css">
    <link rel="icon" href="./public/assets/logo-fullsize.svg">

    <!-- coloquei por razão de não funcionar o local???? public/css/fontawesome.css>-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>CRUD-Produto Login</title>
  </head>
  <body class="text-center">
    <form class="form-login" action="validarLogin.php" method="post" id="form_login">
      <img  src="./public/assets/logo-fullsize.svg" alt="CRUD_logo">
    
      <span> 
        <?php //Mensagens de Erro na Autenticação            
          if(isset($_SESSION['msg'])){
              echo $_SESSION['msg'];
              unset($_SESSION['msg']);
          }
        ?>          
      </span>      
            
	  <div class="form-row align-items-center" style="margin-right: 8px;">
		<i class="fas fa-user col-2"  style="margin-bottom:20px; font-size:25px;color:#012060;"></i>
            <input type="text" name="login" value="<?php if (isset($_SESSION["login"])){ echo $_SESSION["login"]; unset($_SESSION["login"]);} ?>" class="form-control col-10" style="margin-bottom:20px; font-size:16px;" placeholder="Digite o Login" required autofocus>	  
	  </div>	  
	  <div class="form-row align-items-center" style="margin-right: 8px;">
		<i class="fas fa-lock col-2" type="icon" style="margin-bottom:30px; font-size:25px;color:#012060;"></i>
		<input type="password" name="senha" class="form-control col-10" style="margin-bottom:30px;" placeholder="Digite a senha" required>
	  </div>  
	  <div class="form-row align-items-center">
		<button class="btn btn-lg btn-outline-warning btn-block btn-hover" style="margin-left:15px; margin-right: 10px;" type="submit">Entrar</button>
	  </div>
	  <div class="form-row align-items-center">
		<p class="col-12 font-italic text-muted" style="margin-top:30px;" >&copy; bumboobee-2020 💡</p>
	  </div>
	  
    </form>
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="./public/js/jquery-3.4.1.slim.min.js"></script>
    <script src="./public/js/popper.min.js"></script>
    <script src=".public/js/bootstrap.min.js"></script>
  </body>
</html>


       

