<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>トピック詳細</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
            /* position: absolute; */
            /* bottom: 0; */
            width: 100%;
            margin-top: auto;
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
        .comments {
            margin-top: 20px;
        }
        .comment {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
            position: relative;
        }
        .comment-form {
            margin-top: 20px;
        }
        .delete-btn {
            position: absolute;
            right: 0;
            top: 10px;
            background-color: #f00;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="wrapper">
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
                $dbname = "21ch"; // 使用するデータベース名

                // データベースへの接続
                $conn = new mysqli($servername, $username, $password, $dbname);

                // 接続の確認
                if ($conn->connect_error) {
                    die("接続失敗: " . $conn->connect_error);
                }

                // トピックIDの取得
                $topic_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

                // トピック名の取得
                $stmt = $conn->prepare("SELECT topic_name FROM chat_table WHERE topic_id=? LIMIT 1");
                $stmt->bind_param("i", $topic_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    // トピック名の表示
                    $row = $result->fetch_assoc();
                    echo "<h2>トピックス：" . htmlspecialchars($row["topic_name"]) . "</h2>";
                } else {
                    echo "<p>トピックが見つかりませんでした。</p>";
                }
                $stmt->close();

                // コメントの処理
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    if (isset($_POST['delete_id'])) {
                        // コメントの削除
                        $delete_id = intval($_POST['delete_id']);
                        $stmt = $conn->prepare("DELETE FROM chat WHERE ID = ?");
                        $stmt->bind_param("i", $delete_id);
                        if ($stmt->execute()) {
                            echo "<p>コメントが削除されました。</p>";
                        } else {
                            echo "<p>コメントの削除に失敗しました。</p>";
                        }
                        $stmt->close();
                    } else {
                        // コメントの追加
                        $user_name = isset($_POST['user_name']) ? htmlspecialchars($_POST['user_name'], ENT_QUOTES, 'UTF-8') : '';
                        $comment = isset($_POST['comment']) ? htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8') : '';

                        if ($user_name && $comment) {
                            $stmt = $conn->prepare("INSERT INTO chat (name, user, password, dbname, TEXT) VALUES (?, ?, ?, ?, ?)");

                            $user = "";
                            $password = "";
                            $stmt->bind_param("sssss", $user_name, $user, $password, $topic_id, $comment);
                            if ($stmt->execute()) {
                                echo "<p>コメントが投稿されました。</p>";
                            } else {
                                echo "<p>コメントの投稿に失敗しました。</p>";
                            }
                            $stmt->close();
                        }
                    }
                }

                // コメントの表示
                $stmt = $conn->prepare("SELECT ID, user, TEXT, time FROM chat WHERE dbname = ? ORDER BY time DESC");
                $stmt->bind_param("s", $topic_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    echo '<div class="comments">';
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="comment">';
                        echo '<strong>' . htmlspecialchars($row['user']) . '</strong> ';
                        echo '<span>[' . htmlspecialchars($row['time']) . ']</span>';
                        echo '<p>' . htmlspecialchars($row['TEXT']) . '</p>';
                        echo '<form method="post" action="" style="display:inline;">
                                <input type="hidden" name="delete_id" value="' . htmlspecialchars($row['ID']) . '">
                                <button type="submit" class="delete-btn">削除</button>
                              </form>';
                        echo '</div>';
                    }
                    echo '</div>';
                } else {
                    echo '<p>コメントはまだありません。</p>';
                }
                $stmt->close();

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
    </div>
</body>
</html>