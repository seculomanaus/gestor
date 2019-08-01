<?php 

echo $titulo;

foreach($lista_pedidos_mantenedora as $row):
	echo "<a href='".base_url('dashboard/lista_pedidos_ccusto')."/".$row['CD_MANTENEDORA']."'>  ".$row['CD_MANTENEDORA']." - ".$row['NM_REDUZIDO_MAN']."    (".$row['TOTAL_PEDIDOS'].")</a><br>";

endforeach;


?>