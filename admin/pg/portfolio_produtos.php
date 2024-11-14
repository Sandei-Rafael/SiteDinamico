<?php


if (isset($_POST['cadastrarCategoria'])) {

    $dados = ["nome" => $_POST['nomeProd'], "cliente" => $_POST['clienteProd'], "data_criacao" => $_POST['dataProd'], "projeto_url" => $_POST['projetoProd'], "descricao" => $_POST['descriProd'], "fk_categoria" => $_POST['fkCate']];

    $r = $sql->insert("produtos", $dados);

    if ($r['codErro'] != 0) {
        Helpers::alertaErro($r['msg']);
    }

    Helpers::alertaSucesso("Produto cadastrado com sucesso!");
}

if (isset($_POST['editaCategoria'])) {

    $id = $_POST['id'];

    $r = $sql->update("produtos", ["nome" => $_POST['nomeProd'], "cliente" => $_POST['clienteProd'], "data_criacao" => $_POST['dataProd'], "projeto_url" => $_POST['projetoProd'], "descricao" => $_POST['descriProd']], "id={$id}");

    if ($r['codErro'] != 0) {
        Helpers::alertaErro($r['msg']);
    }

    Helpers::alertaSucesso("Produto alterado com sucesso!");
}

if(isset($_GET['acao']) && $_GET['acao'] == 'excluir'){

    $id = $_GET['id'];
    Helpers::alertaConfirma("Deseja realmente excluir esse produto?","?pg=portfolio&acao=excluir2&id={$id}","?pg=portfolio");

}if(isset($_GET['acao']) && $_GET['acao'] == 'excluir2'){

    $id = $_GET['id'];
    
    $r = $sql->delete("DELETE FROM produtos WHERE id = {$id}");

    Helpers::alertaSucesso($r);
    
}
?>

<h1>Portifólio</h1>

<h2>Produto</h2>

<?php
if (isset($_GET['acao']) && $_GET['acao'] == 'editar') {
    $id = $_GET['id'];
    $cat = $sql->select("SELECT* FROM produtos WHERE id = {$id}");

?>

    <form id="editar" class="form-group" method="post">
        <label for="nomeProd">Nome do Produto</label>
        <input class="form-control" type="text" name="nomeProd" id="nomeProd" value="<?= $cat['nome'] ?>" required>
        <input type="hidden" name="id" value="<?= $cat['id'] ?>">

        <label for="nomeProd">Nome do Cliente</label>
        <input class="form-control" type="text" name="clienteProd" id="clienteProd" value="<?= $cat['cliente'] ?>" required>
        <input type="hidden" name="id" value="<?= $cat['id'] ?>">

        <label for="nomeProd">Data</label>
        <input class="form-control" type="date" name="dataProd" id="dataProd" value="<?= $cat['data_criacao'] ?>" required>
        <input type="hidden" name="id" value="<?= $cat['id'] ?>">

        <label for="nomeProd">Data</label>
        <input class="form-control" type="text" name="projetoProd" id="projetoProd" value="<?= $cat['projeto_url'] ?>" required>
        <input type="hidden" name="id" value="<?= $cat['id'] ?>">

        <label for="nomeProd">Data</label>
        <input class="form-control" type="text" name="descriProd" id="descriProd" value="<?= $cat['descricao'] ?>" required>
        <input type="hidden" name="id" value="<?= $cat['id'] ?>">

        <label for="fkCate">Categoria</label>
        <select name="fkCate" class="form-control">
            <option>Selecione uma categoria</option>

            <?php
            $cat = $sql->selectFor("SELECT * FROM categorias order by nome");

            foreach($cat as $v){
                echo "<option value=\"{$v['id']}\">{$v['nome']}</option>";
            }
            ?>
        </select>

        <input type="submit" name="editaCategoria" value="Alterar Produto" style="margin-top: 15px;">
    </form>

<?php
} else {
?>

    <form id="cadastrar" class="form-group" method="post">
        <label for="nomeProd">Nome do Produto</label>
        <input class="form-control" type="text" name="nomeProd" id="nomeProd" required>

        <label for="clienteProd">Cliente</label>
        <input class="form-control" type="text" name="clienteProd" id="clienteProd" required>

        <label for="dataProd">Data</label>
        <input class="form-control" type="date" name="dataProd" id="dataProd" required>

        <label for="projetoProd">URL do Projeto</label>
        <input class="form-control" type="text" name="projetoProd" id="projetoProd" required>
        
        <label for="descriProd">Descrição</label>
        <input class="form-control" type="text" name="descriProd" id="descriProd" required>

        <label for="fkCate">Categoria</label>
        <select name="fkCate" class="form-control">
            <option>Selecione uma categoria</option>

            <?php
            $cat = $sql->selectFor("SELECT * FROM categorias order by nome");

            foreach($cat as $v){
                echo "<option value=\"{$v['id']}\">{$v['nome']}</option>";
            }
            ?>
        </select>

        <input type="submit" name="cadastrarCategoria" value="Cadastrar Categoria" style="margin-top: 15px;">
    </form>
<?php
}
?>


<hr>

<table class="table table-stripped">

    <tr>
        <td>Nome do Produto</td>
        <td>Cliente</td>
        <td>Data</td>
        <td>URL do Projeto</td>
        <td>Descrição</td>
        <td>Categoria</td>
        <td>Editar</td>
        <td>Excluir</td>
    </tr>

    <?php
    $categ = $sql->selectFor("SELECT *,produtos.id as idprod, produtos.nome as nomeprod, categorias.nome as nome_cat FROM produtos join categorias on produtos.fk_categoria = categorias.id ORDER BY produtos.nome");


    foreach ($categ as $v) {

        echo "<tr>
                <td>{$v['nomeprod']}</td>
                <td>{$v['cliente']}</td>
                <td>{$v['data_criacao']}</td>
                <td>{$v['projeto_url']}</td>
                <td>{$v['descricao']}</td>
                <td>{$v['nome_cat']}</td>
                <td>
                <a href=\"home.php?pg=portfolio_produtos&acao=editar&id={$v['idprod']}\">Editar</a>
                </td>
                <td>
                <a href=\"home.php?pg=portfolio_produtos&acao=excluir2&id={$v['idprod']}\">Excluir</a>
                </td>
            </tr>
        ";
    }
    ?>

</table>