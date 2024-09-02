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
                $sql = "SELECT topic_name FROM chat_table WHERE topic_id = $topic_id";
                $result = $conn->query($sql);
                if (!$result) {
                    die("SQLエラー: " . $conn->error);
                }

                if ($result->num_rows > 0) {
                    // トピックの表示
                    $row = $result->fetch_assoc();
                    echo "<h2>トピックス：" . htmlspecialchars($row["topic_name"]) . "</h2>";
                } else {
                    echo "<p>トピックが見つかりませんでした。</p>";
                }

                // コメントの処理
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $user_name = isset($_POST['user_name']) ? htmlspecialchars($_POST['user_name'], ENT_QUOTES, 'UTF-8') : '';
                    $comment = isset($_POST['comment']) ? htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8') : '';

                    if ($user_name && $comment) {
                        $stmt = $conn->prepare("INSERT INTO comments (topic_id, user_name, comment) VALUES (?, ?, ?)");
                        $stmt->bind_param("iss", $topic_id, $user_name, $comment);
                        if ($stmt->execute()) {
                            echo "<p>コメントが投稿されました。</p>";
                        } else {
                            echo "<p>コメントの投稿に失敗しました。</p>";
                        }
                        $stmt->close();
                    }
                }

                // コメントの表示
                $sql = "SELECT user_name, comment, created_at FROM comments WHERE topic_id = $topic_id ORDER BY created_at DESC";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    echo '<div class="comments">';
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="comment">';
                        echo '<strong>' . htmlspecialchars($row['user_name']) . '</strong> ';
                        echo '<span>[' . htmlspecialchars($row['created_at']) . ']</span>';
                        echo '<p>' . htmlspecialchars($row['comment']) . '</p>';
                        echo '</div>';
                    }
                    echo '</div>';
                } else {
                    echo '<p>コメントはまだありません。</p>';
                }

                // 接続を閉じる
                $conn->close();
            ?>

            <!-- コメント投稿フォーム -->
            <div class="comment-form">
                <h3>コメントを投稿する</h3>
                <form method="post" action="">
                    <input type="text" name="user_name" placeholder="名前" required>
                    <textarea name="comment" placeholder="コメント" rows="4" required></textarea>
                    <input type="submit" value="投稿">
                </form>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 21ch チームひろゆき</p>
    </footer>
</body>
</html>
