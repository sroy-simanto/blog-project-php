<?php
session_start();
$filepath = dirname(__FILE__);

include "../database/db_connection.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = trim($_GET['id']);

    /*select post image for delete */
    $sql = "SELECT * FROM posts WHERE id=:id";
    $selectStmt = $conn->prepare($sql);
    $selectStmt->bindParam(':id', $id, PDO::PARAM_INT);
    $selectStmt->execute();
    $row = $selectStmt->fetch(PDO::FETCH_OBJ);
    print_r($row);
    if (isset($row->image)){
        unlink($row->image);
    }
    /*Delete record*/
    try {
        $sql = "DELETE FROM posts WHERE id=:id";
        $deleteStmt = $conn->prepare($sql);
        $deleteStmt->bindParam(':id', $id, PDO::PARAM_INT);
        if ($deleteStmt->execute()) {           
            $_SESSION['success'] = "Post delete successfully";
            header("location:post.php");
        }
    }catch (PDOException $e) {
        die("ERROR: Could not prepare/execute query: $sql. " . $e->getMessage());
    }
}
