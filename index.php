<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>21ch</title>
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
        form {
            margin-bottom: 20px;
        }
        form input[type="text"] {
            padding: 8px;
            width: 300px;
        }
        form input[type="submit"] {
            padding: 8px 20px;
            background-color: #555;
            color: #fff;
            border: none;
            cursor: pointer;
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
            <h2>ようこそ！</h2>
            <p>ここにサイトの説明やコンテンツが入ります。</p>

            <!-- トピック追加フォーム -->
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="topic_name">トピック名:</label>
                <input type="text" id="topic_name" name="topic_name" required>
                <input type="submit" value="トピック追加">
            </form>

            <h3>トピック一覧</h3>
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

                // chat_tableの作成
                $sql = "CREATE TABLE IF NOT EXISTS chat_table (
                    topic_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    topic_name VARCHAR(255) NOT NULL UNIQUE,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";

                if ($conn->query($sql) === FALSE) {
                    echo "Error creating table: " . $conn->error;
                }

                // トピック追加処理
                if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["topic_name"])) {
                    $topic_name = $conn->real_escape_string($_POST["topic_name"]);

                    // トピックがすでに存在するか確認
                    $check_sql = "SELECT topic_id FROM chat_table WHERE topic_name = '$topic_name'";
                    $check_result = $conn->query($check_sql);

                    if ($check_result->num_rows > 0) {
                        echo "<p class='error'>このトピックはすでに存在します。</p>";
                    } else {
                        // トピック追加
                        $sql = "INSERT INTO chat_table (topic_name) VALUES ('$topic_name')";
                        
                        if ($conn->query($sql) === TRUE ) {
                            echo "<p class='success'>トピックスを追加しました！</p>";
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    }
                }

                // トピックの取得
                $sql = "SELECT topic_id, topic_name FROM chat_table";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // データの出力
                    echo "<ul>";
                    while($row = $result->fetch_assoc()) {
                        echo "<li><a href='topic_detail.php?id=" . htmlspecialchars($row["topic_id"]) . "' class='topic-link'>" . htmlspecialchars($row["topic_name"]) . "</a></li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>トピックスがありません。</p>";
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