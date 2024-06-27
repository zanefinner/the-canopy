<?php

namespace Model;

use PDO;

class Accounts
{
    protected $db;

    public function __construct($database)
    {
        $this->db = $database;
    }

    public function getAllUsers()
    {
        $link = $this->db->openDbConnection();

        $result = $link->query('SELECT alias, name FROM accounts ORDER BY id');

        $music = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $music[] = $row;
        }
        $this->db->closeDbConnection($link);


        return $music;
    }

    public function getUserById($id)
    {
        $link = $this->db->openDbConnection();

        $query = 'SELECT * FROM accounts WHERE  id=:id';
        $statement = $link->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $this->db->closeDbConnection($link);
        return $row;
    }
    public function getIdByEmail($email)
    {
        $link = $this->db->openDbConnection();

        $query = 'SELECT * FROM accounts WHERE  email=:email';
        $statement = $link->prepare($query);
        $statement->bindValue(':email', $email, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $this->db->closeDbConnection($link);
        return $row;
    }
    public function authenticate($input)
    {
        $link = $this->db->openDbConnection();

        $query = "SELECT * FROM accounts WHERE email=:email";
        $statement = $link->prepare($query);
        $statement->bindValue(':email', $input['email']);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $this->db->closeDbConnection($link);

        // Verify the hashed password
        if ($row && password_verify($input['password'], $row['password'])) {
            return $row;
        } else {
            return false;
        }
    }
    public function insert($input)
    {
        $link = $this->db->openDbConnection($input);

        // Hash the password using bcrypt
        $hashedPassword = password_hash($input['password'], PASSWORD_BCRYPT);

        $query = 'INSERT INTO accounts (name, alias, email, password) VALUES (:name, :alias, :email, :password)';
        $statement = $link->prepare($query);
        $statement->bindValue(':name', $input['name'], PDO::PARAM_STR);
        $statement->bindValue(':alias', $input['alias'], PDO::PARAM_STR);
        $statement->bindValue(':email', $input['email'], PDO::PARAM_STR);
        $statement->bindValue(':password', $hashedPassword, PDO::PARAM_STR); // Use the hashed password
        $statement->execute();

        $this->db->closeDbConnection($link);
    }


    public function update($id)
    {
        $link = $this->db->openDbConnection();

        $query = "UPDATE music SET nama = :nama, judul = :judul, album = :album, tahun = :tahun WHERE id = :id";
        $statement = $link->prepare($query);
        $statement->bindValue(':nama', $_POST['nama'], PDO::PARAM_STR);
        $statement->bindValue(':judul', $_POST['judul'], PDO::PARAM_STR);
        $statement->bindValue(':album', $_POST['album'], PDO::PARAM_STR);
        $statement->bindValue(':tahun', $_POST['tahun'], PDO::PARAM_STR);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $this->db->closeDbConnection($link);
    }

    public function deleteById($id)
    {
        $link = $this->db->openDbConnection();

        $query = "DELETE FROM accounts WHERE id = :id";
        $statement = $link->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $this->db->closeDbConnection($link);
    }
    public function getFollowing($id)
    {
        $link = $this->db->openDbConnection($input);
        $query = 'SELECT following FROM accounts WHERE  id=:id';
        $statement = $link->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_STR);
        $statement->execute();
        $out = $statement->fetch(PDO::FETCH_ASSOC);
        $this->db->closeDbConnection($link);
        return $out;
    }
    public function setFollowing($id, $in1)
    {
        $link = $this->db->openDbConnection($input);

        'UPDATE accounts SET following = :in1 
        -> WHERE tutorial_id = :id';
        $statement = $link->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_STR);
        $statement->bindValue(':in1', $in1, PDO::PARAM_STR);
        $statement->execute();
        $out = $statement->fetch(PDO::FETCH_ASSOC);
        $this->db->closeDbConnection($link);
        return $out;
    }
}
