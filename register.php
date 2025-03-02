<?php
$servername = "ohzwv.h.filess.io";
$username = "ZHDATA_treatedsix";
$password = "68b881500964eed56fd29e4fdcda75c35c421ce9";
$dbname = "ZHDATA_treatedsix";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);

// 检查连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $regUsername = $_POST['regUsername'];
    $regPassword = $_POST['regPassword'];
    $regEmail = $_POST['regEmail'];

    // 生成20位UUID
    $uuid = sprintf('%04x%04x%04x%04x%04x%04x%04x%04x',
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),
        mt_rand(0, 0xffff),
        mt_rand(0, 0x0fff) | 0x4000,
        mt_rand(0, 0x3fff) | 0x8000,
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );

    // 检查用户名是否已存在
    $stmt = $conn->prepare("SELECT * FROM LoginData WHERE Username = ?");
    $stmt->bind_param("s", $regUsername);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "注册失败: 用户名已存在";
    } else {
        // 插入新用户数据
        $stmt = $conn->prepare("INSERT INTO LoginData (Username, UUID, Password, Email) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $regUsername, $uuid, $regPassword, $regEmail);

        if ($stmt->execute()) {
            echo "注册成功!";
        } else {
            echo "注册失败: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>