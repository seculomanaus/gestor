<div class="modal-dialog" style="width: 100%; margin-top: -10px">
    <script type="text/javascript">

                function cartao(prova) {
                    $("#PanelCartao").html('<div><img width="100%" src="<?= base_url('assets/images/giphy.gif') ?>"></div>');
                    $.post("<?= base_url('comissao/prova/cartao') ?>", {
                        prova: prova,
                    },
                            function (valor) {
                                $("#PanelCartao").html(valor);
                            });
                }
                ;

                function marcar(posicao, prova, questao, opcao) {

                }
                ;

                function questao(posicao) {

                    var questao = $('#PainelQuestaoID').attr('data-questao');
                    var correta = $('#PainelOpcaoCorreta').attr('data-master');
                    var resposta = $("input[name='rdResposta']:checked").val();

                    $("#PainelQuestao").html('<div class="text-center" style="width:100%; margin: 0px; auto; background: #E5EFF1"><img width="50%" src="<?= base_url('assets/images/giphy.gif') ?>"></div>');
                    $.post("<?= base_url('comissao/prova/questao') ?>", {
                        posicao: posicao,
                        questao: questao,
                        resposta: resposta,
                        atual: $('#PainelQuestaoID').attr('data-id'),
                    },
                            function (valor) {
                                $("#PainelQuestao").html(valor);
                            });
                };

            </script>
    <div class="modal-content">
        <div class="color-line"></div>
        <div class="modal-body row">
            <div class="col-sm-9">
                <section id="PainelQuestao" style="margin:4%">
                    <div id="PainelQuestaoID" class="row" data-id="<?= $questao->POSICAO ?>" data-questao="<?= $questao->CD_QUESTAO ?>">
                        <div class="col-md-12 no-padding">
                            <div class="hpanel hviolet">
                                <div class="panel-heading">
                                    <h4><strong>DISCIPLINA: <?= $questao->NM_DISCIPLINA ?></strong></h4>
                                    <h5><?= $questao->POSICAO ?>ª Pergunta</h5>
                                </div>
                                <div class="panel-body" id='pergunta' style='font-size:15px; text-align: justify'>
                                    <?
                                    $prova = new Prova_lib();
                                    echo $prova->formata_texto_com_richtext($questao->DC_QUESTAO->load());
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
                                <? 
                                foreach($opcao as $op){
                                $opc = $prova->resposta((($op['POSICAO'] == '') ? $op['CD_OPCAO'] : $op['POSICAO']));
                                if($op['FLG_CORRETA'] == 1)  $ret = ' data-master="'.$opc.'" ';

                                if($questao->RESPOSTA == $opc) $res = ' checked="checked" '; else  $res = '' ;

                                ?>
                                <div  class="panel-footer" style='font-size:15px'>
<?= $opc . ' ) ' . $op['DC_OPCAO']->load() ?>
                                </div>
                                <? } ?>
                                <div id="PainelOpcaoCorreta" <?= $ret ?>></div>
                            </div>
                        </div>

                    </div>
                </section>
            </div>
            <div class="col-sm-3">
                <div class="hpanel hyellow">

                    <div class="media social-profile clearfix">
                        <div class="media-body">
                            <small class="text-muted">
                                <?= $questao->TITULO ?>
                            </small>
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
<?= ((strlen($q['POSICAO']) == 1) ? '0' . $q['POSICAO'] : $q['POSICAO']) ?>
                        </button>
                        <? } ?>
                        <input type="hidden" id="qtdeNaoResp" value="<?= $questoesNaoResp ?>"/>
                        <br><br>
                        <table class="table-striped table-responsive table-hover text-center">
                            <th class='text-center' width="20%">Início</th>
                            <th class='text-center' width="20%">Término</th>
                            <th class='text-center' width="60%">Disciplina</th>

                            <?php
                            foreach ($qtdeQuestoesByDisc as $qqd) {
                                echo "<tr>";
                                echo "<td>" . $qqd['POSICAO_INICIAL'] . "</td>";
                                echo "<td>" . $qqd['POSICAO_FINAL'] . "</td>";
                                echo "<td>" . $qqd['NM_DISCIPLINA'] . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>

                    </div>

                    <div class="panel-footer text-center">
                        <a class="btn btn-default btn-xs"> &zwnj; </a> Não respondida | 
                        <a class="btn btn-success btn-xs"> &zwnj; </a> Respondida<br>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger2" data-dismiss="modal">
            <i class="fa fa-times"></i> Fechar
        </button>
    </div>
</div>