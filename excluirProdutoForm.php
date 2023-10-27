<?php
require_once 'header.php';
require_once 'permissaoLeitura.php';
?>

  <main role="main" class="flex-shrink-0">
  <div class="container">
    <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <h1 class="my-3 bg-danger header-delete text-center text-light">EXCLUSAO DE PRODUTO</h1>

      <form action="excluirProdutoExclusao.php" method="post" id="formExcluirProduto">
        <input	type="hidden" name="id"	value="<?php if (isset($_SESSION["form"]["id"])) echo $_SESSION["form"]["id"]; ?>">
        <div class="card mb-3" style="max-width: 22 rem;">
          <div class="card-header">Confirmação da Exclusão do Produto</div>
          <div class="card-body">
            <h5 class="card-title">Excluir?</h5>
            <p>Confirma exclusão do produto: <?php if (isset($_SESSION["form"]["nome"])) echo $_SESSION["form"]["nome"];?> ?</p>
            
            <div class="mt-3 d-block text-right">
                <button type="submit" class="btn btn-primary btn-sm mt-2">Confirmar</button>
                <a href="listarProdutos.php" class="btn btn-info btn-sm mt-2">Cancelar</a>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div class=" col-md-3"></div>
  </div>
</div>
</main>

<style>
    .header-delete {
        border-radius: .8rem;
    }
</style>

<?php
require_once 'footer.php';
