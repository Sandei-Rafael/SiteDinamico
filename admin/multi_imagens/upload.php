<?php

$id = $_REQUEST['id'];  // ID recebido via GET
$nome = mt_rand(); 
$nome_imagem = $nome . ".jpg";  // Definindo a extensão da imagem

$caminho = "../../assets/img/dinamicas/portfolio/";  // Caminho de onde a imagem será salva

// Conectando ao banco de dados
include_once "../connect.php";

$sql = new connect();  // Criando instância de conexão com o banco

// Incluindo a biblioteca de upload Verot
include "../assetsAdmin/class_upload/src/class.upload.php";

// Inicializando a classe de upload Verot
$img = new \Verot\Upload\Upload($_FILES['img_produto']);  // 'img_produto' é o nome do input de upload

// Verificando se o upload foi feito com sucesso
if ($img->uploaded) {
    
    // Processando a imagem para gerar as versões pequenas (300x300) e grande (800px de largura)
    // Salvando a imagem pequena
    $img_pNome = "_p_" . $nome_imagem;
    $img->image_resize = true;
    $img->image_x = 300;  // Largura de 300px
    $img->image_y = 300;  // Altura de 300px
    $img->image_crop = true;  // Cortando a imagem para garantir que fique 300x300
    $img->process($caminho);  // Processa a imagem e move para o diretório

    if ($img->processed) {
        $img_p = $img->file_dst_name;  // Nome do arquivo gerado para a versão pequena
    } else {
        echo 'Erro no redimensionamento da imagem pequena: ' . $img->error;
        exit;
    }

    // Processando a imagem para gerar a versão grande
    $img_gNome = $nome_imagem ;
    $img->image_resize = true;
    $img->image_x = 800;  // Largura de 800px
    $img->image_ratio_y = true;  // Mantém a proporção
    $img->process($caminho);  // Processa a imagem e move para o diretório

    if ($img->processed) {
        $img_g = $img->file_dst_name;  // Nome do arquivo gerado para a versão grande
    } else {
        echo 'Erro no redimensionamento da imagem grande: ' . $img->error;
        exit;
    }

    // Salvando os dados no banco de dados
    $imgBd = $sql->select("SELECT COUNT(id) AS qt, MAX(ordem) as maxOrdem FROM imagens WHERE fk_produto = {$id}");
    $maxOrdem = 0;

    if ($imgBd['qt'] > 0) {
        $maxOrdem = $imgBd['maxOrdem'] + 1;  // Incrementando a ordem para a nova imagem
    }

    // Preparando os dados para inserção no banco
    $dados = array(
        'img_p' => $img_p,  // Nome da imagem pequena
        'img_g' =>  $img_g,  // Nome da imagem grande
        'fk_produto' => $id,        // ID da referência (categoria ou outro relacionamento)
        'ordem' => $maxOrdem  // Ordem da imagem na categoria
    );

    // Inserindo no banco de dados
    echo $sql->insert("imagens", $dados);  // Insere os dados na tabela 'imagens'

    echo 1;  // Retorna 1 se tudo ocorrer corretamente

} else {
    // Caso o upload falhe
    echo 'Erro no upload da imagem: ' . $img->error;
}
?>
