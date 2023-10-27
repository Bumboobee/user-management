
<?php
  require_once 'controlarSessao.php';
?>



<!doctype html>
<html lang="pt-br" class="h-100">
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <link href="public/style/bootstrap-4.4.1.css" rel="stylesheet" type="text/css"/>
   <link rel="icon" href="./public/assets/user-management.png">
    
   <!-- coloquei por razão de não funcionar o local???? public/css/fontawesome.css>-->
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
   <link href="./public/css/sticky-footer-navbar.css" rel="stylesheet" type="text/css"/>
   <meta name="description" content="Primeiro projeto em php #helloWorld"/>
   <title>CRUD | Produto</title>
   </head>
   <body class="d-flex flex-column h-100">   

    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="home.php"><img src="./public/assets/user-management.svg" alt="manager block" title="manager block" /></a>
           <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
           <span class="navbar-toggler-icon"></span>
           </button>
           <div class="collapse navbar-collapse" id="navbarCollapse">
              <ul class="navbar-nav mr-auto">
                 <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</span></a>
                 </li>
                 <li class="nav-item">
                    <a class="nav-link" href="listarProdutos.php">Lista Produto</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" href="cadastrarProduto.php">Cadastrar Produto</a>
                 </li>
                 <li class="nav-item">
                     <a class="nav-link" href="manutencaoUsuarios.php">Usuários</a>
                 </li>
              </ul>
               
               
              <ul class="navbar-nav"  style="margin-right: 0px">
                <li class="nav-item dropdown" style="margin-right: 0px">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                 <i class="fas fa-user"> </i> &nbsp;<span class="d-sm-inline"><?php if (isset($_SESSION['usuario']['login'])) echo $_SESSION['usuario']['login'];?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" >
                  <a class="dropdown-item" href="#">Perfil</a>
                  <a class="dropdown-item" href="#">Trocar Senha</a>
                  <a class="dropdown-item" href="sair.php">Sair</a>
                </div>
              </li>
             </ul>      

           </div>
        </nav>
    </header>