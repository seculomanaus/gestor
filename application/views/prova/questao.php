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


<?php if($this->session->userdata('SERIE') == 6 && ($materia == 'MATEMÁTICA' || $materia == 'PURTUGUÊS' || $materia == 'LING. PORTUGUESA - GRAM.')): ?>

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

<div id="PainelQuestaoID"  class="row" data-id="<?= $questao->POSICAO ?>"  data-questao="<?= $questao->CD_QUESTAO ?>">
    <div class="col-md-12 no-padding">
        <div class="hpanel hviolet">
            <div class="panel-heading">
                <h4><strong>DISCIPLINA: <?= $materia?> - SÉRIE: <?= $this->session->userdata('SERIE') ?>ª </strong></h4>
                <h5><?= $questao->POSICAO ?>ª Pergunta - VALOR DA QUESTÃO: <?= str_replace(".",",",$result[0]['VALOR']); ?> </h5>
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
           // $prova = new Prova_lib();
            //ISSUE 2019.03.20#01: Tratar perda de sessão do usuario, referente ao problema "Não exibe a nota do aluno"
            if (!(empty($this->session->userdata('CES_PROVA')) || empty($this->session->userdata('PVO_USER')))) {
            foreach($questao_posicao as $op){           
            $opc = $prova->resposta((($op['POSICAO']) ? $op['ORDEM_OPCAO'] : $op['POSICAO']));
            // if($op['FLG_CORRETA'] == 1)  $ret = ' data-master="'. $this->encrypt->encode($opc).'" ';


            $posicao =  $qtd[$op['POSICAO']-1];
            // if($qtd[$questao_posicao->posicao]['RESPOSTA'] == $opc) $res = ' checked="checked" '; else  $res = '' ;
            
            if($posicao['RESPOSTA'] == $opc) $res = ' checked="checked" '; else  $res = ''    ;

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

            <?php } } ?>
            
            <div id="POpcaoC" <?= $ret ?>></div>
        </div>
    </div>
</div>
<?php elseif($this->session->userdata('SERIE') == 6 && $materia == 'MATEMÁTICA'): ?>



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

<div id="PainelQuestaoID"  class="row" data-id="<?= $questao->POSICAO ?>"  data-questao="<?= $questao->CD_QUESTAO ?>">
    <div class="col-md-12 no-padding">
        <div class="hpanel hviolet">
            <div class="panel-heading">
                <h4><strong>DISCIPLINA: <?= $materia?> - SÉRIE: <?= $this->session->userdata('SERIE') ?>ª </strong></h4>
                <h5><?= $questao->POSICAO ?>ª Pergunta - VALOR DA QUESTÃO: <?= str_replace(".",",",$result[0]['VALOR']); ?> </h5>
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
           // $prova = new Prova_lib();
            //ISSUE 2019.03.20#01: Tratar perda de sessão do usuario, referente ao problema "Não exibe a nota do aluno"
            if (!(empty($this->session->userdata('CES_PROVA')) || empty($this->session->userdata('PVO_USER')))) {
            foreach($questao_posicao as $op){           
            $opc = $prova->resposta((($op['POSICAO']) ? $op['ORDEM_OPCAO'] : $op['POSICAO']));
            // if($op['FLG_CORRETA'] == 1)  $ret = ' data-master="'. $this->encrypt->encode($opc).'" ';


            $posicao =  $qtd[$op['POSICAO']-1];
            // if($qtd[$questao_posicao->posicao]['RESPOSTA'] == $opc) $res = ' checked="checked" '; else  $res = '' ;
            
            if($posicao['RESPOSTA'] == $opc) $res = ' checked="checked" '; else  $res = ''    ;

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

            <?php } } ?>
            
            <div id="POpcaoC" <?= $ret ?>></div>
        </div>
    </div>
</div>



<?php else: ?>


<div id="PainelQuestaoID"  class="row" data-id="<?= $questao->POSICAO ?>"  data-questao="<?= $questao->CD_QUESTAO ?>">
    <div class="col-md-12 no-padding">
        <div class="hpanel hviolet">
            <div class="panel-heading">
                <h4><strong>DISCIPLINA: <?= $materia?> - SÉRIE <?= $this->session->userdata('SERIE') ?>ª</strong></h4>
                <h5><?= $questao->POSICAO ?>ª Pergunta - VALOR DA QUESTÃO: <?= str_replace(".",",",$result[0]['VALOR']); ?> </h5>
            </div>
            <div class="panel-body" id='pergunta' style='font-size:15px; text-align: justify'>
                <?php
                $prova = new Prova_lib();
                //ISSUE 2019.03.20#01: Tratar perda de sessão do usuario, referente ao problema "Não exibe a nota do aluno"
                if (empty($this->session->userdata('CES_PROVA')) || empty($this->session->userdata('PVO_USER'))) {
                    echo 'Sua sessão expirou. Por favor faça o login novamente <a href="'.base_url('usuario/login').'">AQUI</a>';
                    //redirect("usuario/login");
                //Fim SOL 2019.03.20#01
                } else {
                    echo $prova->formata_texto_com_richtext($questao->DC_QUESTAO);
                }
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
            //ISSUE 2019.03.20#01: Tratar perda de sessão do usuario, referente ao problema "Não exibe a nota do aluno"
            if (!(empty($this->session->userdata('CES_PROVA')) || empty($this->session->userdata('PVO_USER')))) {
            foreach($questao_posicao as $op){           
            $opc = $prova->resposta((($op['POSICAO']) ? $op['ORDEM_OPCAO'] : $op['POSICAO']));
            // if($op['FLG_CORRETA'] == 1)  $ret = ' data-master="'. $this->encrypt->encode($opc).'" ';


            $posicao =  $qtd[$op['POSICAO']-1];
            // if($qtd[$questao_posicao->posicao]['RESPOSTA'] == $opc) $res = ' checked="checked" '; else  $res = '' ;
            
            if($posicao['RESPOSTA'] == $opc) $res = ' checked="checked" '; else  $res = ''    ;

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
                <input type="radio" name="rdResposta" class="i-checks" <?=$res ?> value="<?= $opc ?>" onclick="marcar(<?= $questao->POSICAO.",".$versao . "," . $op['CD_QUESTAO'] . ",'" . $opc . "'" ?>);">
                <?= $opc . ' ) ' . $prova->formata_texto_com_richtext_alternativa($op['DC_OPCAO']); ?>
            </div>
            
                <?php endif; ?>

            <?php } } ?>
            
            <div id="POpcaoC" <?= $ret ?>></div>
        </div>
    </div>
</div>




<?php endif; ?>

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