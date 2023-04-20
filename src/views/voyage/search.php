<div class="row justify-content-center align-items-center  py-5">
  <div class="col-lg-6">
    <h1 class="display-4 text-dark mb-4 text-center">Trouvez votre covoiturage</h1>
    <form method="POST" action="">
      <div class="row justify-content-center align-items-center">
        <div class="col-md-3 mb-3">
          <input type="text" class="form-control form-control-lg" placeholder="Lieu de départ" name="lieu_depart" id="lieu_depart">
        </div>
        <div class="col-md-3 mb-3">
          <input type="text" class="form-control form-control-lg" placeholder="Lieu d'arrivée" name="lieu_arrive" id="lieu_arrive">
        </div>
        <div class="col-md-3 mb-3">
          <input type="Date" class="form-control form-control-lg" min="<?= date('Y-m-d') ?>" name="date_depart" id="date_depart">
        </div>
        <div class="col-md-3 mb-3">
          <input type="time" class="form-control form-control-lg" placeholder="" name="heure_depart" id="heure_depart">
        </div>
        <div class="col-md-12 mb-3">
          <button type="submit" class="btn btn-primary btn-lg w-100">Recherche</button>
        </div>
      </div>
    </form>
    <div class="container">
      <?php if (!empty($voyages)) : ?>
        <h2>Résultats de recherche</h2>
        <div class="row">
          <?php foreach ($voyages as $voyage) : ?>
            <div class="card mb-3">
              <div class="card-body">
                <h5 class="card-title"><?= $voyage->lieu_depart ?> - <?= $voyage->lieu_arrive ?></h5>
                <p class="card-text">Départ le <?= $voyage->date_depart ?> à <?= $voyage->heure_depart ?></p>
                <p class="card-text">Chauffeur : <?= $voyage->nomComplet ?></p>
                <a href="/voyage/detail/<?= $voyage->id ?> " target="_blank" class="btn btn-primary">Réserver</a>
              </div>
              <div class="card-footer text-muted">
                <div class="d-flex justify-content-between align-items-center">
                  <div class="p-2">
                    <span class="font-weight-bold">Places restantes :</span>
                    <span class="badge text-bg-success"><?= $voyage->nomComplet ?></span>
                  </div>
                  <div class="p-2">
                    <span class="font-weight-bold">Prix :</span>
                    <span class=" badge text-bg-info"><?= $voyage->prix_place ?> FCFA</span>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else : ?>
        <h2>Résultats de recherche</h2>
        <p>Aucun voyage trouvé pour votre recherche.</p>
      <?php endif; ?>
    </div>

  </div>
</div>