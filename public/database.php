<?php
class Database
{ 
    private $db;

    function __construct()
    {
        $this->db = new SQLite3("../db.db");
        $this->db->exec("
        CREATE TABLE IF NOT EXISTS urls
        (
            original_link TEXT NOT NULL,
            short_path TEXT NOT NULL
        );
        ");
    }

    function checkPathIsUnique($path) {
        $sql = $this->db->prepare("SELECT short_path FROM urls WHERE short_path=:path;");
        $sql->bindValue(':path', $path, SQLITE3_TEXT);
        
        $result = $this->db->querySingle($sql->getSQL(true)); 
        return $result == null;
    }

    function newUrl($link, $path) {
        $sql = $this->db->prepare("INSERT INTO urls(original_link, short_path) VALUES (:link, :path)");
        $sql->bindValue(':link', $link, SQLITE3_TEXT);
        $sql->bindValue(':path', $path, SQLITE3_TEXT);

        $result = $sql->execute();
        return $this->db->lastInsertRowID();
    }

    function getLinkByPath($path)
    {
        $sql = $this->db->prepare("SELECT original_link FROM urls WHERE short_path=:path LIMIT 1");
        $sql->bindValue(':path',$path,SQLITE3_TEXT);
        
        $result = $this->db->querySingle($sql->getSQL(true)); 
        return $result;
    }
     
    function __destruct()
    {
        $this->db->close();
    }
}
?>