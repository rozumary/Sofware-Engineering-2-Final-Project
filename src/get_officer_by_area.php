<?php
include './includes/config.inc.php';

$municipality = $_GET['municipality'] ?? '';

if ($municipality) {
    $query = "SELECT o.name 
              FROM area_assignment a
              JOIN officers o ON a.officer_id = o.officer_id
              WHERE a.municipality = :municipality";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':municipality', $municipality);
    $stmt->execute();
    $officers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output all officer names as a comma-separated string
    if ($officers) {
        echo htmlspecialchars(implode(', ', array_column($officers, 'name')));
    } else {
        echo '';
    }
} else {
    echo '';
}