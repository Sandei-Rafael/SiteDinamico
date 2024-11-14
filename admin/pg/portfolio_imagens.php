<?php
$id = $_REQUEST['id'];
?>

<link rel="stylesheet" href="./assetsAdmin/jquery-ui/jquery-ui.css">
<style>
    #response {
        position: relative;
        padding: 10px;
        background-color: #9F9;
        border: 2px solid #396;
        margin-bottom: 20px;
    }
</style>


<h2>Imagens do produto: </h2>
<hr>
<br />

<a title="Adicionar Imagens" class="btn btn-large btn-success" href="#dialog" id="acidiona">
    Adicionar Imagens
</a>
<a class="btn btn-large btn-danger" href="multi_imagens/exclui_tudo.php?tb=imagens&fk=<?= $id ?>">
    Excluir todas as imagens
</a>
<hr />

<!--<div id="response"></div>-->
<h4>Arraste as Imagens para organizar!</h4>
<div id="list">
    <ul class="row list-unstyled">
        <?php
        foreach ($sql->selectFor("SELECT * FROM imagens WHERE fk_produto = {$id} ORDER BY ordem ASC") as $imagem) {
        ?>
            <li id="arrayorder_<?= $imagem['id'] ?>" class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <!-- Card -->
                <div class="card shadow-sm">
                    <div id="divImg" class="card-img-top" style="cursor: move; height: 150px; background-image: url('../assets/img/dinamicas/portfolio/<?=$imagem['img_p'] ?>'); background-position: top center; background-size: cover; background-repeat: no-repeat;">
                        <!-- Aqui você pode adicionar a imagem diretamente com a tag <img> se preferir -->
                        <!--<img src="" class="card-img-top" alt="Imagem do produto">-->
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span><?= $imagem['ordem'] + 1 ?>º.</span>
                            <a href="multi_imagens/exclui.php?tb=imagens&id=<?= $imagem['id'] ?>&fk=<?= $id ?>" title="Excluir esta imagem" class="text-danger text-decoration-none">
                                Excluir
                            </a>
                        </div>
                    </div>
                </div>
            </li>
        <?php
        }
        ?>
    </ul><!--trumb-->
</div><!--list-->


<div id="modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script src="./assetsAdmin/jquery-ui/jquery-ui.min.js"></script>

<script type="text/javascript">
    $(function() {
        // Modal
        $('#acidiona').click(function(e) {
            $(".modal-body").empty();
            e.preventDefault();

            var id = $('#fk_categ').val();
            var src = './multi_imagens/seleciona.php?id=' + <?= $id ?>;


            // $('#modal').load(src);

            // $('#modal').modal('show');



            var caminho = '<iframe width="100%" height="400" frameborder="0" src="' + src + '"></iframe>';
            $(caminho).appendTo(".modal-body");
            $('#modal').modal('show');
        });

        // Move (reorder images)
        function slideout() {
            setTimeout(function() {
                $("#response").slideUp("slow", function() {});
            }, 2000);
        }

        $(function() {
            $("#list ul").sortable({
                opacity: 0.8,
                cursor: 'move',
                update: function() {
                    var order = $(this).sortable("serialize") + '&organiza=imagens';
                    $.post("classes/ordenar.php", order, function(theResponse) {
                        location.reload();
                    });
                }
            });
        });
    });
</script>