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

<br><br>
<input type="hidden" id="qtdeNaoResp" value="<?= $questoesNaoResp ?>"/>

<table class="table-striped table-responsive table-hover text-center">
    <th class='text-center' width="20%">Início</th>
    <th class='text-center' width="20%">Término</th>
    <th class='text-center' width="60%">Disciplina</th>
                          
    <?php
    foreach($qtdeQuestoesByDisc as $qqd){ 
        echo "<tr>";
        echo "<td>".$qqd['POSICAO_INICIAL']."</td>";
        echo "<td>".$qqd['POSICAO_FINAL']."</td>";
        echo "<td>".$qqd['NM_DISCIPLINA']."</td>";
        echo "</tr>";
    } 
    ?>
</table>