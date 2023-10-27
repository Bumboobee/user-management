<?php
  //Controle de Permissão
  if (isset($_SESSION['usuario']) AND ($_SESSION['usuario']['permissao']!='Admin')){
    header("Location:acessoNegado.php");
    die();
  }
