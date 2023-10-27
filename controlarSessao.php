<?php
session_start();

if (!isset($_SESSION['usuario'])){
  $_SESSION['msg'] = '<div class="alert alert-danger" role="alert">Usuário Não Autenticado!</div>';
  header("Location:index.php");
  die();
}
