<?php
$timestamp = new DateTime($voyage->date_depart);
$date = $timestamp->format('l j F');

?>
<div class="row justify-content-center align-items-center py-5">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h1 class=" text-center"><?= $date ?></h1>
                <div>
                    <p>
                    <h3>🏁<?= $voyage->lieu_depart ?></h3><br>
                    <h3>🚩<?= $voyage->lieu_arrive ?></h3>
                    </p>
                </div>
                <hr>
                <div>
                    <h5><?= $voyage->nomComplet ?></h5>
                </div>
                <hr>
                <div>
                    <h5 class="">Combien de place souhaiter vous reserver</h5>
                    <form action="" method="post" class="row g-3">
                        <div class="">
                            <input class="form-control" type="number" name="nombrePlace" id="nombrePlace" min="1" max="4" value="<?= $nombre ?>" onchange="calculePrix()">
                            <p id="prix">Prix totale : 0 FCFA</p>
                        </div>
                        <div class="d-grid gap-2 col-4 mx-auto text-center">
                            <input type="hidden" name="id_voyage" value="<?= $voyage->id ?>">
                            <input type="hidden" name="id_passager" value="<?= $_SESSION['user']['id'] ?>">
                            <input class="btn btn-primary" type="submit" value="reserver">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>