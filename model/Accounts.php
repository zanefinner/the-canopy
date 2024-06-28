<?php

namespace Model;

use PDO;

class Accounts {
    protected $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function getAllUsers() {
        $link = $this->db->openDbConnection();

        $result = $link->query('SELECT alias, name FROM accounts ORDER BY id');

        $music = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $music[] = $row;
        }
        $this->db->closeDbConnection($link);

        return $music;
    }

    public function getUserById($id) {
        $link = $this->db->openDbConnection();

        $query = 'SELECT * FROM accounts WHERE id=:id';
        $statement = $link->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $this->db->closeDbConnection($link);
        return $row;
    }

    public function getIdByEmail($email) {
        $link = $this->db->openDbConnection();

        $query = 'SELECT * FROM accounts WHERE email=:email';
        $statement = $link->prepare($query);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        $this->db->closeDbConnection($link);
        return $row;
    }

    public function authenticate($input) {
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

    public function insert($input) {
        $link = $this->db->openDbConnection();

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

    public function update($id) {
        $link = $this->db->openDbConnection();

        $query = "UPDATE accounts SET name = :name, alias = :alias, email = :email, password = :password WHERE id = :id";
        $statement = $link->prepare($query);
        $statement->bindValue(':name', $_POST['name'], PDO::PARAM_STR);
        $statement->bindValue(':alias', $_POST['alias'], PDO::PARAM_STR);
        $statement->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $statement->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $this->db->closeDbConnection($link);
    }

    public function deleteById($id) {
        $link = $this->db->openDbConnection();

        $query = "DELETE FROM accounts WHERE id = :id";
        $statement = $link->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();

        $this->db->closeDbConnection($link);
    }

    public function getFollowing($id) {
        $link = $this->db->openDbConnection();

        $query = 'SELECT following FROM accounts WHERE id = :id';
        $statement = $link->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $out = $statement->fetch(PDO::FETCH_ASSOC);

        $this->db->closeDbConnection($link);
        return $out ? $out['following'] : '[]'; // return an empty JSON array if no data found
    }

    public function setFollowing($id, $in1) {
        $link = $this->db->openDbConnection();

        $query = 'UPDATE accounts SET following = :in1 WHERE id = :id';
        $statement = $link->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT); // Change to integer type
        $statement->bindValue(':in1', $in1, PDO::PARAM_STR); // Change to string type
        $statement->execute();

        $this->db->closeDbConnection($link);
    }
}
?>
