<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>トピック詳細</title>
    <style>
        /* CSSスタイルはここに記述する */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        nav {
            background-color: #444;
            padding: 10px 0;
            text-align: center;
        }
        nav a {
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
        }
        nav a:hover {
            background-color: #555;
        }
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        .container {
            max-width: 960px;
            margin: 0 auto;
            padding: 20px;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>21ch</h1>
    </header>
    <nav>
        <a href="index.php">ホーム</a>
        <a href="news.php">ニュース</a>
        <a href="latest.php">最新</a>
        <a href="blog.php">ブログ</a>
        <a href="contact.php">お問い合わせ</a>
    </nav>
    <div class="container">
        <div class="content">
            <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "21ch_db"; // データベース名を修正

                // データベースへの接続
                $conn = new mysqli($servername, $username, $password, $dbname);

                // 接続の確認
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // トピックIDの取得
                $topic_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

                // トピックの取得
                $sql = "SELECT topic_name, created_at FROM chat_table WHERE topic_id = $topic_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // トピックの表示
                    $row = $result->fetch_assoc();
                    echo "<h2>" . htmlspecialchars($row["topic_name"]) . "</h2>";
                    echo "<p>Created at: " . htmlspecialchars($row["created_at"]) . "</p>";
                } else {
                    echo "<p>トピックが見つかりませんでした。</p>";
                }

                // 接続を閉じる
                $conn->close();
            ?>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 21ch チームひろゆき</p>
    </footer>
</body>
</html>
