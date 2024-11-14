<?

include_once ".././set/config.php";

$sql = new connect();
$tb = $_REQUEST['tb'];
$id = $_REQUEST['id'];
$fk = $_REQUEST['fk'];
$caminho = "../../assets/img/dinamicas/portfolio/"; 

if ($tb === 'imagens') {

    $imgDel = $sql->select("select * from {$tb} where id = {$id}");

    if (file_exists($caminho . $imgDel['img_p'])) {
        unlink($caminho . $imgDel['img_p']);
    }

    if (file_exists($caminho . $imgDel['img_g'])) {
        unlink($caminho . $imgDel['img_g']);
    }
    $sql->delete("DELETE FROM {$tb} WHERE id = '{$id}'");
}


header("Location: ../home.php?pg=portfolio_imagens&id={$fk}");
exit;
?>