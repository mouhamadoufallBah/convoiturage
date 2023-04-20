<div class="container mt-5">
    <h1>Les trajet</h1>
    <div class="accordion" id="accordionExample">

        <?php foreach ($voyage as $v) : ?>
            <div class="accordion-item mt-2">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?= $v->id ?>" aria-expanded="false" aria-controls="collapse<?= $v->id ?>">
                        De <?= $v->lieu_depart ?> à <?= $v->lieu_arrive ?>
                    </button>
                </h2>
                <div id="collapse<?= $v->id ?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <?= $v->date_depart ?> | <?= $v->heure_depart ?><br>
                        <form action="" method="post">
                            <input type="hidden" name="id_voyage" value="<?= $v->id ?>">
                            <input type="hidden" name="id_passager" value="<?= $_SESSION['user']['id'] ?>">
                            <input class="btn btn-primary" type="submit" value="reserver">
                        </form>

                    </div>
                </div>
            </div>

        <?php endforeach ?>

    </div>
</div>