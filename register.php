<?php
$servername = "ohzwv.h.filess.io";
$username = "ZHDATA_treatedsix";
$password = "b290a105250fb31";
$dbname = "ZHDATA_treatedsix";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['message' => '连接失败: ' . $conn->connect_error]));
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "INSERT INTO LoginData (Username, Email, Password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $email, $password);

if ($stmt->execute()) {
    echo json_encode(['message' => '注册成功']);
} else {
    echo json_encode(['message' => '注册失败: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>