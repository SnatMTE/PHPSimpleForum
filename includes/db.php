<?php

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to database: " . $e->getMessage());
}

function fetchData($query, $pdo, $params = []) {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $data = $stmt->fetchAll();
    return $data;
}

function executeQuery($query, $pdo, $params = []) {
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
}

?>