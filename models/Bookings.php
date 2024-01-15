<?php

class Bookings extends Model
{
    public function insertReservation($chambreId, $client_id, $dateDebut, $dateFin, $dateCreation): void
    {
        $query = Database::getInstance()->prepare('INSERT INTO ' . $this->table . ' (chambre_id, client_id, date_debut, date_fin, date_creation) VALUES (:chambre_id, :client_id, :date_debut, :date_fin, :date_creation)');
        $query->execute([
            'chambre_id' => $chambreId,
            'client_id' => $client_id,
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'date_creation' => $dateCreation
        ]);
    }

    public function getValidReservationsByChambreId($chambreId): ?array
    {
        $currentDate = date('Y-m-d');

        $query = Database::getInstance()->prepare('SELECT * FROM ' . $this->table . ' WHERE chambre_id = :chambre_id AND date_fin > :current_date');
        $query->execute([
            'chambre_id' => $chambreId,
            'current_date' => $currentDate,
        ]);

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

    public function clearOldReservations(): void
    {
        $currentDate = date('Y-m-d');

        $query = Database::getInstance()->prepare('DELETE FROM ' . $this->table . ' WHERE date_fin <= :current_date');
        $query->execute([
            'current_date' => $currentDate,
        ]);
    }

    public function getLastReservationWithClientAndChambre(): ?array
    {
        $query = Database::getInstance()->prepare('
        SELECT 
            bookings.*,
            clients.nom AS client_nom,
            clients.email AS client_email,
            chambres.numero_chambre,
            chambres.hotel_id,
            chambres.prix,
            chambres.description AS chambre_description,
            chambres.photo AS chambre_photo,
            hotels.nom AS hotel_nom
        FROM ' . $this->table . '
        INNER JOIN clients ON bookings.client_id = clients.id
        INNER JOIN chambres ON bookings.chambre_id = chambres.id
        INNER JOIN hotels ON chambres.hotel_id = hotels.id
        ORDER BY bookings.id DESC
        LIMIT 1
    ');
        $query->execute();

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return $result ? $result : null;
    }

}