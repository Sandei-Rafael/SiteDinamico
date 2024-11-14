<?php

if (isset($_POST['salvar'])) {
    $nomPerfil = $_POST['nome_perfil'];
    $twitter = $_POST['link_twitter'];
    $face = $_POST['link_face'];
    $insta = $_POST['link_insta'];
    $linkedin = $_POST['link_linkedin'];
    $texto_perfil = $_POST['texto_perfil'];

    $arrAtualiza = [
        Helpers::setSettings("nome_perfil", $nomPerfil),
        Helpers::setSettings("link_twitter", $twitter),
        Helpers::setSettings("link_face", $face),
        Helpers::setSettings("link_insta", $insta),
        Helpers::setSettings("link_linkedin", $linkedin),
        Helpers::setSettings("texto_perfil", $texto_perfil)
    ];

    foreach ($arrAtualiza as $r) {
        if ($r['codErro'] != 0) {
            Helpers::alertaErro($r['msg']);
        }
    }

    Helpers::alertaSucesso("Alterado com sucesso!");
}

if (isset($_POST['imagens_Home'])) {
    
    include "./assetsAdmin/class_upload/src/class.upload.php";

    $caminho = '../assets/img/dinamicas/';

    // Processamento da imagem do perfil
    if (!empty($_FILES['img_perfil']['name'])) {

        //buscar nome da imagem no banco de dados
        $img_antiga = Helpers::getSettings("img_perfil");


        if (file_exists($caminho . $img_antiga)) {
            unlink($caminho . $img_antiga);
        }

        $imgPerfil = new \Verot\Upload\Upload($_FILES['img_perfil']);
        if ($imgPerfil->uploaded) {
            $imgPerfil->file_new_name_body = 'img_perfil';
            $imgPerfil->image_resize = true;
            $imgPerfil->image_convert = 'jpg';
            $imgPerfil->image_x = 200;
            $imgPerfil->image_ratio_y = true;
            $imgPerfil->process($caminho);

            if ($imgPerfil->processed) {
                $imgPerfil->clean();
                $rImgPerfil = $sql->update("settings", ['setting_value' => $imgPerfil->file_dst_name], "id=6");
                if ($rImgPerfil['codErro'] != 0) {
                    Helpers::alertaErro("Erro ao salvar a imagem do perfil no banco de dados.");
                }

            } else {
                Helpers::alertaErro('Erro ao processar a imagem do perfil: ' . $imgPerfil->error);
            }
        }
    }

    // Processamento da imagem de fundo
    if (!empty($_FILES['img_fundo']['name'])) {

        //buscar nome da imagem no banco de dados
        $img_antiga = Helpers::getSettings("img_fundo");

        if (file_exists($caminho . $img_antiga)) {
            unlink($caminho . $img_antiga);
        }

        $imgFundo = new \Verot\Upload\Upload($_FILES['img_fundo']);

        if ($imgFundo->uploaded) {
            $imgFundo->file_new_name_body = 'img_fundo';
            $imgFundo->image_resize = true;
            $imgFundo->image_convert = 'webp';
            $imgFundo->image_x = 1920; // tamanho maior para a imagem de fundo
            $imgFundo->image_ratio_y = true;
            $imgFundo->process($caminho);
            if ($imgFundo->processed) {
                $imgFundo->clean();
                $rImgFundo = $sql->update("settings", ['setting_value' => $imgFundo->file_dst_name], "id=7");
                if ($rImgFundo['codErro'] != 0) {
                    Helpers::alertaErro("Erro ao salvar a imagem de fundo no banco de dados.");
                }
            } else {
                Helpers::alertaErro('Erro ao processar a imagem de fundo: ' . $imgFundo->error);
            }
        }
    }

    Helpers::alertaSucesso("Imagens alteradas com sucesso!");
}
?>

<h1>Home</h1>

<form method="post" class="form-group">
    <label class="label" for="nome_perfil">Nome Perfil</label>
    <input class="form-control" type="text" name="nome_perfil" id="nome_perfil" value="<?= Helpers::getSettings("nome_perfil"); ?>">

    <label class="label" for="link_twitter">Link Twitter</label>
    <input class="form-control" type="text" name="link_twitter" id="link_twitter" value="<?= Helpers::getSettings("link_twitter") ?>">

    <label class="label" for="link_face">Link Facebook</label>
    <input class="form-control" type="text" name="link_face" id="link_face" value="<?= Helpers::getSettings("link_face") ?>">

    <label class="label" for="link_insta">Link Instagram</label>
    <input class="form-control" type="text" name="link_insta" id="link_insta" value="<?= Helpers::getSettings("link_insta") ?>">

    <label class="label" for="link_linkedin">Link LinkedIn</label>
    <input class="form-control" type="text" name="link_linkedin" id="link_linkedin" value="<?= Helpers::getSettings("link_linkedin") ?>">
   
    <label class="label" for="link_linkedin">Texto Perfil</label>
    <input class="form-control" type="text" name="texto_perfil" id="texto_perfil" value="<?= Helpers::getSettings("texto_perfil") ?>">

    <br>
    <input class="form-control" type="submit" name="salvar" value="Salvar">
</form>

<hr>

<form method="post" class="form-group" enctype="multipart/form-data">
    <label>Imagem do perfil</label>
    <input type="file" name="img_perfil" class="form-control">

    <label>Imagem de fundo</label>
    <input type="file" name="img_fundo" class="form-control">

    <input type="submit" class="form-control" name="imagens_Home" value="Salvar">
</form>