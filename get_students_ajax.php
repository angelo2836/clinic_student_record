<?php
header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "clinic");

if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection failed']));
}

$limit = 20;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$page = max($page, 1);
$search = trim($_GET['search'] ?? '');
$offset = ($page - 1) * $limit;

$whereSql = "";
$params = [];
$types = "";

if ($search !== "") {
    $whereSql = " WHERE stud_id LIKE ? OR name LIKE ? OR program LIKE ?";
    $searchTerm = "%" . $search . "%";
    $params = [$searchTerm, $searchTerm, $searchTerm];
    $types = "sss";
}

$sql = "SELECT * FROM student" . $whereSql . " LIMIT ? OFFSET ?";
$stmt = $conn->prepare($sql);

if ($search !== "") {
    $types .= "ii";
    $params[] = $limit;
    $params[] = $offset;
    $stmt->bind_param($types, ...$params);
} else {
    $stmt->bind_param("ii", $limit, $offset);
}

$stmt->execute();
$result = $stmt->get_result();

$countSql = "SELECT COUNT(*) AS total FROM student" . $whereSql;
$countStmt = $conn->prepare($countSql);

if ($search !== "") {
    $countStmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
}

$countStmt->execute();
$totalResult = $countStmt->get_result();
$totalRow = $totalResult->fetch_assoc();
$totalPages = max(1, ceil($totalRow['total'] / $limit));

if ($page > $totalPages) {
    $page = $totalPages;
}

$rows = [];
while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

echo json_encode([
    'rows' => $rows,
    'page' => $page,
    'totalPages' => $totalPages,
    'offset' => $offset,
    'hasResults' => count($rows) > 0,
    'search' => $search
]);

$stmt->close();
$countStmt->close();
$conn->close();
?>
