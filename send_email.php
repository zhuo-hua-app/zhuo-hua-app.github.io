<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    $to = "liuchimo@outlook.com";
    $subject = "新联系表单提交";
    $body = "姓名: $name\n邮箱: $email\n留言:\n$message";
    $headers = "From: no-reply@yourdomain.com"; // 替换为你的域名

    if (mail($to, $subject, $body, $headers)) {
        echo "邮件发送成功！";
    } else {
        echo "邮件发送失败，请重试。";
    }
}
?>