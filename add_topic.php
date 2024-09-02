<?php
// データベース接続情報
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "21ch_db"; // 作成したデータベース名

// POSTで送られてきたデータを受け取る
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $topic_name = $_POST['topic_name'];

    // データベースに接続
    $conn = new mysqli($servername, $username, $password, $dbname);

    // 接続確認
    if ($conn->connect_error) {
        die("データベースに接続できませんでした: " . $conn->connect_error);
    }

    // トピックをデータベースに挿入するクエリ
    $sql = "INSERT INTO topics (topic_name) VALUES ('$topic_name')";

    if ($conn->query($sql) === TRUE) {
        echo "新しいトピックを追加しました";
    } else {
        echo "エラー: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
