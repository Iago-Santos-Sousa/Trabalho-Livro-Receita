<?php
include_once("../config/process.php");
$todosRegistrosReceitasArray = todosRegistrosReceitas($userID);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php
      include_once("../src/templates/header.php");
    ?>
    <link rel="stylesheet" href="../src/css/cssPublic.css" />
    <title>Document</title>
  </head>
  <body style="height: 100vh" class="corpo">
    <nav
      class="navbar navbar-expand-lg bg-body-tertiary bg-primary fixed-top"
      data-bs-theme="dark"
    >
      <div class="container-fluid">
        <a class="navbar-brand" href="../index.php"
          ><img src="../src/img/icon.png" alt="icon logo"
        /></a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse p-3" id="navbarNav">
          <ul class="navbar-nav align-items-center">
            <?php if(isset($_SESSION['loggedin'])): ?>
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="../index.php"
                >Home</a
              >
            </li>
            <li class="nav-item">
              <a class="nav-link" href="./favoritos.php">Favoritos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link d-flex gap-2" href="">
                <i class="fa-regular fa-user text-light align-self-center"></i>
                <span><?=$_SESSION["email"]?></span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="../config/login/logout.php">Sair</a>
            </li>
            <?php endif; ?>
            <?php if (!isset($_SESSION['loggedin'])): ?>
              <?php header("Location:"."index.php"); ?>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container px-3" style="padding-top: 10rem;">
      <div class="row mb-5">
        <div class="col">
          <h3 class="text-center">Receitas</h3>
        </div>
      </div>
      <form method="POST" action="../config/process.php">
        <div class="row justify-content-center">
          <div class="col-md-4">
            <div class="form-floating mb-3">
              <input
                type="text"
                class="form-control focus-ring focus-ring-primary"
                id="nome-receita"
                name="nome_receita"
                placeholder="Nome da receita"
              />
              <label for="nome-receita">Nome da receita</label>
            </div>
          </div>

          <div class="col-md-4">
            <div class="form-floating">
              <input
                type="number"
                class="form-control focus-ring focus-ring-primary"
                id="tempo_preparo"
                name="tempo_preparo"
                placeholder="Ingrediente"
              />
              <label for="tempo_preparo">Tempo de preparo</label>
            </div>
          </div>
        </div>

        <div class="row justify-content-center mt-3">
          <div class="col-md-8 col-lg-6">
            <div class="form-floating">
              <textarea
                class="form-control"
                placeholder="Ingrediente"
                id="ingrediente"
                name="ingrediente"
                style="height: 100px"
              ></textarea>
              <label for="ingrediente">Ingredientes</label>
            </div>
          </div>
        </div>

        <div class="row justify-content-center mt-3">
          <div class="col-md-8 col-lg-6">
            <div class="form-floating">
              <textarea
                class="form-control"
                placeholder="Leave a comment here"
                id="modo_preparo"
                name="modo_preparo"
                style="height: 100px"
              ></textarea>
              <label for="modo_preparo">Modo de preparo</label>
            </div>
          </div>
        </div>

        <?php
          if(isset($_SESSION["camposVazios"])) {
            echo '<div class="row justify-content-center"><div class="col-6 col-md-6 col-lg-6 col-xl-5"><div id="liveAlertPlaceholder" class="mt-2"></div></div></div>';
            unset($_SESSION["camposVazios"]);
          }
        ?>

        <div class="row justify-content-center pt-4">
          <div class="col-auto">
            <input type="hidden" name="criar-receita" value="create" />
            <button type="submit" class="btn btn-primary">Adicionar</button>
          </div>
        </div>
      </form>
    </div>

    <div class="container mt-5 pb-5">
      <?php
        if(isset($_SESSION["msgFavorito"])) {
          echo $_SESSION["msgFavorito"];
          unset($_SESSION["msgFavorito"]);
        }
      ?>
      <div class="row">
        <?php if(count($todosRegistrosReceitasArray) >
        0):?>
        <?php foreach($todosRegistrosReceitasArray as $receita):?>
        <div class="col-md-3 pb-3" style="margin-bottom: 5rem;">
          <div class="card border-info border-3">
            <img class="card-img-top img-fluid" src="../src/img/recipe.svg" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title text-center"><?=$receita["nome_receitas"]?></h5>
              <div><hr class="border-3 text-success"></div>
              <p class="card-text fw-bold"><i class="fa-regular fa-clock" style="color: #e17c09; cursor: pointer;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Tempo de preparo" data-bs-custom-class="custom-tooltip"></i> <?=$receita["tempo_de_preparo"]?>: Minutos</p>
              <p class="card-text text-center d-flex gap-1 justify-content-center flex-wrap">
                <a type="button" style="width: 8rem;" tabindex="0" class="btn btn-primary" role="button" data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="<?=$receita["nome_ingredientes"]?>">
                Ingredientes
                </a>
                <a type="button" tabindex="0" style="width: 8rem;" class="btn btn-success" role="button" data-bs-container="body" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-custom-class="custom-tooltip" data-bs-title="<?=$receita["descricao"]?>">
                Descrição
                </a>
              </p>
              <div class="acoes d-flex">
                <form action="edit.php" method="POST">
                  <input type="hidden" name="receitaID" value="<?=$receita["id_receitas"]?>">

                  <button type="submit" class="delete-btn border-0 text-success" style="background-color: initial;"><i class="fa-solid fa-pencil text-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Editar receita" data-bs-custom-class="custom-tooltip"></i></button>
                </form>

                <form method="POST" action="../config/process.php">
                  <input type="hidden" name="favorito" value="favoritos">

                  <input type="hidden" name="id_receitas" value="<?=$receita["id_receitas"]?>">

                  <button type="submit" class="delete-btn border-0 text-success" style="background-color: initial;"><i class="fa-solid fa-star" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Favoritar" data-bs-custom-class="custom-tooltip"></i></button>
                </form>

                <form method="POST" action="../config/process.php">
                  <input type="hidden" name="deletar-receita" value="delete">

                  <input type="hidden" name="id_receitas" value="<?=$receita["id_receitas"]?>">

                  <input type="hidden" name="id_ingredientes" value="<?=$receita["id_ingredientes"]?>">

                  <button type="submit" class="delete-btn border-0 text-danger" style="background-color: initial;"><i class="fa-solid fa-trash-can" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Excluir receita" data-bs-custom-class="custom-tooltip"></i></button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach;?>
        
        <?php else:?>
          <div class="text-center pb-4"><h3>Não há receitas</h3></div>
          <div style="display: flex; align-items: center; justify-content: center;margin-bottom: 5rem;">
            <img src="../src/img/sad-face.svg" alt="" style="width: 170px;">
          </div>
        <?php endif;?>
        
      </div>
    </div>

    <?php include_once("../src/templates/footer.php");?>
    <script src="../src/js/toolTip.js" type="text/javascript"></script>
    <script src="../src/js/toastFavorito.js" type="text/javascript"></script>
    <script src="../src/js/alertCamposVazios.js" type="text/javascript"></script>
  </body>
</html>
