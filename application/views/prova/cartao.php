Navegue entre as questões:
<br>
<?php
$questoesNaoResp = 0;
foreach($qtd as $q){ 
    if ($q['RESPOSTA'] == '') $questoesNaoResp++;  
    ?>                       
    <button onclick="questao(<?= $q['POSICAO'] ?>);" class="btn btn-<?= (($q['RESPOSTA'] == '') ? 'default' : 'success') ?> btn-xs" style="margin: 2px; padding: 5px">
        <?= ((($q['POSICAO']) == 1) ? $q['POSICAO'] : $q['POSICAO']) ?>
    </button>
    <? } ?>

<br><br>
<input type="hidden" id="qtdeNaoResp" value="<?= $questoesNaoResp ?>"/>

