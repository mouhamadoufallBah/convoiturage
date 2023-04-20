<div class="container mt-5">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Mes publications<span class="badge bg-warning"> <?= $_SESSION['nbreReservation'] ?></span></button>
            <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Mes reservations</button>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab" tabindex="0">
            <div class="accordion" id="accordionExample">

                <?php foreach ($voyage as $v) : ?>
                    <div class="accordion-item mt-2">
                        <h2 class="accordion-header">
                            <?php if ($v->etat == 'En attente') : ?>
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $v->id ?>" aria-expanded="false" aria-controls="collapse<?= $v->id ?>">
                                    De <?= $v->lieu_depart ?> à <?= $v->lieu_arrive ?><span class="badge bg-warning">1</span>
                                </button>
                            <?php else : ?>
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $v->id ?>" aria-expanded="false" aria-controls="collapse<?= $v->id ?>">
                                    De <?= $v->lieu_depart ?> à <?= $v->lieu_arrive ?>
                                </button>
                            <?php endif ?>
                        </h2>
                        <div id="collapse<?= $v->id ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <?= $v->date_depart ?> | <?= $v->heure_depart ?> <br> 
                                <form method="POST" action="" >
                                    <input type="hidden" name="id_Reservation" value="<?=$v->idReservation?>">
                                    <input type="hidden" name="etat" value="Valider">
                                    <button class="btn btn-success">Valider</button>
                                </form>
                                
                                
                                <button class="btn btn-danger ms-2">Annuler</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>

            </div>

        </div>

        <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" tabindex="0">

            <div class="accordion" id="accordionExample">

                <?php foreach ($reservation as $r) : ?>
                    <div class="accordion-item mt-2">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $r->id ?>" aria-expanded="false" aria-controls="collapse<?= $r->id ?>">
                                De <?= $r->lieu_depart ?> à <?= $r->lieu_arrive ?>
                            </button>
                        </h2>
                        <div id="collapse<?= $r->id ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                Chauffeur : <?= $r->chauffeur ?> | date: <?= $r->date_depart ?> | heure: <?= $r->heure_depart ?> | prix: <?= $r->prix_place ?> | passager: <?= $r->passager ?>
                            </div>
                        </div>
                    </div>

                <?php endforeach ?>

            </div>
        </div>
    </div>

</div>
