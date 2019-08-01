<div id="PainelQuestaoID"  class="row" data-id="<?= $questao->POSICAO ?>"  data-questao="<?= $questao->CD_QUESTAO ?>">
    <div class="col-md-12 no-padding">
        <div class="hpanel hviolet">
            <div class="panel-heading">
                <h4><strong>DISCIPLINA: <?= $questao->NM_DISCIPLINA?></strong></h4>
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
            <?php
            foreach($opcao as $op){
            $opc = $prova->resposta((($op['POSICAO'] == '') ? $op['CD_OPCAO'] : $op['POSICAO']));
            if($op['FLG_CORRETA'] == 1)  $ret = ' data-master="'.$opc.'" ';

            if($questao->RESPOSTA == $opc) $res = ' checked="checked" '; else  $res = '' ;

            ?>
            <div  class="panel-footer" style='font-size:15px'>
                <?= $opc . ' ) ' . $op['DC_OPCAO']->load() ?>
            </div>
            <?php } ?>
            <div id="PainelOpcaoCorreta" <?= $ret ?>></div>
        </div>
    </div>
</div>