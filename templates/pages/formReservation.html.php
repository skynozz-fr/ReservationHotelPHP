<?php
$chambre = (new Chambres)->getOneById($_GET['chambre_id']);
$photoChambre = $chambre["photo"];
$photoChambre = preg_replace('/\x{EF}\x{BB}\x{BF}/', '', urldecode($photoChambre));
$hotelName = (new Hotels)->getOneById($chambre['hotel_id'])['nom'];
?>

<div class="container mt-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="/" class="link-offset-2 link-dark link-underline-secondary link-underline-opacity-75">Accueil</a></li>
            <li class="breadcrumb-item"><a href="/hotels.php" class="link-offset-2 link-dark link-underline-secondary link-underline-opacity-75">Nos hôtels</a></li>
            <li class="breadcrumb-item"><a href="/hotel.php?id=<?= $chambre['hotel_id'] ?>" class="link-offset-2 link-dark link-underline-secondary link-underline-opacity-75"><?= $hotelName ?></a></li>
            <li class="breadcrumb-item active" aria-current="page">Réservation</li>
        </ol>
    </nav>
    <h2 class="mb-4">Réservez votre chambre <i class="fa-solid fa-bed"></i></h2>
    <form action="/resultReservation.php" method="post" class="bg-white p-4 rounded shadow reservation-form">
        <div class="row">
            <div class="col-md-6">
                <figure class='figure'>
                    <img src='../images/chambres/<?= $photoChambre ?>' class='figure-img img-fluid shadow rounded'
                         alt='Photo de <?= $chambre['numero_chambre'] ?>'>
                    <figcaption class='figure-caption text-start mt-2'>
                        <strong><?= $chambre['prix'] ?> € la nuit</strong>
                        <p class="fst-italic mt-2"><?= $chambre["description"] ?></p>
                    </figcaption>
                </figure>
            </div>
            <div class="col-md-6 reservation-details">
                <h2 class="mb-5">Réservation de la chambre n°<?= $chambre["numero_chambre"] ?></h2>

                <div class="form-group mb-4">
                    <label for="nom">Nom :</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>

                <div class="form-group mb-4">
                    <label for="email">Email :</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <input type="hidden" name="chambre_id"
                       value="<?= isset($_GET['chambre_id']) ? htmlspecialchars($_GET['chambre_id']) : ''; ?>">

                <div class="form-group mb-4">
                    <label for="date_debut">Date de début :</label>
                    <input type="date" class="form-control" id="date_debut" min="<?= date('Y-m-d') ?>" name="date_debut"
                           required>
                </div>

                <div class="form-group mb-4">
                    <label for="date_fin">Date de fin :</label>
                    <input type="date" class="form-control" id="date_fin" min="<?= date('Y-m-d') ?>" name="date_fin"
                           required>
                </div>

                <div class="form-group mb-5">
                    <label for="date_creation">Date de la réservation</label>
                    <input type="text" class="form-control" id="date_creation" name="date_creation"
                           value="<?= date('Y-m-d H:i:s'); ?>" readonly>
                </div>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="submit" class="btn btn-outline-dark mt-5">Réserver</button>
            </div>
        </div>
    </form>
</div>