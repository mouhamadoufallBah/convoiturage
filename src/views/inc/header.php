<header class="bg-dark" style="height: 50vh; background-image: url(https://images.pexels.com/photos/2224/road-people-street-smartphone.jpg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1);">
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-dark">
      <a class="navbar-brand" href="/">Convoiturage</a>
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
        <a href="/voyage/search " class="btn btn-dark bg-transparent border-transparent">
          <i class="bi bi-search"></i>
        </a>
      </div>
      <?php if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])) : ?>
        <div class="dropdown">
          <button class="btn text-white dropdown-toggle position-relative" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
            <?= $_SESSION['user']['nomComplet'] ?><span class="badge bg-warning position-absolute top-0 start-100 translate-middle"> <?= $_SESSION['nbreReservation'] ?></span>
          </button>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="/voyage/add">Publier une annonce</a></li>
            <li><a class="dropdown-item" href="/voyage/mesPublications/<?= $_SESSION['user']['id'] ?>">Mes trajets<span class="badge bg-warning"> <?= $_SESSION['nbreReservation'] ?></span></a></li>
            <li><a class="dropdown-item" href="/security/profile">Profil</a></li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li><a class="dropdown-item" href="/security/logout">Déconnexion</a></li>
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
  </div>
</header>