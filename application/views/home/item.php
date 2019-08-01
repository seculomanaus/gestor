<?php
	foreach($lista_total_pedidos_ccusto as $key => $row):
	//echo $row['CD_PEDIDO'];
?>

<input type='checkbox' name='pedido[]' id='<?= $row['CD_PEDIDO'] ?>' value='<?= str_replace(",","",$row['VL_TOTAL_PEDIDO']) ?>'> 
<?= $row['CD_PEDIDO'] ?> - <?= $row['NM_FORNECEDOR'] ?> <?= $row['DC_PEDIDO'] ?> - <?= $row['VL_TOTAL_PEDIDO']?><br>

<?php 	endforeach; ?>

