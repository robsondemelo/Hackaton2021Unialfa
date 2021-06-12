<?php
    if ( ! isset ( $_SESSION['cherrymotors']['id'] ) ) exit;

    $modelo = $anomodelo = $anofabricacao = $valor = $tipo = $fotodestaque = $marca_id = $cor_id = $opcionais = NULL;
    $usuario_id = ($_SESSION['cherrymotors']['id']);

    //verificando se pegou o id de usuario da sessao
    //echo $usuario_id;


    //select para edição
    if ( ! empty ( $id ) ) {

        //sql para recuperar os dados daquele id
        $sql = "select * from veiculo where id = :id limit 1";
        //pdo - preparar
        $consulta = $pdo->prepare($sql);
        //passar um parametro - id
        $consulta->bindParam(':id', $id);
        //executar o sql
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        //recuperar os dados
        $modelo = $dados->modelo;
        $anomodelo = $dados->anomodelo;
        $anofabricacao = $dados->anofabricacao;
        $valor = formatarValorBR($dados->valor);
        $tipo = $dados->tipo;
        $fotodestaque = $dados->fotodestaque;
        $marca_id = $dados->marca_id;
        $cor_id = $dados->cor_id;
        $opcionais = $dados->opcionais;

    }

?>
<div class="card">
	<div class="card-header">
		<h3 class="float-left">Cadastro de Veiculos:</h3>
		<div class="float-right">
			<a href="cadastros/veiculos" class="btn btn-info">
        		<i class="fas fa-file"></i> Novo
        	</a>
        	<a href="listar/veiculos" class="btn btn-info">
        		<i class="fas fa-search"></i> Listar
        	</a>
		</div>
	</div>
	<div class="card-body">
		<form name="formCadastro" method="post" action="salvar/veiculos" data-parsley-validate="" enctype="multipart/form-data">
			
			<div class="row">
				<div class="col-12 col-md-2">
					<label for="id">ID:</label>
					<input type="text" name="id" id="id"
					class="form-control" readonly
					value="<?=$id?>">
				</div>
				<div class="col-12 col-md-10">
					<label for="modelo">Modelo do Veiculo*:</label>
					<input type="text" name="modelo"
					id="modelo" class="form-control" required data-parsley-required-message="Digite o nome do veiculo"
					value="<?=$modelo?>"  maxlength="200">
				</div>
				<div class="col-12 col-md-12">
					<label for="opcionais">Opcionais*:</label>
					<textarea name="opcionais" id="opcionais" class="form-control" required data-parsley-required-message="Digite os opcionais desse veiculo." rows="10"><?=$opcionais?></textarea>
				</div>
				<div class="col-12 col-md-4">
					<label for="valor">Valor do veiculo*:</label>
					<input type="text" name="valor" id="valor" class="form-control valor" required 
					data-parsley-required-message="Digite o valor do veiculo." inputmode="numeric" value="<?=$valor?>">
				</div>
				<div class="col-12 col-md-2">
					<label for="anofabricacao">Ano de Fabricação*:</label>
					<input type="text" name="anofabricacao" id="anofabricacao" class="form-control" required 
					data-parsley-required-message="Digite o ano de fabricação." inputmode="numeric" value="<?=$anofabricacao?>">
				</div>
				<div class="col-12 col-md-2">
					<label for="anomodelo">Ano Modelo*:</label>
					<input type="text" name="anomodelo" id="anomodelo" class="form-control" required 
					data-parsley-required-message="Digite o ano modelo." inputmode="numeric" value="<?=$anomodelo?>">
				</div>
				<div class="col-12 col-md-4">
					<?php

						$required = ' required data-parsley-required-message="Selecione um arquivo" ';
						$link = NULL;

						//verificar se a imagem não esta em branco
						if ( !empty ( $fotodestaque ) ) {
							//caminho para a imagem
							$img = "../produtos/{$fotodestaque}m.jpg";
							//criar um link para abrir a imagem
							$link = "<a href='{$img}' data-lightbox='foto' class='badge badge-success'>Abrir imagem</a>";
							$required = NULL;

						}

					?>
					<label for="fotodestaque">Imagem (JPG)* <?=$link?>:</label>
					<input type="file" name="fotodestaque" 
					id="fotodestaque" class="form-control"
					<?=$required?> accept="image/jpeg">
				</div>
				<div class="col-12 col-md-4">
					<label for="marca_id">Selecione uma Marca*:</label>
					<select name="marca_id" id="marca_id" class="form-control" required data-parsley-required-message="Selecione uma marca.">
						<option value=""></option>
						<?php
						//selecionar todas as marcas
						$sql = "select id, marca from marca order by marca";
						$consulta = $pdo->prepare($sql);
						$consulta->execute();

						while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {

							echo "<option value='{$dados->id}'>{$dados->marca}</option>";

						}

						?>
					</select>
				</div>
				<div class="col-12 col-md-4">
					<label for="cor_id">Selecione uma Cor*:</label>
					<select name="cor_id" id="cor_id" class="form-control" required data-parsley-required-message="Selecione uma cor.">
						<option value=""></option>
						<?php
						//selecionar todas as cores
						$sql = "select id, cor from cor order by cor";
						$consulta = $pdo->prepare($sql);
						$consulta->execute();

						while ( $dados = $consulta->fetch(PDO::FETCH_OBJ) ) {

							echo "<option value='{$dados->id}'>{$dados->cor}</option>";

						}

						?>
					</select>
				</div>
				<div class="col-12 col-md-4">
					<label for="tipo">Tipo de Veículo:</label>
					<select name="tipo" id="tipo" class="form-control" required data-parsley-required-message="Selecione uma opção.">
						<option value="">Selecione</option>
						<option value="novo">Novo</option>
						<option value="seminovo">Semi-novo</option>
					</select>
				</div>
			</div>

			<button type="submit" class="btn btn-success float-right">
				<i class="fas fa-check"></i> Salvar / Alterar
			</button>

			<br>
			<p>
				<small>* Obrigatório o preenchimento</small>
			</p>
		</form>
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#opcionais").summernote({
			height: '200px',
			lang: 'pt-BR',
			toolbar: [
	          ['style', ['style']],
	          ['font', ['bold', 'underline', 'clear']],
	          ['color', ['color']],
	          ['para', ['ul', 'ol', 'paragraph']],
	          ['table', ['table']],
	          ['insert', ['link', 'picture', 'video']],
	          ['view', ['codeview']]
	        ]
		});

		$(".valor").maskMoney({
			thousands: '.',
			decimal: ','
		});

		//selecionar os campos ao editar
		$("#marca_id").val(<?=$marca_id?>);
		$("#cor_id").val(<?=$cor_id?>);
		$("#tipo").val("<?=$tipo?>");
	})
</script>


