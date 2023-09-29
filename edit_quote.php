<?php

define('TITLE', 'Sửa một Trích dẫn');
include_once __DIR__ . '/../partials/header.php';

echo '<h2>Sửa một Trích dẫn</h2>';

require_once __DIR__ . '/../partials/db_connect.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])&&($_GET['id'] >0)){
    $query = "SELECT quote,source,favorite FROM quotes WHERE id=?";

    try {
        $statement = $pdo->prepare($query);
        $statement->execute([$_GET[ 'id' ]]);
        $row = $statement->fetch();       
    } catch (POOException $e) {
        $pdo_error = $e->getMessage();
    }

    if (!empty($row)){
        echo '<form action="edit_quote.php" method="post">
            <p><label>Trích dẫn <textarea name="quote" rows="5" cols="30">' .
            htmlspecialchars($row['quote']) . '</textarea></label></p>
            <p><label>Nguồn<input type="text" nane="source" value="' .
            htmlspecialchars($row['source']) . '"></lable></p>
            <p><label> Đây là trích dẫn được yêu thích?
                <input type="checkbox" name="favorite" value="yes"';

        if($row['favorite'] == 1){
            echo 'checked="checked"';
        }

        echo '></label></p>
            <input type="hidden" name="id" value"' . $_GET['id'] .'">
            <p><input type="submit" name="submit" value="Cập nhật Trích dẫn này!"</p>
            </form>';
    } else{
        $error_message = 'Không thể lấy được trích dẫn này';
        $reason = $pdo_error ?? 'Không rõ nguyên nhân';
        include __DIR__ . '/../partials/show_error.php';
    }
} elseif (isset($_POST['id']) && is_numeric($_POST['id']) &&($_POST['id']>0)){
    if (!empty($_POST['id']) && !empty($_POST['source'])){
        $query = 'UPDATE quotes SET quote=?,source=?,favorite=? WHERE id=?';

        try{
            $statement = $pdo—>prepare($query);
            $statement—>execute([
                $_POST['quote'],
                $_POST['source'],
                + (isset($_POST['favorite'])),
                $_POST['id']
            ]);
            echo '<p>Trích dẫn này đã được cập nhật.</p>';
        } catch (PDOException $e){
            $error_message = 'Không thể cập nhật trích dẫn này';
            $reason = $e->getMessage();
            include __DIR__ . '/../partials/show_error.php';
        }
    } else {
        $error_message = 'Hãy gõ vào cả Trích dẫn và Nguồn của nó!';
        include __DIR__ . '/../partials/show_error.php';
    }
} else{
    include_once __DIR__ . '/../partials/footer.php';
}