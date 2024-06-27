<?php namespace Model; use PDO;
class Posts{
    protected $db;

    public function __construct($database)
    {
        $this->db = $database;
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
