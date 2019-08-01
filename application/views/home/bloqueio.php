<!DOCTYPE html>
<html>
    <head>

        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="SISTEMA DE GESTÃO DE PROVAS ONLINE">
        <meta name="auhor" content="Silvio Silva de Souza">
        <meta name="mail" content="silvio.souza@seculomanaus.com.br">
        <title><?=FLG_BANCO?> :: SISTEMA DE GESTÃO ACADÊMICA ONLINE</title>
        <meta charset="utf-8">
        <!-- Vendor styles -->
        <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome.min.css') ?>" />
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css') ?>" />
        <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
        <!-- Vendor scripts -->
        <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/jquery-ui.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery.fullscreen.js') ?>"></script>

    <script type="text/javascript">
        
        function liberar(){
             $.post("<?= base_url('home/liberar') ?>", {
                    usuario: $("input[name='usuLiberacao']").val(),
                    senha: $("input[name='pasLiberacao']").val(),
                },
                function (valor) {

                    // SE ALIBERACA FOI REALIZADA, EXECUTA O FORM QUE CHAMA A PROVA
                    if(valor == 'true'){
                        document.getElementById("ir_prova").submit();
                    }else{
                       $("#resposta").html(valor); 
                    }
                });
        }

    </script>

    </head>
    <!-- <body> -->
        <body onselectstart="return false" oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='..Não tente isso .. '; return true;">
      
        <div id='dvAlert' class='alert alert-danger' style='width: 100%;
            margin: 0 auto;
            height: 100vh;
            position: absolute;
            top: 0;'>
            <div style='width: 50%; margin: 0 auto;'>
            <h4>Você já esta logado </h4> 
                <h5>máquina: <?php echo $rs['maquina'];?><br/></h5>
                <h5>IP: <?php echo $rs['ip'];?><br/></h5>
                <div class='well'>
                    
                        <label>Usuário</label>
                        <input name='usuLiberacao' class='form-control'>
                        <label>Senha</label>
                        <input type='password' name='pasLiberacao' class='form-control'>
                        <button data-toggle='btnLiberacao' type='button' class='btn btn-primary' onclick="liberar()">Liberar Máquina</button>
                   
                </div>
                <form action="<?= base_url('prova/index') ?>" method="POST" id="ir_prova">
                   <input type="hidden" value="nao_recarrega" id="nreload" name="nreload" type="text"> 
                </form>
            </div>
            <dir id="resposta"></dir>
        </div>
     </body>
</html>