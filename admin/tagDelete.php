<?php
session_start();
$filepath = dirname(__FILE__);

include "../database/db_connection.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {

    $id = trim($_GET['id']);

    $sql = "DELETE FROM tag WHERE id=:id";

    $stmp = $conn->prepare($sql);
    
    $stmp->bindParam(':id', $id, PDO::PARAM_INT);
    
    $stmp->execute();

    $_SESSION['success'] = 'Tag delete successfully';

    header('location:tag.php');
}
