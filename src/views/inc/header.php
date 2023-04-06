<header class="bg-dark">
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand" href="#">Convoiturage</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="/">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/main/about">À propos</a>
          </li>
        </ul>
      </div>
      <div class="d-flex">
        <a href="/main/search" class="btn btn-primary me-3">
          <i class="fas fa-search"></i>
        </a>
      </div>

      <?php if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) : ?>
        
        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            Profil / Deconnexion
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="/security/profil">Profil</a></li>
            <li><a class="dropdown-item" href="/security/logout">Deconnexion</a></li>
          </ul>
        </div>

      <?php else : ?>

        <div class="dropdown">
          <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            Connexion / Inscription
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="/security/login">Connexion</a></li>
            <li><a class="dropdown-item" href="/security/register">Inscription</a></li>
          </ul>
        </div>

      <?php endif; ?>
    </nav>
    <div class="row justify-content-center align-items-center text-center py-5">
      <div class="col-lg-6">
        <h1 class="display-4 text-white mb-4">Trouvez votre covoiturage</h1>
        <form>
          <div class="row justify-content-center align-items-center">
            <div class="col-md-3 mb-3">
              <input type="text" class="form-control form-control-lg" placeholder="Lieu de départ">
            </div>
            <div class="col-md-3 mb-3">
              <input type="text" class="form-control form-control-lg" placeholder="Lieu d'arrivée">
            </div>
            <div class="col-md-3 mb-3">
              <input type="Date" class="form-control form-control-lg" min="<?= date('Y-m-d') ?>">
            </div>
            <div class="col-md-3 mb-3">
              <input type="number" class="form-control form-control-lg" placeholder="Nombre de place" max="4">
            </div>
            <div class="col-md-12 mb-3">
              <button type="submit" class="btn btn-primary btn-lg w-100">Recherche</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</header>