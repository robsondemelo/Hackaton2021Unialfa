<?php
	session_start();

	if ( ! isset ( $_SESSION['cherrymotors']['id'] ) ) exit;
?>
<!DOCTYPE html>
<html>
<head>
	<title>Relatório de Vendas</title>
	<meta charset="utf-8">

	<!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    
	<link rel="stylesheet" type="text/css" href="css/sb-admin-2.min.css">
	<link rel="stylesheet" type="text/css" href="css/sweetalert2.min.css">

	<link rel="stylesheet" type="text/css" href="css/style.css">

	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="js/sweetalert2.js"></script>
</head>
<body>
	<?php 

		//incluir conexao com o banco
		include "libs/conectar.php";
		include "libs/docs.php";

		//recuperar os dados digitados
		$dataInicial = trim ( $_POST["dataInicial"] ?? NULL);
		$dataFinal = trim ( $_POST["dataFinal"] ?? NULL );
		$filtro = trim ( $_POST["filtro"] ?? NULL );

		//verificar se as datas foram preenchidas
		if ( ( empty ( $dataInicial ) ) or ( empty ( $dataFinal ) ) ) {

			mensagem("Erro", "Digite as datas", "error");
			exit;

		}
		else if ( strtotime( $dataInicial ) > strtotime( $dataFinal ) ) {

			mensagem("Erro","Data final menor que a data inicial","error");
			exit;

		}
		
		

	?>

	<h1 class="text-center">Relatório de Vendas</h1>

	<a href="javascript:window.print()" class="btn btn-success float-right">
		<i class="fas fa-print"></i>
		Imprimir
	</a>

	<table class="table table-hover table-striped table-bordered">
		<thead>
			<th width="5%">ID</th>
			<th width="45%">Nome do Cliente</th>
			<th width="20%">Data</th>
			<th width="15%">Status</th>
			<th width="15%">Total</th>
		</thead>
		<tbody>
			<?php

				//sql para selecionar as vendas
				//data maior que a dataInicial
				//dataFinal seja menor que a data
				$sql = "select v.id, c.nome, v.status, 
				date_format(v.data, '%d/%m/%Y') data 
				from venda v 
				inner join cliente c on (c.id = v.cliente_id)
				where v.data >= :dataInicial AND v.data <= :dataFinal 
				order by v.data";
				$consulta = $pdo->prepare($sql);
				$consulta->bindParam(":dataInicial", $dataInicial);
				$consulta->bindParam(":dataFinal", $dataFinal);
				$consulta->execute();

				while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {

					//status
					if ( $dados->status == "P" ) {
						$status = '<span class="badge badge-success">Pago</span>';

					} else if ( $dados->status == "C" ) {
						$status = '<span class="badge badge-warning">Cancelado</span>';

					} else if ( $dados->status == "D" ) {
						$status = '<span class="badge badge-danger">Devolvido</span>';

					} else if ( $dados->status == "E" ) {
						$status = '<span class="badge badge-info">Extraviado</span>';

					} else if ( $dados->status == "A" ) {
						$status = '<span class="badge badge-primary">Aguardando Pagamento</span>';

					} else if ( $dados->status == "T" ) {
						$status = '<span class="badge badge-andrey">Troca</span>';
					} 


					?>
					<tr>
						<td><?=$dados->id?></td>
						<td><?=$dados->nome?></td>
						<td><?=$dados->data?></td>
						<td><?=$status?></td>
						<td class="text-center">R$ <?=getTotal($pdo,$dados->id)?></td>
					</tr>
					<?php

				}

			?>
		</tbody>
	</table>
</body>
</html>
