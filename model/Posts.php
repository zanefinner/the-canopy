<?php namespace Model; use PDO;
class Posts{
    protected $db;

    public function __construct($database)
    {
        $this->db = $database;
    }
    public function getPostsByUsersYouFollow($currentUserId) {
        $link = $this->db->openDbConnection();

        // Fetch the accounts that the current user follows
        $query = 'SELECT following FROM accounts WHERE id = :currentUserId';
        $statement = $link->prepare($query);
        $statement->bindParam(':currentUserId', $currentUserId, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$result || empty($result['following'])) {
            return []; // Return empty array if no accounts are followed
        }

        $followingIds = json_decode($result['following'], true);

        // Prepare placeholders for IN clause
        $placeholders = implode(',', array_fill(0, count($followingIds), '?'));

        // Query to fetch posts from accounts that the current user follows
        $query = "SELECT p.id, p.content, p.created_at, a.alias as author_alias
                  FROM posts p
                  INNER JOIN accounts a ON p.author = a.id
                  WHERE p.author IN ($placeholders)
                  ORDER BY p.id DESC";

        $statement = $link->prepare($query);
        $statement->execute($followingIds); // Pass array of IDs directly
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);

        $this->db->closeDbConnection($link);

        return $rows;
    }
    
    

    public function getPostsByUser($author)
    {
        $link = $this->db->openDbConnection();

        $query = 'SELECT * FROM posts WHERE  author=:author ORDER BY id DESC';
        $statement = $link->prepare($query);
        $statement->bindValue(':author', $author, PDO::PARAM_INT);
        $statement->execute();
        $row = $statement->fetchAll(PDO::FETCH_ASSOC);
        $this->db->closeDbConnection($link);
        return $row;
    }
    public function insert($content, $author)
    {
        $link = $this->db->openDbConnection();

        $query = 'INSERT INTO posts (content, author) VALUES (:content, :author)';
        $statement = $link->prepare($query);
        $statement->bindValue(':content', $content, PDO::PARAM_STR);
        $statement->bindValue(':author', $author, PDO::PARAM_STR);
        $statement->execute();

        $this->db->closeDbConnection($link);
    }
    
}
