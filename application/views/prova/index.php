<?php 
$min_libera =  $this->prova->getMinutoLiberaBtn(array('CD_PROVA'=> $this->session->userdata('CES_PROVA'))) ;
//$min_libera->MIN_LIBERACAO; // 30*60
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <meta name="description" content="SISTEMA DE GESTÃO DE PROVAS ONLINE">


        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />

        <meta http-equiv="expires" content="0" />
        <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
        <meta http-equiv="pragma" content="no-cache" />
        
        <title>SISTEMA DE GESTÃO ACADÊMICA ONLINE</title>

        <!-- Vendor styles -->
        <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome.min.css') ?>" />
        <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.css') ?>" />
        <link rel="stylesheet" href="<?= base_url('assets/css/sweet-alert.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

        <!-- Vendor scripts -->
        <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/jquery-ui.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/bootstrap.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/sweet-alert.min.js') ?>"></script>
        <script src="<?= base_url('assets/js/icheck.min.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/jquery.fullscreen.js') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/prova.js?v='.time().'') ?>"></script>
        <script type="text/javascript" src="<?= base_url('assets/js/bloqueiaseta.js') ?>"></script>

        <script type="text/javascript">

            function fullscreem(){ 
                toggleFullScreen();
            }

            //atualiza cartao de questoes respondidas
            function cartao(prova) {
                $("#PanelCartao").html('<div><img width="100%" src="<?= base_url('assets/images/giphy.gif') ?>"></div>');
                $.post("<?= base_url('prova/cartao') ?>", {
                    prova: prova,
                },
                function (valor) {
                    $("#PanelCartao").html(valor);
                });
            }
            
            // insere a alternativa do aluno no banco
            function marcar(posicao, prova, questao, opcao) {

                fullscreem();
                //console.log('POSICAO '+ posicao, 'PROVA '+ prova, 'QUESTAO '+questao, 'OPCAO '+opcao);
                
                $.post("<?= base_url('prova/manter') ?>", {
                    questao: questao,
                    crono: $("#sessao").text(),
                    time: backtime(),
                    posicao: posicao,                                      
                    resposta: opcao,
                    atual: posicao,
                },
                function (valor) {
                    cartao(prova);
                });
            }
            
            // altera de questao
            function questao(posicao) {

                fullscreem();

                ferma(); // PARA O CRONOMETRO PROGRESSIVO

                var questao = $('#PainelQuestaoID').attr('data-questao');
                // var correta = $('#POpcaoC').attr('data-master');
                var resposta = $("input[name='rdResposta']:checked").val();

                $("#PainelQuestao").html('<div class="text-center" style="width:100%; margin: 0px; auto; background: #E5EFF1"><img width="50%" src="<?= base_url('assets/images/giphy.gif') ?>"></div>');
                $.post("<?= base_url('prova/questao') ?>", {
                    posicao: posicao,
                    time: backtime(),
                    crono: $("#sessao").text(),
                    questao: questao,
                    resposta: resposta,
                    atual: $('#PainelQuestaoID').attr('data-id'),
                    // correta: correta,
                },
                function (valor) {
                    $("#PainelQuestao").html(valor);
                    azzera();  // ZERA O CRONOMETRO PROGRESSIVO
                    avvia();   // INICIA O CRONOMETRO PROGRESSIVO
                });
            }
            

            function anterior() {

                fullscreem();

                var posicao = $('#PainelQuestaoID').attr('data-id');
                var anter = parseInt(posicao) - parseInt(1);

                var questao = $('#PainelQuestaoID').attr('data-questao');
                var correta = $('#POpcaoC').attr('data-master');
                var resposta = $("input[name='rdResposta']:checked").val();

                if (anter > 0) {
                    ferma(); // PARA O CRONOMETRO PROGRESSIVO
                    $("#PainelQuestao").html('<div class="text-center" style="width:100%; margin: 0px; auto; background: #E5EFF1"><img width="50%" src="<?= base_url('assets/images/giphy.gif') ?>"></div>');
                    $.post("<?= base_url('prova/questao') ?>", {
                        posicao: anter,
                        time: backtime(),
                        crono: $("#sessao").text(),
                        questao: questao,
                        resposta: resposta,
                        atual: posicao,
                        correta: correta
                    },
                    function (valor) {
                        $("#PainelQuestao").html(valor);
                        azzera();  // ZERA O CRONOMETRO PROGRESSIVO
                        avvia();   // INICIA O CRONOMETRO PROGRESSIVO
                    });
                }
            }
            

            function proximo() {

                fullscreem();

                var posicao = $('#PainelQuestaoID').attr('data-id');
                var proxima = parseInt(posicao) + parseInt(1);
                var qtdeQuestoes = "<?php echo sizeof($qtd); ?>";

                var questao = $('#PainelQuestaoID').attr('data-questao');
                var correta = $('#POpcaoC').attr('data-master');
                var resposta = $("input[name='rdResposta']:checked").val();
             
                if (proxima <= qtdeQuestoes) {
                    ferma(); // PARA O CRONOMETRO PROGRESSIVO
                    $("#PainelQuestao").html('<div class="text-center" style="width:100%; margin: 0px; auto; background: #E5EFF1"><img width="50%" src="<?= base_url('assets/images/giphy.gif') ?>"></div>');
                    $.post("<?= base_url('prova/questao') ?>", {
                        posicao: proxima,
                        time: backtime(),
                        crono: $("#sessao").text(),
                        questao: questao,
                        resposta: resposta,
                        atual: posicao,
                        correta: correta
                    },
                    function (valor) {
                        $("#PainelQuestao").html(valor);
                        azzera();  // ZERA O CRONOMETRO PROGRESSIVO
                        avvia();   // INICIA O CRONOMETRO PROGRESSIVO
                    });
                }
            }
            ;

            
            document.onkeydown = function (e) {return false;}

            $(window).on('load', function () {
                $('#avisoModal').modal('show');
            });

        </script>
    </head>
    <?php 
        $filtro = "posicao=".$questao->POSICAO." AND cd_questao =" . $questao->CD_QUESTAO ." AND cd_prova = ". $versao.""; 
        $query = $this->db->query("SELECT 
                        CASE  WHEN valor>0 and valor<1 then '0' || to_char(valor)
                        when LENGTH(to_char(valor)) = 1 then  to_char(valor) || ',0' 
                        else to_char(valor) 
                        end as valor
                        FROM bd_sica.aval_prova_questoes WHERE ".$filtro."");   
        $result = $query->result_array();

    ?>
    <!--body--> <body 
                <?php if ($this->session->userdata('PVO_USER') != '14003945') { //usuário de teste ?>
                    onselectstart="return false" oncontextmenu="return false" ondragstart="return false" onMouseOver="window.status='..Não permitido .. '; return true;"
                <?php } ?>
                >
        <div id="header">
            <div class="bg-primary" style="position: fixed; top: 0px; width:100%; z-index: 9999999999999">
                <div class="color-line"></div>

                <span id="tempoAcabando" class="col-sm-10 pull-left text-right text-warning">
                </span>
                <span class=" col-sm-2 pull-right text-center">
                    <span>
                        <span id="tempoProva"><i class="fa fa-clock-o"></i>Tempo de Prova<br></span>

                        <span id="sessao" style="font-size:20px"></span>
                        <div id="vis" style="float: left; line-height: 27px; display:none;">00:00:00</div>
                    </span>
                </span>
            </div>
        </div>

        
        <?php if($serie == 6 && ($materia == 'MATEMÁTICA' || $materia == 'PURTUGUÊS' || $materia == 'LING. PORTUGUESA - GRAM.')): ?>
 <style>
    
.input-radio{
  display: inline-block;
  padding:10px;
  font-size:32px;
  width:50px;
  height:50px;
  vertical-align: middle;
}
.painel-inline{
  width: 20% !important;
  display:inline-block !important;
}
</style>

        <div class="row">
            <div class="col-sm-9">
                <section id="PainelQuestao" style="margin:4%">
                    <div id="PainelQuestaoID" class="row" data-id="<?= $questao->POSICAO ?>" data-questao="<?= $questao->CD_QUESTAO ?>">
                        <div class="col-md-12 no-padding">
                            <div class="hpanel hviolet">
                                <div class="panel-heading">
                                    <h4><strong>DISCIPLINA: <?= $materia ?> - SÉRIE: <?= $this->session->userdata('SERIE')?>ª </strong></h4>
                                    <h5><?= $questao->POSICAO ?>ª Pergunta - VALOR DA QUESTÃO: <strong><?= str_replace(".",",",$result[0]['VALOR']); ?></strong> 
                                    </h5>
                                </div>
                    
                            </div>
                        </div>
                        <div class="col-md-12 no-padding">
                            <div class="hpanel hgreen" id='PainelOpcao'>
                                <div class="panel-heading">
                                    Respostas
                                </div>
                                <div class="panel-body" id='pergunta' style='font-size:15px; text-align: justify'>
                                    <?php
                                    $prova = new Prova_lib();
                                    echo $prova->formata_texto_com_richtext($questao->DC_QUESTAO);
                                    ?>
                                </div>

                                <?php
                                //$prova = new Prova_lib();

                                foreach($questao_posicao as $op){
                                $opc = $prova->resposta((($op['POSICAO']) ? $op['ORDEM_OPCAO'] : $op['POSICAO']));
                                $posicao =  $qtd[$op['POSICAO']-1];
                                

                                

                                if($posicao['RESPOSTA'] == $opc) $res = ' checked="checked" '; else  $res = '';
                                
                                    /*if($opc == "E"){
                                       $list_questao = "";

                                    }else{
                                        $list_questao = '<div  class="panel-footer" style="font-size:15px">';
                                        $list_questao .= '
                                            <input type="radio" name="rdResposta" class="i-checks" "'.$res.'" value="'.$opc.'" onclick="marcar('.$questao->POSICAO.','.$versao.','.$op['CD_QUESTAO'].','.$opc.');"> ';
                                        $list_questao .= $opc . ' ) ' . $prova->formata_texto_com_richtext_alternativa($op['DC_OPCAO']);
                                        $list_questao .= '</div>';
                                    }*/

                                    if($opc != "E"):
                                ?>

                                <div  class="panel-inline" style='font-size:32px; width:10%; display:inline-block; margin-top:20px;'>
                                    <input type="radio" name="rdResposta" class="i-checks input-radio" <?=$res ?> value="<?= $opc ?>" onclick="marcar(<?= $questao->POSICAO.",".$versao . "," . $op['CD_QUESTAO'] . ",'" . $opc . "'" ?>);">
                                    <?= $opc ?>
                                </div>
                   

                                    <?php endif; ?>

                                <?php } ?>
                                
                            </div>
                        </div>
                        <div id="POpcaoC" <?=$ret ?>></div>
                    </div>
                </section>
            </div>

            <div class="col-sm-3">
                <div class="hpanel hyellow">

                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img width='50' src="http://server01/academico/usuarios/foto?codigo=<?= $cd_aluno ?>" class="img-rounded">
                        </a>
                        <div class="media-body">
                            <h5><?=$this->session->userdata('PVO_NOME')?></h5>
                            <small class="text-muted">
                                <?= $questao->TITULO ?>
                               <?php  
                                    $cd_prova = $this->session->userdata('CES_PROVA'); 
                                    #$query = $this->db->query("select sum(VALOR) from BD_sica.AVAL_PROVA_QUESTOES where CD_PROVA = $cd_prova");

                                    $sql = "SELECT SUM(AQ.VALOR) FROM BD_SICA.AVAL_PROVA_QUESTOES AQ JOIN BD_ACADEMICO.AVAL_QUESTAO A ON A.CD_QUESTAO = AQ.CD_QUESTAO AND A.FLG_TIPO = 'O' WHERE AQ.CD_PROVA = $cd_prova";

                                    $query = $this->db->query($sql);

                                    $resultado = $query->result_array();
                                ?>                                
                            </small>
                            <h4><?= "PROVA OBJETIVA<br> VALOR: <span style='border-radius:50%; background:#337AB7; padding:5px 10px; display:inline-block; color:#FFF;'>".$resultado[0]["SUM(AQ.VALOR)"]; ?> </span> PONTOS</h4>

                        </div>
                    </div>
                    <div class="panel-body" id="PanelCartao" align="center">
                        Navegue entre as questões:
                        <br>
                        <? 
                        $questoesNaoResp = 0;
                        foreach($qtd as $q){ 

                        if ($q['RESPOSTA'] == '') $questoesNaoResp++;  
                        ?>                       
                        <button onclick="questao(<?= $q['POSICAO'] ?>);" class="btn btn-<?= (($q['RESPOSTA'] == '') ? 'default' : 'success') ?> btn-xs" style="margin: 2px; padding: 5px">
                            <?= ((($q['POSICAO']) == 1) ? $q['POSICAO'] : $q['POSICAO']) ?>
                        </button>
                        <? } ?>
                        <input type="hidden" id="qtdeNaoResp" value="<?= $questoesNaoResp ?>"/>
                        <br><br>
                        <table class="table-striped table-responsive table-hover text-center">
                            <th class='text-center' width="20%">Início</th>
                            <th class='text-center' width="20%">Término</th>
                            <th class='text-center' width="60%">Disciplina</th>

                            <?php
                                echo "<tr>";
                                echo "<td>" . 1 . "</td>";
                                echo "<td>" . $ultimaPosicao . "</td>";
                                echo "<td>" . $materia . "</td>";
                                echo "</tr>";
                            ?>
                        </table>

                    </div>

                    <div class="panel-footer text-center">
                        <a class="btn btn-default btn-xs"> &zwnj; </a> Não respondida | 
                        <a class="btn btn-success btn-xs"> &zwnj; </a> Respondida<br>
                    </div>

                        <!--Inicio Menu Acessibilidade-->
                        <div class="col-md-12" align="center">
                            <br>
                            <div>
                                <!-- DIMINUIR FONTE -->
                                <span style="font-size: 16px;">
                                <a title="Diminuir Fonte" alt="Diminuir Fonte" id="diminuir" href="javascript: onclick();">Diminuir&nbsp;&nbsp;<span
                                class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span></a>
                                </span>
                                <!-- AUMENTAR FONTE -->
                                <span style="font-size: 16px;">
                                <a title="Aumentar Fonte" alt="Aumentar Fonte" id="aumentar" href="javascript: onclick();">&nbsp;&nbsp;&nbsp;&nbsp;Aumentar&nbsp;&nbsp;<span
                                class="glyphicon glyphicon-plus-sign" aria-hidden="true"
                                style="margin-top: 5px;"></span></a>
                                </span>
                            </div>
                        <input type="hidden" name="ativo" id="ativo" value="0">
                        </div>
                        <!--Fim Menu Acessibilidade-->

                </div>
            </div>


            
        </div>

        <div class="bg-primary" style="position: fixed; bottom: 0px; width:100%;">
            <div class="col-md-2">
                <span class="pull-left" style="z-index: 999999999; position: absolute; left: 10px; width:100%;">
                </span>
            </div>
            <div class="col-md-5">
                <span class="pull-right btn-group">
                       
                    <a href="#" class="btn btn-warning2" onclick="anterior();">
                        <i class="fa fa-arrow-left"></i>
                        Pergunta Anterior
                    </a>
                    <a href="#" class="btn btn-danger2" onclick="proximo();">
                        Próxima Pergunta 
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </span>
            </div>
            <div class="col-sm-5">
                <span class="pull-right btn-group">
                    <a href="#" class="btn btn-success btnProvaFinalizar" ><!-- id="btnFinalizarProva" -->
                        Finalizar Avaliação
                        <i class="fa fa-close"></i>
                        
                    </a>
                </span>
            </div>
        </div>




        <?php elseif($serie == 7 && $materia == 'MATEMÁTICA'): ?>




 <style>
    
.input-radio{
  display: inline-block;
  padding:10px;
  font-size:32px;
  width:50px;
  height:50px;
  vertical-align: middle;
}
.painel-inline{
  width: 20% !important;
  display:inline-block !important;
}
</style>

        <div class="row">
            <div class="col-sm-9">
                <section id="PainelQuestao" style="margin:4%">
                    <div id="PainelQuestaoID" class="row" data-id="<?= $questao->POSICAO ?>" data-questao="<?= $questao->CD_QUESTAO ?>">
                        <div class="col-md-12 no-padding">
                            <div class="hpanel hviolet">
                                <div class="panel-heading">
                                    <h4><strong>DISCIPLINA: <?= $materia ?> - SÉRIE: <?= $this->session->userdata('SERIE')?>ª </strong></h4>
                                    <h5><?= $questao->POSICAO ?>ª Pergunta - VALOR DA QUESTÃO: <strong><?= str_replace(".",",",$result[0]['VALOR']); ?></strong> 
                                    </h5>
                                </div>
                    
                            </div>
                        </div>
                        <div class="col-md-12 no-padding">
                            <div class="hpanel hgreen" id='PainelOpcao'>
                                <div class="panel-heading">
                                    Respostas
                                </div>
                                <div class="panel-body" id='pergunta' style='font-size:15px; text-align: justify'>
                                    <?php
                                    $prova = new Prova_lib();
                                    echo $prova->formata_texto_com_richtext($questao->DC_QUESTAO);
                                    ?>
                                </div>

                                <?php
                                //$prova = new Prova_lib();

                                foreach($questao_posicao as $op){
                                $opc = $prova->resposta((($op['POSICAO']) ? $op['ORDEM_OPCAO'] : $op['POSICAO']));
                                $posicao =  $qtd[$op['POSICAO']-1];
                                

                                

                                if($posicao['RESPOSTA'] == $opc) $res = ' checked="checked" '; else  $res = '';
                                
                                    /*if($opc == "E"){
                                       $list_questao = "";

                                    }else{
                                        $list_questao = '<div  class="panel-footer" style="font-size:15px">';
                                        $list_questao .= '
                                            <input type="radio" name="rdResposta" class="i-checks" "'.$res.'" value="'.$opc.'" onclick="marcar('.$questao->POSICAO.','.$versao.','.$op['CD_QUESTAO'].','.$opc.');"> ';
                                        $list_questao .= $opc . ' ) ' . $prova->formata_texto_com_richtext_alternativa($op['DC_OPCAO']);
                                        $list_questao .= '</div>';
                                    }*/

                                    if($opc != "E"):
                                ?>

                                <div  class="panel-inline" style='font-size:32px; width:10%; display:inline-block; margin-top:20px;'>
                                    <input type="radio" name="rdResposta" class="i-checks input-radio" <?=$res ?> value="<?= $opc ?>" onclick="marcar(<?= $questao->POSICAO.",".$versao . "," . $op['CD_QUESTAO'] . ",'" . $opc . "'" ?>);">
                                    <?= $opc ?>
                                </div>
                   

                                    <?php endif; ?>

                                <?php } ?>
                                
                            </div>
                        </div>
                        <div id="POpcaoC" <?=$ret ?>></div>
                    </div>
                </section>
            </div>

            <div class="col-sm-3">
                <div class="hpanel hyellow">

                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img width='50' src="http://server01/academico/usuarios/foto?codigo=<?= $cd_aluno ?>" class="img-rounded">
                        </a>
                        <div class="media-body">
                            <h5><?=$this->session->userdata('PVO_NOME')?></h5>
                            <small class="text-muted">
                                <?= $questao->TITULO ?>
                                <?php  
                                    $cd_prova = $this->session->userdata('CES_PROVA'); 
          
                                    //$query = $this->db->query("select sum(VALOR) from BD_sica.AVAL_PROVA_QUESTOES where CD_PROVA = $cd_prova");

                                    $sql = "SELECT SUM(AQ.VALOR) FROM BD_SICA.AVAL_PROVA_QUESTOES AQ JOIN BD_ACADEMICO.AVAL_QUESTAO A ON A.CD_QUESTAO = AQ.CD_QUESTAO AND A.FLG_TIPO = 'O' WHERE AQ.CD_PROVA = $cd_prova";

                                    $query = $this->db->query($sql);

                                    $resultado = $query->result_array();

                                ?>
                            </small>
                            <h4><?= "PROVA OBJETIVA<br> VALOR: <span style='border-radius:50%; background:#337AB7; padding:5px 10px; display:inline-block; color:#FFF;'>".$resultado[0]["SUM(AQ.VALOR)"]; ?> </span> PONTOS</h4>
                        </div>
                    </div>
                    <div class="panel-body" id="PanelCartao" align="center">
                        Navegue entre as questões:
                        <br>
                        <? 
                        $questoesNaoResp = 0;
                        foreach($qtd as $q){ 

                        if ($q['RESPOSTA'] == '') $questoesNaoResp++;  
                        ?>                       
                        <button onclick="questao(<?= $q['POSICAO'] ?>);" class="btn btn-<?= (($q['RESPOSTA'] == '') ? 'default' : 'success') ?> btn-xs" style="margin: 2px; padding: 5px">
                            <?= ((($q['POSICAO']) == 1) ? $q['POSICAO'] : $q['POSICAO']) ?>
                        </button>
                        <? } ?>
                        <input type="hidden" id="qtdeNaoResp" value="<?= $questoesNaoResp ?>"/>
                        <br><br>
                        <table class="table-striped table-responsive table-hover text-center">
                            <th class='text-center' width="20%">Início</th>
                            <th class='text-center' width="20%">Término</th>
                            <th class='text-center' width="60%">Disciplina</th>

                            <?php
                                echo "<tr>";
                                echo "<td>" . 1 . "</td>";
                                echo "<td>" . $ultimaPosicao . "</td>";
                                echo "<td>" . $materia . "</td>";
                                echo "</tr>";
                            ?>
                        </table>

                    </div>

                    <div class="panel-footer text-center">
                        <a class="btn btn-default btn-xs"> &zwnj; </a> Não respondida | 
                        <a class="btn btn-success btn-xs"> &zwnj; </a> Respondida<br>
                    </div>

                        <!--Inicio Menu Acessibilidade-->
                        <div class="col-md-12" align="center">
                            <br>
                            <div>
                                <!-- DIMINUIR FONTE -->
                                <span style="font-size: 16px;">
                                <a title="Diminuir Fonte" alt="Diminuir Fonte" id="diminuir" href="javascript: onclick();">Diminuir&nbsp;&nbsp;<span
                                class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span></a>
                                </span>
                                <!-- AUMENTAR FONTE -->
                                <span style="font-size: 16px;">
                                <a title="Aumentar Fonte" alt="Aumentar Fonte" id="aumentar" href="javascript: onclick();">&nbsp;&nbsp;&nbsp;&nbsp;Aumentar&nbsp;&nbsp;<span
                                class="glyphicon glyphicon-plus-sign" aria-hidden="true"
                                style="margin-top: 5px;"></span></a>
                                </span>
                            </div>
                        <input type="hidden" name="ativo" id="ativo" value="0">
                        </div>
                        <!--Fim Menu Acessibilidade-->

                </div>
            </div>


            
        </div>

        <div class="bg-primary" style="position: fixed; bottom: 0px; width:100%;">
            <div class="col-md-2">
                <span class="pull-left" style="z-index: 999999999; position: absolute; left: 10px; width:100%;">
                </span>
            </div>
            <div class="col-md-5">
                <span class="pull-right btn-group">
                       
                    <a href="#" class="btn btn-warning2" onclick="anterior();">
                        <i class="fa fa-arrow-left"></i>
                        Pergunta Anterior
                    </a>
                    <a href="#" class="btn btn-danger2" onclick="proximo();">
                        Próxima Pergunta 
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </span>
            </div>
            <div class="col-sm-5">
                <span class="pull-right btn-group">
                    <a href="#" class="btn btn-success btnProvaFinalizar" ><!-- id="btnFinalizarProva" -->
                        Finalizar Avaliação
                        <i class="fa fa-close"></i>
                        
                    </a>
                </span>
            </div>
        </div>




        <?php else: ?>

            
        
        <div class="row">
            <div class="col-sm-9">
                <section id="PainelQuestao" style="margin:4%">
                    <div id="PainelQuestaoID" class="row" data-id="<?= $questao->POSICAO ?>" data-questao="<?= $questao->CD_QUESTAO ?>">
                        <div class="col-md-12 no-padding">
                            <div class="hpanel hviolet">
                                <div class="panel-heading">
                                    <h4><strong>DISCIPLINA: <?= $materia ?> - SÉRIE: <?= $this->session->userdata('SERIE')?>ª </strong></h4>
                                    <h5><?= $questao->POSICAO ?>ª Pergunta - VALOR DA QUESTÃO: <strong><?= str_replace(".",",",$result[0]['VALOR']); ?></strong> 
                                    </h5>
                                </div>
                                <div class="panel-body" id='pergunta' style='font-size:15px; text-align: justify'>
                                    <?php
                                    $prova = new Prova_lib();
                                    echo $prova->formata_texto_com_richtext($questao->DC_QUESTAO);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 no-padding">
                            <div class="hpanel hgreen" id='PainelOpcao'>
                                <div class="panel-heading">
                                    Respostas
                                </div>
                                <div class="panel-body"></div>

                                <?php
                                foreach($questao_posicao as $op){
                                $opc = $prova->resposta((($op['POSICAO']) ? $op['ORDEM_OPCAO'] : $op['POSICAO']));
                                $posicao =  $qtd[$op['POSICAO']-1];
                                

                                

                                if($posicao['RESPOSTA'] == $opc) $res = ' checked="checked" '; else  $res = '';
                                
                                    /*if($opc == "E"){
                                       $list_questao = "";

                                    }else{
                                        $list_questao = '<div  class="panel-footer" style="font-size:15px">';
                                        $list_questao .= '
                                            <input type="radio" name="rdResposta" class="i-checks" "'.$res.'" value="'.$opc.'" onclick="marcar('.$questao->POSICAO.','.$versao.','.$op['CD_QUESTAO'].','.$opc.');"> ';
                                        $list_questao .= $opc . ' ) ' . $prova->formata_texto_com_richtext_alternativa($op['DC_OPCAO']);
                                        $list_questao .= '</div>';
                                    }*/

                                    if($opc != "E"):
                                ?>

                                <div  class="panel-footer" style='font-size:15px'>
                                    <input type="radio" class="check-radio" name="rdResposta" class="i-checks" <?=$res ?> value="<?= $opc ?>" onclick="marcar(<?= $questao->POSICAO.",".$versao . "," . $op['CD_QUESTAO'] . ",'" . $opc . "'" ?>);">
                                    <?= $opc . ' ) ' . $prova->formata_texto_com_richtext_alternativa($op['DC_OPCAO']); ?>
                                </div>
                   


                                    <?php endif; ?>

                                <?php } ?>
                                
                            </div>
                        </div>
                        <div id="POpcaoC" <?=$ret ?>></div>
                    </div>
                </section>
            </div>
            <div class="col-sm-3">
                <div class="hpanel hyellow">

                    <div class="media social-profile clearfix">
                        <a class="pull-left">
                            <img width='50' src="http://server01/academico/usuarios/foto?codigo=<?= $cd_aluno ?>" class="img-rounded">
                        </a>
                        <div class="media-body">
                            <h5><?=$this->session->userdata('PVO_NOME')?></h5>
                            <small class="text-muted">
                                <?= $questao->TITULO ?>
                               <?php  
                                    $cd_prova = $this->session->userdata('CES_PROVA'); 
                                    // $query = $this->db->query("select sum(VALOR) from BD_sica.AVAL_PROVA_QUESTOES where CD_PROVA = $cd_prova");

                                    $sql = "SELECT SUM(AQ.VALOR) FROM BD_SICA.AVAL_PROVA_QUESTOES AQ JOIN BD_ACADEMICO.AVAL_QUESTAO A ON A.CD_QUESTAO = AQ.CD_QUESTAO AND A.FLG_TIPO = 'O' WHERE AQ.CD_PROVA = $cd_prova";

                                    $query = $this->db->query($sql);
                                  
                                    $resultado = $query->result_array();

                                ?>
                            </small>
                            <h4><?= "PROVA OBJETIVA<br> VALOR: <span style='border-radius:50%; background:#337AB7; padding:5px 10px; display:inline-block; color:#FFF;'>".$resultado[0]["SUM(AQ.VALOR)"]; ?> </span> PONTOS</h4>
                        </div>
                    </div>
                    <div class="panel-body" id="PanelCartao" align="center">
                        Navegue entre as questões:
                        <br>
                        <? 
                        $questoesNaoResp = 0;
                        foreach($qtd as $q){ 

                        if ($q['RESPOSTA'] == '') $questoesNaoResp++;  
                        ?>                       
                        <button onclick="questao(<?= $q['POSICAO'] ?>);" class="btn btn-<?= (($q['RESPOSTA'] == '') ? 'default' : 'success') ?> btn-xs" style="margin: 2px; padding: 5px">
                            <?= ((($q['POSICAO']) == 1) ? $q['POSICAO'] : $q['POSICAO']) ?>
                        </button>
                        <? } ?>
                        <input type="hidden" id="qtdeNaoResp" value="<?= $questoesNaoResp ?>"/>
                        <br><br>
                        <table class="table-striped table-responsive table-hover text-center">
                            <th class='text-center' width="20%">Início</th>
                            <th class='text-center' width="20%">Término</th>
                            <th class='text-center' width="60%">Disciplina</th>

                            <?php
                                echo "<tr>";
                                echo "<td>" . 1 . "</td>";
                                echo "<td>" . $ultimaPosicao . "</td>";
                                echo "<td>" . $materia . "</td>";
                                echo "</tr>";
                            ?>
                        </table>

                    </div>

                    <div class="panel-footer text-center">
                        <a class="btn btn-default btn-xs"> &zwnj; </a> Não respondida | 
                        <a class="btn btn-success btn-xs"> &zwnj; </a> Respondida<br>
                    </div>

                        <!--Inicio Menu Acessibilidade-->
                        <div class="col-md-12" align="center">
                            <br>
                            <div>
                                <!-- DIMINUIR FONTE -->
                                <span style="font-size: 16px;">
                                <a title="Diminuir Fonte" alt="Diminuir Fonte" id="diminuir" href="javascript: onclick();">Diminuir&nbsp;&nbsp;<span
                                class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span></a>
                                </span>
                                <!-- AUMENTAR FONTE -->
                                <span style="font-size: 16px;">
                                <a title="Aumentar Fonte" alt="Aumentar Fonte" id="aumentar" href="javascript: onclick();">&nbsp;&nbsp;&nbsp;&nbsp;Aumentar&nbsp;&nbsp;<span
                                class="glyphicon glyphicon-plus-sign" aria-hidden="true"
                                style="margin-top: 5px;"></span></a>
                                </span>
                            </div>
                        <input type="hidden" name="ativo" id="ativo" value="0">
                        </div>
                        <!--Fim Menu Acessibilidade-->

                </div>
            </div>
        </div>


        <div class="bg-primary" style="position: fixed; bottom: 0px; width:100%;">
            <div class="col-md-2">
                <span class="pull-left" style="z-index: 999999999; position: absolute; left: 10px; width:100%;">
                </span>
            </div>
            <div class="col-md-5">
                <span class="pull-right btn-group">
                       
                    <a href="#" class="btn btn-warning2" onclick="anterior();">
                        <i class="fa fa-arrow-left"></i>
                        Pergunta Anterior
                    </a>
                    <a href="#" class="btn btn-danger2" onclick="proximo();">
                        Próxima Pergunta 
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </span>
            </div>
            <div class="col-sm-5">
                <span class="pull-right btn-group">
                    <a href="#" class="btn btn-success btnProvaFinalizar" ><!-- id="btnFinalizarProva" -->
                        Finalizar Avaliação
                        <i class="fa fa-close"></i>
                        
                    </a>
                </span>
            </div>
        </div>




        <?php endif; ?>

        <div id="avisoModal" class="modal fade bs-example-modal-lg" data-backdrop="static" style="background-color: #000" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title text-center" id="myModalLabel"> LEIA ATENTAMENTE AS ORIENTAÇÕES ABAIXO!</h6>
                    </div>
                    <div class="modal-body" style="overflow-y: auto; height: 300px; font-size: 14px" >

                        <div class="row"> 1. Confira seu nome e número de matrícula antes de iniciar a resolução das questões;</div><br>
                        <div class="row"> 2. Esta avaliação é constituída de 10 (dez) questões objetivas com valoração de pontos de acordo com a complexidade de cada questão;</div><br>
                        <div class="row"> 3. O tempo para resolução da avaliação será demonstrado no sistema; haverá uma comunicação quando faltarem 15 minutos para o término e NÃO SERÁ CONCEDIDO TEMPO EXTRA para a finalização de eventuais pendências. </div><br> 
                        <div class="row"> 4. Utilize a folha de rascunho quando necessário; </div><br> 
                        <div class="row"> 5. É PROIBIDO pedir material emprestado como calculadora ou qualquer dispositivo eletrônico de comunicação;</div><br>
                        <div class="row"> 6. PORTAR (mesmo que não consulte) ou USAR meios ilícitos (“cola”) são atos considerados TRANSGRESSÕES GRAVES. Nesse caso, o aluno será retirado da sala, terá sua avaliação encerrada e responderá às sanções regulamentares previstas;</div><br>

                        <div class="row"> 7. Ao finalizar a avaliação, o aluno terá acesso ao resultado correspondente ao seu desempenho;</div><br>

                        <div class="row"> 8. O download da avaliação estará disponível após 1h do término da avaliação;</div><br>

                        <div class="row"> 9. Após a divulgação do gabarito no portal, o(a) aluno(a), se julgar conveniente, poderá, no prazo de 48h, requerer a revisão da sua avaliação na secretaria da escola.</div><br>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="toggleFullScreen()">Fechar</button>
                    </div>
                </div>
            </div>
        </div>


        <div id="fullModal" class="modal fade bs-example-modal-lg" data-backdrop="static" style="background-color: #000" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title text-center" id="myModalLabel"> Atenção!</h6>
                    </div>
                    <div class="modal-body" style="overflow-y: auto; height: 300px; font-size: 14px" >

                        <div class="row"> Você não pode sair do modo tela cheia no período de prova;</div><br>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="toggleFullScreen()">Fechar</button>
                    </div>
                </div>
            </div>
        </div>


        <script>
           // $('#btnFinalizarProva').hide();

            var min_liberacao = "<?php echo $min_libera->MIN_LIBERACAO; ?>";

            console.log("MINUTO LIBERACAO = "+min_liberacao);
            avvia();
            var tempo = new Number();
            // Tempo em segundos
            var tempo_respondido = "<?php echo $tempo; ?>";
            //tempo restante quando o aluno não finaliza a prova            

            t = tempo_respondido;
            tempo = 0;
            var t = tempo_respondido.split(":");
            tempo += ((parseInt(t[0]) * 60) * 60);
            tempo += (parseInt(t[1]) * 60);
            tempo += parseInt(t[2]);            

            function registrarUltimaAcao() {
                var aux = tempo;
                var horas = parseInt(aux / 3600);

                aux = aux - (horas * 3600);
                var minutos = parseInt(aux / 60);

                $.post("<?= base_url("prova/registrarUltimaAcao"); ?>", {
                    tempo: horas.toString() + ":" + minutos.toString()
                });
                
                // Define que a cada minuto deve registrar o momento da ultima acao na prova
                setTimeout("registrarUltimaAcao()", 60000);
            }

            function startCountdown() {
                //  console.log("TEMPO 1  -- "+tempo);
                // Se o tempo não for zerado
                if ((tempo - 1) >= 0) {
                    // Pega a parte inteira dos minutos
                    var min = parseInt(tempo / 60);
                    // horas, pega a parte inteira dos minutos
                    var hor = parseInt(min / 60);
                    //atualiza a variável minutos obtendo o tempo restante dos minutos
                    min = min % 60;
                    // Calcula os segundos restantes
                    var seg = tempo % 60;
                    // Formata o número menor que dez, ex: 08, 07, ...
                    if (min < 10) {
                        min = "0" + min;
                        min = min.substr(0, 2);
                    }
                    if (seg <= 9) {
                        seg = "0" + seg;
                    }
                    if (hor <= 9) {
                        hor = "0" + hor;
                    }
                    // Cria a variável para formatar no estilo hora/cronômetro
                    horaImprimivel = hor + ':' + min + ':' + seg;

                     //5400 = do intervalo da duração de prova
                    new_time = 5400 - (min_liberacao*60);//
                        
                    
                    if (tempo <= new_time) { //900 - 15minutos 3600
                        $('#btnFinalizarProva').show();
                    }
                    // console.log("TEMPO "+tempo+"  -- TEMPO CAD "+new_time);
                    if (tempo == 900) { //900 - 15 minutos
                        swal("ATENÇÃO!", "Faltam apenas " + min + " minutos para o término da Avaliação!", "warning");
                        $("#sessao").html(horaImprimivel);
                        $("#sessao").css('font-size','40px');
                        $("#tempoProva").remove();
                        $("#tempoAcabando").html("<i class='fa fa-clock-o'></i> Tempo restante de prova: ");
                        $('#tempoAcabando').css('font-size','40px');
                    }

                    //JQuery pra setar o valor
                    $("#sessao").html(horaImprimivel);
                    // Define que a função será executada novamente em 1000ms = 1 segundo
                    setTimeout('startCountdown()', 1000);                    
                    
                    // diminui o tempo
                    tempo--;
                    // Quando o contador chegar a zero faz esta ação
                } 
                /*else {
                   // window.open('<?php #echo base_url('prova/resultado') ?>', '_self');
                }*/
            }
            // Chama a função ao carregar a tela            
            $('#avisoModal').on('hide.bs.modal', function () {
                startCountdown();                
                registrarUltimaAcao();
            });
        </script>
        <script>
           
            $(function () {

                $('.btnProvaFinalizar').click(function () {
                    var verificador = document.getElementById("qtdeNaoResp");
                    if (parseInt(verificador.value) > 0) {
                        swal({
                            title: "Pendência!",
                            text: "Constam " + verificador.value + " questões não respondidas, deseja finalizar a Avaliação?",
                            type: "info",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Continuar",
                            cancelButtonText: "Cancelar",
                            closeOnConfirm: true,
                            closeOnCancel: true},
                        function (isConfirm) {
                            console.log(isConfirm);
                            if(isConfirm == true){

                            }
                            //finalizar();
                        });
                    }else {
                        finalizar();
                    }

                    function finalizar() {
                        swal({
                            title: "Finalizar Prova",
                            text: "Você deseja realmente finalizar a prova?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Sim, Finalizar",
                            cancelButtonText: "Quero Revisar!",
                            closeOnConfirm: false,
                            closeOnCancel: false},
                        function (isConfirm) {
                            if (isConfirm) {
                                swal("Prova Finalizada", "Aguarde... você será redirecionado para o resultado.", "success");
                                window.open('<?= base_url('prova/resultado') ?>', '_self');
                            } else {
                                swal("Você escolheu revisão", "Boa revisão", "warning");
                            }
                        });
                    }
                });
            });

        </script>
        <!-- Função para aumentar e diminuir a fonte da prova -->
        <script>
        $(document).ready(function(){

                    var $elemento = $("body #PainelQuestao").find("*"); //encontra todos os elementos dentro do #container
                    var conteudo = '.content';
                    var fonts = [];

                    function obterTamanhoFonte() {
                        for (var i = 0; i < $elemento.length; i++) {
                            fonts.push(parseFloat($elemento.eq(i).css('font-size')));
                        }
                        normal = $("body .content").css('font-size');

                    }
                    obterTamanhoFonte();

            
                    $('#aumentar').on('click', function (e) {
                        for (var i = 0; i < $elemento.length; i++) {
                            ++fonts[i];
                            $elemento.eq(i).css('font-size', fonts[i]);
                        }
                    });

                    $('#diminuir').on('click', function (e) {
                        for (var i = 0; i < $elemento.length; i++) {
                            --fonts[i];
                            $elemento.eq(i).css('font-size', fonts[i]);
                        }
                    });
                });        
        </script>
    </body>
</html>