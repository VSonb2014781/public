<?php

define('TITLE', 'Thêm một Trích dẫn');
include_once __DIR__ . '/../partials/header.php';

echo '<h2>Thêm một Trích dẫn</h2>';
if ($_SERVER['REQUEST_METHOD']==='POST'){
    if (!empty($_POST['quote'])&& !empty($_POST['soource'])){
        require_once __DIR__ . '/../partials/db_connect.php';

        $query = 'INSERT INTO QUOTES (  quote,source, favorte) VALUES (?,?,?)';

        try{
            $statement = $pdp->prepare($query);
            $statement->execute([
                $_POST['quote'],
                $_POST['source'],
                + (isset($_POST['favorite'])),
                $_POST['id']
            ]);
            echo '<p>Trích dẫn này đã được cập nhật.</p>';
        } catch (PDOException $e ){
            $error_message = 'Không thể cập nhật Trích dẫn này';
            $reason = $e->getMessage();
            include __DIR__ . '/../partials/show_error.php';
        }
    } else {
        $error_message = 'Hãy gõ vào cả Trích dẫn và Nguồn của nó!';
        include __DIR__ . '/../partials/show_error.php';
    }
}
intval(isset($_POST['favorite']));
?>
<form action="add_quote.php" method="post">
    <p><label>Trích dẫn <textarea name="quote" rows="5" cols="30"></textarea></label></p>
    <p><label>Nguồn <input type="text" name="source"></label></p>
    <p><label>Đây là trích dẫn yêu thích? <input type="checkbox" name="favorite" value="yes"></label></p>
    <p><input type="submit" name="submit" value="Thêm Trích dẫn này!"></p>
</form>

<?php include_once __DIR__ . '/../partials/footer.php'; ?>