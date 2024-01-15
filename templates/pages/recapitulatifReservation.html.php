<?php
$reservationId = filter_input(INPUT_GET, 'reservation_id', FILTER_VALIDATE_INT);

if ($reservationId > 0) {
    $bookingsModel = new Bookings();
    $reservationDetails = $bookingsModel->getLastReservationWithClientAndChambre();
    $photoChambre = $reservationDetails["chambre_photo"];
    $photoChambre = preg_replace('/\x{EF}\x{BB}\x{BF}/', '', urldecode($photoChambre));

    if ($reservationDetails && is_array($reservationDetails)) {
        ?>
        <div class="container mt-5">
            <div class="alert alert-success text-center" role="alert">
                <h4 class="alert-heading">Merci pour votre réservation !</h4>
                <p>Nous espérons que votre séjour sera agréable. N'hésitez pas à revenir vers nous pour de futures réservations. Bon séjour !</p>
            </div>
            <div class="card border-dark">
                <div class="card-header border-dark">
                    <h2 class="text-center">Récapitulatif de la Réservation</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card border-dark">
                                <div class="card-body">
                                    <p class="card-text"><strong>Nom du Client
                                            :</strong> <?= $reservationDetails['client_nom']; ?></p>
                                    <p class="card-text"><strong>Email du Client
                                            :</strong> <?= $reservationDetails['client_email']; ?></p>
                                    <p class="card-text"><strong>Nom de l'Hôtel
                                            :</strong> <?= $reservationDetails['hotel_nom']; ?></p>
                                    <p class="card-text"><strong>Numéro de Chambre
                                            :</strong> <?= $reservationDetails['numero_chambre']; ?></p>
                                    <p class="card-text"><strong>Date de Début
                                            :</strong> <?= $reservationDetails['date_debut']; ?></p>
                                    <p class="card-text"><strong>Date de Fin
                                            :</strong> <?= $reservationDetails['date_fin']; ?></p>
                                    <p class="card-text"><strong>Prix :</strong> <?= $reservationDetails['prix']; ?> €
                                        la nuit</p>
                                    <p class="card-text mb-3"><strong>Description
                                            :</strong> <?= $reservationDetails['chambre_description']; ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <img src="../images/chambres/<?= $photoChambre ?>" alt="<?= $photoChambre; ?>"
                                 class="img-fluid rounded shadow">
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <a href='/index.php' class='btn btn-outline-dark mx-auto mt-3'>
                            Retour à l'accueil
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <?php
    } else {
        echo "La réservation avec l'ID $reservationId n'a pas été trouvée.";
    }
} else {
    echo "ID de réservation invalide.";
}