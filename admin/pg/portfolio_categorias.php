<?php

//cadastra categoria
if (isset($_POST['cadastrarCategoria'])) {

    $dados = ["nome" => $_POST['nomeCateg']];

    $r = $sql->insert("categorias", $dados);

    if ($r['codErro'] != 0) {
        Helpers::alertaErro($r['msg']);
    }

    Helpers::alertaSucesso("Categoria cadastrada com sucesso!");
}

//edita categoria
if (isset($_POST['editaCategoria'])) {

    $id = $_POST['id'];

    $r = $sql->update("categorias", ["nome" => $_POST['nomeCateg']], "id={$id}");

    if ($r['codErro'] != 0) {
        Helpers::alertaErro($r['msg']);
    }

    Helpers::alertaSucesso("Categoria alterada com sucesso!");
}

//confirma excluir categoria
if(isset($_GET['acao']) && $_GET['acao'] == 'excluir'){

    $id = $_GET['id'];
    Helpers::alertaConfirma("Deseja realmente excluir essa categoria?","?pg=portfolio_categorias&acao=excluir2&id={$id}","?pg=portfolio");

}

//exclui categoria
if(isset($_GET['acao']) && $_GET['acao'] == 'excluir2'){

    $id = $_GET['id'];
    
    $r = $sql->delete("DELETE FROM categorias WHERE id = {$id}");

    Helpers::alertaSucesso($r);
    
}
?>

<h1>Portifólio</h1>

<h2>Categorias</h2>

<?php

//se o botao editar for clicado, recebe a ação, alimenta e mostra o form editar
if (isset($_GET['acao']) && $_GET['acao'] == 'editar') {
    $id = $_GET['id'];
    $cat = $sql->select("SELECT* FROM categorias WHERE id = {$id}");

?>

    <form id="editar" class="form-group" method="post">
        <label for="nomeCateg">Nome da Categoria</label>
        <input class="form-control" type="text" name="nomeCateg" id="nomeCateg" value="<?= $cat['nome'] ?>" required>
        <input type="hidden" name="id" value="<?= $cat['id'] ?>">
        <input type="submit" name="editaCategoria" value="Alterar Categoria">
    </form>

<?php
// se não houver a ação editar, mostra o form cadastar
} else {
?>

    <form id="cadastrar" class="form-group" method="post">
        <label for="nomeCateg">Nome da Categoria</label>
        <input class="form-control" type="text" name="nomeCateg" id="nomeCateg" required>
        <input type="submit" name="cadastrarCategoria" value="Cadastrar Categoria">
    </form>
<?php
}
?>


<hr>

<table class="table table-stripped">

    <tr>
        <td>Nome da Categoria</td>
        <td>Editar</td>
        <td>Excluir</td>
    </tr>

    <?php
    
    //busca no banco um array de categorias cadastradas
    $categ = $sql->selectFor("SELECT * FROM categorias ORDER BY nome");


    foreach ($categ as $v) {

        echo "<tr>
                <td>{$v['nome']}</td>
                <td>
                <a href=\"home.php?pg=portfolio_categorias&acao=editar&id={$v['id']}\">Editar</a>
                </td>
                <td>
                <a href=\"home.php?pg=portfolio_categorias&acao=excluir&id={$v['id']}\">Excluir</a>
                </td>
            </tr>
        ";
    }
    ?>

</table>