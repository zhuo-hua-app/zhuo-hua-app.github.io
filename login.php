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
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 查询用户数据
    $stmt = $conn->prepare("SELECT * FROM LoginData WHERE Username = ? AND Password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "登录成功!";
        // 重定向到主页或其他页面
        header("Location: index.html");
        exit();
    } else {
        echo "登录失败: 用户名或密码错误";
    }

    $stmt->close();
    $conn->close();
}
?>