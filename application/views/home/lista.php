<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script>
		/*function abrir(parametro){
			// console.log(parametro);

			var id = parametro;
			//console.log(id);



			// $.ajax({
			// 	url: "<?= base_url('dashboard/lista_total_pedidos_ccusto') ?>",
			// 	type: "POST",
			// 	data: {
			// 		prova: id
			// 	},
			// 	success: function(response){
			// 		console.log(response);
			// 	}

			// });


	        $.post("<?= base_url('dashboard/lista_total_pedidos_ccusto') ?>", {
	            id: id,
	        },
	        function(valor) {
	            //$("#tblFiltroFunc").html(valor);
	            console.log(valor);

	            var list_dados_pedido = $.parseJSON(valor);

	            $.each(list_dados_pedido,function(index, data){
	            	console.log(data.CD_PEDIDO);
	            	$("#list_dados_pedido").append(data.CD_PEDIDO);
	            });

	        });

			return false;
		}*/


		$(document).on('click','.link_pedido',function(e){
			cd_centro_custo = $(this).attr("id");

			console.log(cd_centro_custo);

		    $.post("<?= base_url('dashboard/lista_total_pedidos_ccusto') ?>", {
	            id: cd_centro_custo,
	        },
	        function(valor) {
	            console.log(valor);

	            /*var list_dados_pedido = $.parseJSON(valor);

	            $.each(list_dados_pedido,function(index, data){
	            	console.log(data.CD_PEDIDO);

	            	$("#list_dados_pedido"+cd_centro_custo).append("<input type='checkbox' name='pedido[]' id='"+data.CD_PEDIDO+"' value='"+data.VL_TOTAL_PEDIDO.replace(',','')+"'>  "+data.CD_PEDIDO+" - "+data.NM_FORNECEDOR+" "+data.DC_PEDIDO+" - "+data.VL_TOTAL_PEDIDO+"<br>");
	            });*/

	            $("#list_dados_pedido"+cd_centro_custo).html(valor);

	        });



			e.preventDefault();
		});


		$(document).on("click", "input[name='pedido[]']",function(){

			console.log(this.checked);

			id_pedido = $(this).attr("id");
   			
   			// if(this.checked){
    		// 	$("#list_dados_pedido"+id_pedido+" input:checkbox").prop("checked", true);
    		// 	$("#list_dados_pedido"+id_pedido+" input:checkbox").addClass("marcar");
    		// }else{
    		// 	$("#list_dados_pedido"+id_pedido+" input:checkbox").prop("checked", false);
    		// 	$("#list_dados_pedido"+id_pedido+" input:checkbox").removeClass("marcar");
    		// }


    		if(this.checked){
    			$(this).prop("checked", true);
    			$(this).addClass("marcar");
    		}else{
    			$(this).prop("checked", false);
    			$(this).removeClass("marcar");
    		}


			var total = 0;
			$(".marcar").each(function(){
				// console.log($(this).attr("value"));
				total += parseFloat($(this).attr("value")); 
			})
			console.log(total);
			$("#total_pedido").html("Total R$ "+total);

		});


		// function marcarTodos(marcardesmarcar){
		// 	this.checked = marcardesmarcar;
		// 	console.log(this.checked);

			// $("input:checked").each(function(){

			// });

	    //     $('.marcar').each(function () {
	    //         this.checked = marcardesmarcar;
	            
	    //         if(this.checked){
	    //        		console.log($("").attr("value"));
					// // var total = 0;

					// // $("input:checked").each(function(){
					// // 	total += parseFloat($(this).attr("value")); 
					// // });	     
					// // console.log(total);       	
	    //         }
	        
	    //     });
    	// }


    	$(document).on("click","input[name='marcarTodos']",function(){
    		//console.log("ok");

    		id_pedido = $(this).attr("id");

			// $.post("<?= base_url('dashboard/lista_total_pedidos_ccusto') ?>", {
	  //           id: id_pedido,
	  //       },
	  //       function(valor) {
	  //           console.log(valor);

	  //           var list_dados_pedido = $.parseJSON(valor);

	  //           $.each(list_dados_pedido,function(index, data){
	  //           	console.log(data.CD_PEDIDO);

	  //           	$("#list_dados_pedido"+id_pedido).append("<input type='checkbox' name='pedido[]' id='"+data.CD_PEDIDO+"' value='"+data.VL_TOTAL_PEDIDO.replace(',','')+"'>  "+data.CD_PEDIDO+" - "+data.NM_FORNECEDOR+" "+data.DC_PEDIDO+" - "+data.VL_TOTAL_PEDIDO+"<br>");
	  //           });

	  //       });




    		
    		if(this.checked){
    			$("#list_dados_pedido"+id_pedido+" input:checkbox").prop("checked", true);
    			$("#list_dados_pedido"+id_pedido+" input:checkbox").addClass("marcar");
    		}else{
    			$("#list_dados_pedido"+id_pedido+" input:checkbox").prop("checked", false);
    			$("#list_dados_pedido"+id_pedido+" input:checkbox").removeClass("marcar");
    		}

    		var total = 0;
    		$(".marcar").each(function(){
    			total += parseFloat($(this).attr("value"));
    		});
    		// console.log(this.checked);
    		// console.log(total);
    		$("#total_pedido").html("Total: R$ "+total);

		  // if ( $(this).is(':checked') ){
		  //   $('input:checkbox').prop("checked", true);
		  // }else{
		  //   $('input:checkbox').prop("checked", false);
		  // }

    	});
	</script>
</head>
<body>

<?php 
	
	
	foreach($lista_pedidos_ccusto as $row):
		//echo "<a href='javascript:void(0)' onclick='abrir(".$row['CD_CENTRO_CUSTO'].")'>".$row['NM_CENTRO_CUSTO']."(".$row['TOTAL_PEDIDOS'].")"." R$ ".$row['VL_TOTAL_PEDIDO']."</a><br>";

		echo "<br><input type='checkbox' name='marcarTodos' id='".$row['CD_CENTRO_CUSTO']."'><a href='#' id='".$row['CD_CENTRO_CUSTO']."' class='link_pedido'>".$row['NM_CENTRO_CUSTO']."  (".$row['TOTAL_PEDIDOS'].")  -  "." R$ ".$row['VL_TOTAL_PEDIDO']."</a><br><hr>";



		echo "<div id='list_dados_pedido".$row['CD_CENTRO_CUSTO']."'></div>";
	endforeach;

?>


<div id="total_pedido">Total R$ </div>

<a href="<?= base_url('dashboard/atualiza_status_pedido') ?>">Aprovar</a>
<a href="">Corrigir</a>
<a href="">Rejeitar</a>


</body>
</html>