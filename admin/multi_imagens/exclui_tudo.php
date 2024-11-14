<?

include_once ".././set/config.php";

$tb = $_REQUEST['tb'];
$sql = new connect();
$caminho = "../../assets/img/galeria/";

if ($tb === 'imagens') {
    $fk = $_GET['fk'];
    foreach ($sql->selectFor("SELECT * FROM {$tb} where fk = {$fk}") as $imgDel) {

        if (file_exists($caminho . $imgDel['img_p'])) {
            unlink($caminho . $imgDel['img_p']);
        }
        if (file_exists($caminho . $imgDel['img_g'])) {
            unlink($caminho . $imgDel['img_g']);
        }

        $sql->delete("delete from {$tb} where fk = {$fk}");
    }
}

header("Location: ../home.php?pg=galImagens&id={$fk}");
exit;
