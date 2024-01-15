<?php

const ALERT_DANGER = 'alert-danger';
const ALERT_SUCCESS = 'alert-success';
const ERROR_MESSAGE = "Une erreur s'est produite lors de la soumission du formulaire.";
const SUCCESS_MESSAGE = "Réservation effectuée avec succès ! Redirection vers le récapitulatif en cours... <i class='fa-solid fa-spinner fa-spin'></i>";
const DATE_ERROR_MESSAGE = "Tu ne peux pas réserver si ta date de fin est antérieure à ta date de début :)";
const INFO_MESSAGE = "Veuillez fournir toutes les informations nécessaires.";

$alertClass = ALERT_DANGER;
$message = ERROR_MESSAGE;
$goBackLink = '<a href="javascript:history.go(-1)" class="btn btn-outline-dark mx-5">Retour</a>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reservationForm = new ReservationForm();

    $reservationForm->setNom($_POST['nom'] ?? '');
    $reservationForm->setEmail($_POST['email'] ?? '');
    $reservationForm->setChambreId($_POST['chambre_id'] ?? 0);
    $reservationForm->setDateDebut($_POST['date_debut'] ?? '');
    $reservationForm->setDateFin($_POST['date_fin'] ?? '');
    $dateCreation = date('Y-m-d H:i:s');

    if (
        $reservationForm->getNom() !== '' &&
        filter_var($reservationForm->getEmail(), FILTER_VALIDATE_EMAIL) &&
        $reservationForm->getChambreId() > 0 &&
        $reservationForm->getDateDebut() !== '' &&
        $reservationForm->getDateFin() !== ''
    ) {
        if (strtotime($reservationForm->getDateFin()) > strtotime($reservationForm->getDateDebut())) {
            $bookingsModel = new Bookings();
            $clientModel = new Clients();

            $nom = $reservationForm->getNom();
            $email = $reservationForm->getEmail();
            $chambreId = $reservationForm->getChambreId();
            $dateDebut = $reservationForm->getDateDebut();
            $dateFin = $reservationForm->getDateFin();

            $clientId = $clientModel->insertClient($nom, $email);

            $bookingsModel->insertReservation($chambreId, $clientId, $dateDebut, $dateFin, $dateCreation);

            $alertClass = ALERT_SUCCESS;
            $message = SUCCESS_MESSAGE;

            $reservationId = Database::getInstance()->lastInsertId();

            header("Refresh: 4; URL=/recapitulatifReservation.php?reservation_id=$reservationId");

            echo "
            <div class='container mt-5'>
                <div class='alert $alertClass' role='alert'>
                    $message
                </div>
                <img src='../images/form_loading/loading.webp' alt='Image de chargement' class='img-fluid rounded'>
            </div>";
        } else {
            $alertClass = ALERT_DANGER;
            $message = DATE_ERROR_MESSAGE;

            echo "
            <div class='container mt-5'>
                <div class='alert $alertClass' role='alert'>
                    $message $goBackLink
                </div>
            </div>";
        }
    } else {
        $alertClass = ALERT_DANGER;
        $message = INFO_MESSAGE;
    }
}