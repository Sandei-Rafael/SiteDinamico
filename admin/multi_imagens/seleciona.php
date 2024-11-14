<!DOCTYPE HTML>
<html>
  <head>
    <meta charset="utf-8">
    <script src="../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/js/jquery.ui.widget.js"></script>
    <script src="assets/js/jquery.fileupload.js"></script>

    <style>
      #fileupload{display: none};
      .enviando{
        width: 100%;
        text-align: center;
        padding: 3px;
        background-color: #FFFF00;
      }
      .bar, .unibar {
        height: 18px;
        margin-top: 10px;
        background: green;
        border:solid thin white;
      }
    </style>

  </head>
  <body>
    <input id="fileupload" type="file" name="img_produto" data-url="upload.php?&id=<?= $_REQUEST['id'] ?>" accept="image/jpeg"  multiple>
    <div id="drop" style="
         width: 100%;
         margin: 0 auto;
         border: dashed thistle;
         text-align: center;
         line-height: 30px;
         font-size: 25px;
         font-family: arial;
         cursor: pointer
         ">
      Arraste as imagens aqui ou clique para selecionar.<br>
      Você pode selecionar várias imagens de uma vez!<br>
      Use arquivos com menos de 2 mb. 
    </div>

    <script>
      $(function () {
        $('#drop').click(function () {
          $(this).parent().find('input').click();
        });
        $('#fileupload').fileupload({
          dataType: 'json',
          maxChunkSize: 2000000,
          add: function (e, data) {

            data.context = $('<p style="width: 100%;text-align: center;padding: 3px;background-color: #DFE09C;"> Enviando: ' + data.files[0].name + ' ...</p>').appendTo(document.body);
            data.submit();
          },
          done: function (e, data) {
        
            if (data.result == 1) {
              data.context.html(data.files[0].name + ' ok.');
            } else {
              data.context.html(data.files[0].name + ' ERRO!');

            }
          },
          progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .bar').css(
                    'width',
                    progress + '%'
                    );
          },
          chunkfail: function (e, data) {
            data.context.html(data.files[0].name + ' erro');
          },
          stop: function (e, data) {
            parent.location.reload();
          },
        });
      });
    </script>
    <div id="progress">
      <div class="bar" style="width: 0%;"></div>
    </div>
  </body>
</html>