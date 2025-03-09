<?php
header('Content-Type: application/json');

$servername = "ohzwv.h.filess.io";
$username = "ZHDATA_treatedsix";
$password = "b290a105250fb31";
$dbname = "ZHDATA_treatedsix";

// 创建数据库连接
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => '连接失败: ' . $conn->connect_error]));
}

// 获取 POST 数据
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// 验证数据
if (empty($username) || empty($password)) {
    die(json_encode(['success' => false, 'message' => '用户名和密码不能为空']));
}

// 查询数据库
$sql = "SELECT * FROM dt WHERE user = ? AND pass = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die(json_encode(['success' => false, 'message' => 'SQL 准备失败: ' . $conn->error]));
}

$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['success' => true, 'message' => '登录成功']);
} else {
    echo json_encode(['success' => false, 'message' => '用户名或密码错误']);
}

$stmt->close();
$conn->close();
?>