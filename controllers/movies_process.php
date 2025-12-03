<?php
require_once 'config/db.php';
require_once 'includes/header.php';

// Filter Logic
$where_clauses = ["status = 'now_showing'"];

if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $where_clauses[] = "title LIKE '%$search%'";
}

if (isset($_GET['genre']) && !empty($_GET['genre'])) {
    $genre = $conn->real_escape_string($_GET['genre']);
    $where_clauses[] = "genre LIKE '%$genre%'";
}

if (isset($_GET['language']) && !empty($_GET['language'])) {
    $language = $conn->real_escape_string($_GET['language']);
    $where_clauses[] = "language = '$language'";
}

$where_sql = "";
if (count($where_clauses) > 0) {
    $where_sql = "WHERE " . implode(" AND ", $where_clauses);
}
