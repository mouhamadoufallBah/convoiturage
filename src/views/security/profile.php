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
<div class="container">
    <div class="row">
        <div class="col-md-2 mt-5">

            <!-- Affichage des informations de l'utilisateur et de l'image -->
            <h4 class="">Information de l'utilisateur</h4>
            <?php if ($image) : ?>
                <img src="<?= url($image->chemin) ?>" alt="Image utilisateur" class="rounded-circle" style="width: 150px; height: 150px;">
            <?php else : ?>
                <img src="" alt="Image utilisateur" class="rounded-circle" style="width: 150px; height: 150px;">
                <span class="text-danger">Ajouter un image</span>
                
            <?php endif ?>
            <p>Nom: <?= $user->nomComplet ?></p>
            <p>Email: <?= $user->email ?></p>
            <p>Telephone: <?= $user->tel ?></p>
        </div>
        <div class="col-md-10">
            <h2 class="text-center pt-5">Modifier Profil</h2>
            <div class="card">
                <div class="container mb-5 mt-5">
                    <form action="" method="post" enctype="multipart/form-data">
                        <label for="telephone">Telephone</label>
                        <input type="text" name="telephone" id="telephone" class="form-control">
                        <label for="oldPass">Ancien Mot de passe</label>
                        <input type="text" name="oldPass" id="oldPass" class="form-control">
                        <label for="password">Mot de passe</label>
                        <input type="text" name="password" id="password" class="form-control">
                        <label for="repassword">Confirmation</label>
                        <input type="text" name="repassword" id="repassword" class="form-control">
                        <label for="image">Image</label>
                        <input type="file" name="image[]" id="image" class="form-control" multiple>
                        <input class="btn btn-success" type="submit" value="Modifier">
                    </form>
                    <?= $profilForm ?>
                    <a href="/" class="btn btn-outline-primary mt-3">Acceuil</a>
                </div>
            </div>
        </div>"
    </div>
</div>

</div>