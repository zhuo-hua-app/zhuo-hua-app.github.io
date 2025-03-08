<?php
$servername = "ohzwv.h.filess.io";
$username = "ZHDATA_treatedsix";
$password = "b290a105250fb31";
$dbname = "ZHDATA_treatedsix";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => '连接失败: ' . $conn->connect_error]));
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM LoginData WHERE Username = ? AND Password = ?";
$stmt = $conn->prepare($sql);
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