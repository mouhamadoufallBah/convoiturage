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
<div class="container mb-5">
    <h1 class="text-center pt-5">Se connecter</h1>
    <div class="card">
        <div class="container mb-5 mt-5">
            <?= $loginForm ?>
            <a href="/security/register" class="btn btn-outline-primary mt-3">S'inscrire</a>
        </div>
    </div>
</div>