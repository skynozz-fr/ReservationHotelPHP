<?php

class Clients extends Model
{
    public function getClientIdByEmail($email): ?int
    {
        $query = Database::getInstance()->prepare('SELECT id FROM ' . $this->table . ' WHERE email = :email');
        $query->execute([
            'email' => $email
        ]);

        $result = $query->fetch(PDO::FETCH_ASSOC);

        return $result ? intval($result['id']) : null;
    }

    public function insertClient($nom, $email): int
    {
        $existingClientId = $this->getClientIdByEmail($email);

        if ($existingClientId !== null) {
            return $existingClientId;
        }

        $query = Database::getInstance()->prepare('INSERT INTO ' . $this->table . ' (nom, email) VALUES (:nom, :email)');
        $query->execute([
            'nom' => $nom,
            'email' => $email
        ]);

        return intval(Database::getInstance()->lastInsertId());
    }

}