<?php

class Model
{
    protected string $table;

    public function __construct()
    {
        $this->table = strtolower(get_class($this));
    }

    public function getAll(): array
    {
        $query = Database::getInstance()->prepare('SELECT * FROM ' . $this->table);
        $query->execute();

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOneById(int $id): array
    {
        $query = Database::getInstance()->prepare('SELECT * FROM ' . $this->table . ' WHERE id = :id');
        $query->execute(['id' => $id]);

        return $query->fetch(PDO::FETCH_ASSOC);
    }

}