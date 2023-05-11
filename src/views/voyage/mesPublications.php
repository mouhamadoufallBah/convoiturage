<div class="container mt-3">
    <?php if (!empty($_SESSION['success'])) : ?>
        <div class="alert alert-success" role="alert">
            <?php echo $_SESSION['success'];
            unset($_SESSION['success']) ?>
        </div>
    <?php endif ?>

    <?php if (!empty($_SESSION['erreur'])) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $_SESSION['erreur'];
            unset($_SESSION['erreur']) ?>
        </div>
    <?php endif ?>
</div>
<div class="container mt-5">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Mes publications
                <?php if ($_SESSION['nbreReservation'] > 0) : ?>
                    <span class="badge bg-warning"> <?= $_SESSION['nbreReservation'] ?></span>
                <?php endif ?>
            </button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Mes reservations</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
            <div class="accordion" id="accordionExample">
                <?php
                $reservationByvoyage = [];
                foreach ($voyage as $v) {
                    $id_voyage = $v->id;
                    if (!isset($reservationByvoyage[$id_voyage])) {
                        $reservationByvoyage[$id_voyage] = [];
                    }
                    array_push($reservationByvoyage[$id_voyage], $v);
                }
                ?>
                <?php foreach ($reservationByvoyage as $id_voyage => $rvs) : ?>
                    <div class="accordion-item mt-2">

                        <div class="accordion-header">
                            <?php
                            $count_en_attente = 0;
                            foreach ($rvs as $rv) {
                                if ($rv->etat == "En attente") {
                                    $count_en_attente++;
                                }
                            }
                            ?>
                            <div class="d-flex  align-items-center">
                                <div class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $id_voyage ?>" aria-expanded="false" aria-controls="collapse<?= $id_voyage ?>">
                                    <h6>De <?= $rvs[0]->lieu_depart ?> à <?= $rvs[0]->lieu_arrive ?>
                                        <?php if ($count_en_attente > 0) : ?>
                                            <span class="badge bg-warning"><?= $count_en_attente ?></span>
                                        <?php endif ?>
                                    </h6>
                                </div>
                                <div class="d-flex me-2">
                                    <a href="/voyage/modifier/<?= $id_voyage ?>" class="btn btn-outline-warning btn-sm me-2">Modifier</a>
                                    <a href="/voyage/suprimer/<?= $id_voyage ?>" class="btn btn-outline-danger btn-sm" href="/">Supprimer</a>
                                </div>
                            </div>
                        </div>

                        <div id="collapse<?= $id_voyage ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <!--Verifier s'il y a une reservation pour le voyage -->
                            <?php if (!empty($rvs[0]->idReservation)) : ?>
                                <table class="table accordion-body">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nom du client</th>
                                            <th scope="col">Nombre de place réserver</th>
                                            <th scope="col">Date et heure de réservation</th>
                                            <th scope="col">Action</th>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($rvs as $rv) : ?>
                                            <tr>
                                                <th scope="row"><?= $rv->idReservation ?></th>
                                                <td><?= $rv->nomComplet ?> </td>
                                                <td><?= $rv->placeReserver ?> </td>
                                                <td><?= $rv->dateReservation ?></td>
                                                <td>
                                                    <?php if ($rv->etat == "En attente") : ?>
                                                        <form method="POST" action="">
                                                            <input type="hidden" name="id_Reservation" value="<?= $rv->idReservation ?>">
                                                            <input type="hidden" name="etat" value="<?= $rv->etat ?>">
                                                            <button class="btn btn-success">Valider</button>
                                                        </form>
                                                    <?php else : ?>
                                                        <span class="text-success">Reservation confirmée</span>
                                                    <?php endif ?>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            <?php else : ?>
                                <h5 class="text-center display-6">Pas de réservation disponible pour ce voyage</h5>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach ?>

            </div>

        </div>

        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">

            <div class="accordion" id="accordionExample">

                <?php
                $voyageByReservation = [];
                foreach ($reservation as $r) {
                    $id_voyageR = $r->id;
                    if (!isset($voyageByReservation[$id_voyageR])) {
                        $voyageByReservation[$id_voyageR] = [];
                    }
                    array_push($voyageByReservation[$id_voyageR], $r);
                }
                ?>
                <?php foreach ($voyageByReservation as $id_voyageR => $reservations) : ?>
                    <div class="accordion-item mt-2">
                        <div class="d-flex  align-items-center">
                            <div class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $id_voyageR ?>" aria-expanded="false" aria-controls="collapse<?= $id_voyageR ?>">
                                <h6>De <?= $reservations[0]->lieu_depart ?> à <?= $reservations[0]->lieu_arrive ?>
                                    <!-- <?php if ($count_en_attente > 0) : ?>
                                        <span class="badge bg-warning"><?= $count_en_attente ?></span>
                                    <?php endif ?> -->
                                </h6>
                            </div>
                            <div class="d-flex me-2">
                                <a href="/voyage/annuler/<?= $reservations[0]->id  ?>" class="btn btn-outline-danger btn-sm">Annuler</a>
                            </div>
                        </div>
                        <div id="collapse<?= $id_voyageR ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <table class="table accordion-body">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nom du Chauffeur</th>
                                        <th scope="col">Nombre de place réserver</th>
                                        <th scope="col">Date et heure de réservation</th>
                                        <th scope="col">Prix du trajet</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($reservations as $reservation) : ?>
                                        <tr>
                                            <th scope="row"><?= $reservation->id ?></th>
                                            <td><?= $reservation->chauffeur ?></td>
                                            <td><?= $reservation->placeReserver ?></td>
                                            <td><?= $reservation->date_heure_reservation ?></td>
                                            <td><?= $reservation->placeReserver * $reservation->prix_place ?></td>
                                            <td>
                                                <?php if ($reservation->etat == "Valider") : ?>
                                                    <form method="POST" action="">
                                                        <input type="hidden" name="id_Reservation" value="<?= $reservation->id ?>">
                                                        <input type="hidden" name="etat" value="<?= $reservation->etat ?>">
                                                        <button class="btn btn-danger">Annuler</button>
                                                    </form>
                                                <?php else : ?>
                                                    <span class="text-warning">En attente de confirmation</span>
                                                <?php endif ?>

                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>