<?php
$hotelId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($hotelId <= 0): ?>
    <p class='text-center mt-4'>Identifiant d'hôtel invalide.</p>
    <?php
    exit;
endif;

$hotelDetails = (new Hotels)->getOneById($hotelId);

if ($hotelDetails):
    $photoHotel = $hotelDetails["photo"];
    $photoHotel = preg_replace('/\x{EF}\x{BB}\x{BF}/', '', urldecode($photoHotel));
    ?>
    <div class='container mt-4'>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="/" class="link-offset-2 link-dark link-underline-secondary link-underline-opacity-75">Accueil</a></li>
                <li class="breadcrumb-item"><a href="/hotels.php" class="link-offset-2 link-dark link-underline-secondary link-underline-opacity-75">Nos hôtels</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= $hotelDetails['nom'] ?></li>
            </ol>
        </nav>
        <div class='row justify-content-center'>
            <div class='col-md-6 text-center'>
                <figure class='figure'>
                    <img src='../images/hotels/<?= $photoHotel ?>' class='figure-img img-fluid rounded shadow'
                         alt='Photo de <?= $hotelDetails['nom'] ?>'>
                    <figcaption class='figure-caption text-start mt-3'>
                        <h4 class='fw-bold text-uppercase'><?= $hotelDetails['nom'] ?></h4>
                    </figcaption>
                </figure>
            </div>
            <div class='col-md-6 bg-light text-dark rounded p-4'>
                <h3 class='fw-bold mb-5'>Informations sur l'hôtel :</h3>
                <p class="mb-4"><strong>Adresse :</strong> <?= $hotelDetails["adresse"] ?></p>
                <p class="mb-4"><strong>Code postal :</strong> <?= $hotelDetails["code_postal"] ?></p>
                <p class="mb-4"><strong>Ville :</strong> <?= $hotelDetails["ville"] ?></p>
                <p class="mb-4"><strong>Description :</strong> <?= $hotelDetails["description"] ?></p>
                <p class="mb-4"><strong>Évaluation :</strong>
                    <?php
                    $nombreEtoiles = $hotelDetails["etoiles"];

                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $nombreEtoiles) {
                            echo '<i class="fa-solid fa-star" style="color: yellowgreen"></i>';
                        } else {
                            echo '<i class="fa-regular fa-star" style="color: yellowgreen"></i>';
                        }
                    }
                    ?>
                </p>
            </div>
        </div>

        <?php
        $chambreDetails = (new Chambres)->getChambreByHotelId($hotelId);

        if ($chambreDetails):
            ?>
            <div class='mt-4'>
                <h3 class='text-center fw-bold'>Chambres disponibles :</h3>
                <div class='row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4'>
                    <?php foreach ($chambreDetails as $chambre):
                        $photoChambre = $chambre["photo"];
                        $photoChambre = preg_replace('/\x{EF}\x{BB}\x{BF}/', '', urldecode($photoChambre));
                        $chambreId = $chambre["id"];
                        $validReservations = (new Bookings)->getValidReservationsByChambreId($chambreId);
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 border-0 shadow">
                                <img src="../images/chambres/<?= $photoChambre ?>" class="card-img-top"
                                     alt="Photo de la chambre <?= $chambre['numero_chambre'] ?>">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-start fw-bolder mb-4">Chambre
                                        n°<?= $chambre['numero_chambre'] ?></h5>
                                    <p class="card-text mb-4"><?= $chambre['description'] ?></p>
                                    <p class="card-text text-end fw-semibold"><?= $chambre['prix'] ?> € la nuit</p>

                                    <?php if ($validReservations): ?>
                                        <p class="card-text mb-4">
                                            <span class="badge text-bg-danger p-2">Indisponible jusqu'au <?= $validReservations[0]["date_fin"] ?></span>
                                        </p>
                                        <button class="btn btn-outline-danger btn-sm" disabled>
                                            Chambre déjà réservée
                                        </button>
                                    <?php else: ?>
                                        <p class="card-text mb-4">
                                            <span class="badge text-bg-success p-2">Disponible</span>
                                        </p>
                                        <a href='/reservation.php?chambre_id=<?= $chambreId ?>'
                                           class='btn btn-outline-dark btn-sm'>
                                            Réserver cette chambre
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else: ?>
            <p class='mt-4 text-center'>Aucune chambre disponible pour cet hôtel.</p>
        <?php endif; ?>
    </div>
<?php else: ?>
    <p class='mt-4 text-center'>L'hôtel demandé n'a pas été trouvé.</p>
<?php endif; ?>