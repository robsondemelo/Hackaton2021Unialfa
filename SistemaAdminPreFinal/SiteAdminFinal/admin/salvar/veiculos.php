<?php
    if ( ! isset ( $_SESSION['cherrymotors']['id'] ) ) exit;

    $usuario_id = ($_SESSION['cherrymotors']['id']);
   
    if ( $_POST ) {

    	include "libs/imagem.php";

    	foreach ($_POST as $key => $value) {
    		//echo "<p>{$key} - {$value}</p>";
    		$$key = trim ( $value );
    	}

    	if ( empty ( $modelo ) ) {
    		$titulo = "Erro ao salvar";
    		$mensagem = "Preencha o campo modelo.";
    		$icone = "error";

    		mensagem($titulo, $mensagem, $icone);
    	} else if ( empty ( $opcionais ) ) {
 
     		mensagem("Erro ao salvar", 
     			"Preencha os opcionais.", 
     			"error");
    	}

    	/*echo formatarValor($valor);

    	$v = "1.456,98";
    	echo "<br>".formatarValor($v);

    	echo "<br>".formatarValor('1.672,91');*/

    	$valor = formatarValor($valor);
    	
        //programação para copiar uma imagem
        //no insert envio da foto é obrigatório
        //no update só se for selecionada uma nova imagem

        //print_r ( $_FILES );

        //se o id estiver em branco e o imagem tbém - erro
        if ( ( empty ( $id ) ) and ( empty ( $_FILES['fotodestaque']['name'] ) ) ) {
            mensagem("Erro ao enviar imagem", 
                "Selecione um arquivo JPG válido", 
                "error");
        } 

        //se existir imagem - copia para o servidor
        if ( !empty ( $_FILES['fotodestaque']['name'] ) ) {
            //calculo para saber quantos mb tem o arquivo
            $tamanho = $_FILES['fotodestaque']['size'];
            $t = 8 * 1024 * 1024; //byte - kbyte - megabyte

            $fotodestaque = time();
            $usuario = $_SESSION['cherrymotors']['id'];

            //definir um nome para a imagem
            $fotodestaque = "{$modelo}_{$fotodestaque}_{$usuario}";

            //echo "<p>{$imagem}</p>"; exit;

            //validar se é jpg
            if ( $_FILES['fotodestaque']['type'] != 'image/jpeg' ) {
                mensagem("Erro ao enviar imagem", 
                "O arquivo enviado não é um JPG válido, selecione um arquivo JPG", 
                "error");
            } else if ( $tamanho > $t ) {
                mensagem("Erro ao enviar imagem", 
                "O arquivo é muito grande e não pode ser enviado. Tente arquivos menores que 8 MB", 
                "error");
            } else if ( !copy ( $_FILES['fotodestaque']['tmp_name'], '../src/main/resources/static/images/'.$_FILES['fotodestaque']['name'] ) ) {
                mensagem("Erro ao enviar imagem", 
                "Não foi possível copiar o arquivo para o servidor", 
                "error");
            }

            //redimensionar a imagem
            $pastaFotos = '../src/main/resources/static/images/';
            loadImg($pastaFotos.$_FILES['fotodestaque']['name'], 
                    $fotodestaque, 
                    $pastaFotos);

        } //fim da verificação da foto

        //se vai dar insert ou update
        if ( empty ( $id ) ) {
            $usuario_id = ($_SESSION['cherrymotors']['id']);
            $sql = "insert into veiculo values( NULL, :modelo, :anomodelo, :anofabricacao, :valor, :tipo, :fotodestaque, :marca_id, :cor_id, :usuario_id, :opcionais )";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(':modelo', $modelo);
            $consulta->bindParam(':anomodelo', $anomodelo);
            $consulta->bindParam(':anofabricacao', $anofabricacao);
            $consulta->bindParam(':valor', $valor);
            $consulta->bindParam(':tipo', $tipo);
            $consulta->bindParam(':fotodestaque', $fotodestaque);
            $consulta->bindParam(':marca_id', $marca_id);
            $consulta->bindParam(':cor_id', $cor_id);
            $consulta->bindParam(':usuario_id', $usuario_id);
            $consulta->bindParam(':opcionais', $opcionais);

        } else if ( empty ( $imagem ) ) {
            $usuario_id = ($_SESSION['cherrymotors']['id']);
            $sql = "update veiculo set modelo = :modelo, anomodelo = :anomodelo, anofabricacao = :anofabricacao, valor = :valor, tipo = :tipo, marca_id = :marca_id, cor_id = :cor_id, usuario_id = :usuario_id,  opcionais = :opcionais where id = :id limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(':modelo', $modelo);
            $consulta->bindParam(':anomodelo', $anomodelo);
            $consulta->bindParam(':anofabricacao', $anofabricacao);
            $consulta->bindParam(':valor', $valor);
            $consulta->bindParam(':tipo', $tipo);
            $consulta->bindParam(':marca_id', $marca_id);
            $consulta->bindParam(':cor_id', $cor_id);
            $consulta->bindParam(':usuario_id', $usuario_id);
            $consulta->bindParam(':opcionais', $opcionais);
            $consulta->bindParam(':id', $id);

        } else {
            $usuario_id = ($_SESSION['cherrymotors']['id']);
            $sql = "update veiculo set modelo = :modelo, anomodelo = :anomodelo, anofabricacao = :anofabricacao, valor = :valor, tipo = :tipo, fotodestaque = :fotodestaque, marca_id = :marca_id, cor_id = :cor_id, usuario_id = :usuario_id,  opcionais = :opcionais where id = :id limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(':modelo', $modelo);
            $consulta->bindParam(':anomodelo', $anomodelo);
            $consulta->bindParam(':anofabricacao', $anofabricacao);
            $consulta->bindParam(':valor', $valor);
            $consulta->bindParam(':tipo', $tipo);
            $consulta->bindParam(':fotodestaque', $fotodestaque);
            $consulta->bindParam(':marca_id', $marca_id);
            $consulta->bindParam(':cor_id', $cor_id);
            $consulta->bindParam(':usuario_id', $usuario_id);
            $consulta->bindParam(':opcionais', $opcionais);
            $consulta->bindParam(':id', $id);

        }

        //executar e verificar se foi salvo de verdade
        if ( $consulta->execute() ) {
            mensagem("OK", 
                "Registro salvo/alterado com sucesso!", 
                "ok");
        } else {
            echo $erro = $consulta->errorInfo()[2];

            mensagem("Erro", 
                "Erro ao salvar ou alterar registro", 
                "error");
        }


    }