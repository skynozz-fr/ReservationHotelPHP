<?php

class Chambres extends Model
{
    public function getChambreByHotelId(int $id): array
    {
        $query = Database::getInstance()->prepare('SELECT * FROM ' . $this->table . ' WHERE hotel_id = :id');
        $query->execute(['id' => $id]);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countChambresDisponiblesByHotelId(int $id): int
    {
        $query = Database::getInstance()->prepare('
        SELECT COUNT(*) 
        FROM ' . $this->table . ' AS c
        LEFT JOIN bookings AS b ON c.id = b.chambre_id
        WHERE c.hotel_id = :id AND (b.date_fin IS NULL OR b.date_fin < CURRENT_DATE)
    ');

        $query->execute(['id' => $id]);
        return $query->fetchColumn();
    }

    public function trierHotelsParChambresDisponibles($hotels)
    {
        usort($hotels, function ($a, $b) {
            $chambresDisponiblesA = $this->countChambresDisponiblesByHotelId($a["id"]);
            $chambresDisponiblesB = $this->countChambresDisponiblesByHotelId($b["id"]);

            return $chambresDisponiblesB - $chambresDisponiblesA;
        });

        return $hotels;
    }

}