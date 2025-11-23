require_once __DIR__ . '/../../db.php';
header('Content-Type: application/json');

$id = intval($_GET['id'] ?? 0);
if (!$id) { echo json_encode(['error' => 'ID inválido']); exit; }

$stmt = $pdo->prepare("SELECT codigo_postal FROM localidades WHERE id = ?");
$stmt->execute([$id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($data);
