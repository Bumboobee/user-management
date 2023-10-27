<?php
  //Controle de Permissão
  if (isset($_SESSION['usuario']) AND ($_SESSION['usuario']['permissao']=='Leitura')){
    header("Location:acessoNegado.php");
    die();
  }
