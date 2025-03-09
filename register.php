<?php
header('Content-Type: application/json');

$servername = "ohzwv.h.filess.io";
$username = "ZHDATA_treatedsix";
$password = "b290a105250fb31";
$dbname = "ZHDATA_treatedsix";

// 创建数据库连接
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['message' => '连接失败: ' . $conn->connect_error]));
}

// 获取 POST 数据
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

// 验证数据
if (empty($username) || empty($password)) {
    die(json_encode(['message' => '用户名和密码不能为空']));
}

// 检查用户名是否已存在
$check_sql = "SELECT * FROM dt WHERE user = ?";
$check_stmt = $conn->prepare($check_sql);
if (!$check_stmt) {
    die(json_encode(['message' => 'SQL 准备失败: ' . $conn->error]));
}

$check_stmt->bind_param("s", $username);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    die(json_encode(['message' => '用户名已存在']));
}

$check_stmt->close();

// 插入数据到数据库
$sql = "INSERT INTO dt (user, pass) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die(json_encode(['message' => 'SQL 准备失败: ' . $conn->error]));
}

$stmt->bind_param("ss", $username, $password);

if ($stmt->execute()) {
    echo json_encode(['message' => '注册成功']);
} else {
    echo json_encode(['message' => '注册失败: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>