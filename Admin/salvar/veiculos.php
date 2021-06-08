<?php
    if ( ! isset ( $_SESSION['submarino']['id'] ) ) exit;

    $usuario_id = ($_SESSION['submarino']['id']);
   
    if ( $_POST ) {

    	//print_r( $_POST );

    	//print_r( $_FILES );

    	//recuperar os dados dados

    	/*$id = "igor";

    	echo "<p>O valor de id é $id</p>";

    	$$id = "chimbinha";

    	echo "<p>O valor de igor é $igor $id</p>";

    	$$igor = "joelma";

    	echo "<p>O valor de chimbinha é $chimbinha</p>";*/


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
        if ( ( empty ( $id ) ) and ( empty ( $_FILES['fotoDestaque']['name'] ) ) ) {
            mensagem("Erro ao enviar imagem", 
                "Selecione um arquivo JPG válido", 
                "error");
        } 

        //se existir imagem - copia para o servidor
        if ( !empty ( $_FILES['fotoDestaque']['name'] ) ) {
            //calculo para saber quantos mb tem o arquivo
            $tamanho = $_FILES['fotoDestaque']['size'];
            $t = 8 * 1024 * 1024; //byte - kbyte - megabyte

            $fotoDestaque = time();
            $usuario = $_SESSION['submarino']['id'];

            //definir um nome para a imagem
            $fotoDestaque = "{$modelo}_{$fotoDestaque}_{$usuario}";

            //echo "<p>{$imagem}</p>"; exit;

            //validar se é jpg
            if ( $_FILES['fotoDestaque']['type'] != 'image/jpeg' ) {
                mensagem("Erro ao enviar imagem", 
                "O arquivo enviado não é um JPG válido, selecione um arquivo JPG", 
                "error");
            } else if ( $tamanho > $t ) {
                mensagem("Erro ao enviar imagem", 
                "O arquivo é muito grande e não pode ser enviado. Tente arquivos menores que 8 MB", 
                "error");
            } else if ( !copy ( $_FILES['fotoDestaque']['tmp_name'], '../produtos/'.$_FILES['fotoDestaque']['name'] ) ) {
                mensagem("Erro ao enviar imagem", 
                "Não foi possível copiar o arquivo para o servidor", 
                "error");
            }

            //redimensionar a imagem
            $pastaFotos = '../produtos/';
            loadImg($pastaFotos.$_FILES['fotoDestaque']['name'], 
                    $fotoDestaque, 
                    $pastaFotos);

        } //fim da verificação da foto

        //se vai dar insert ou update
        if ( empty ( $id ) ) {
            $usuario_id = ($_SESSION['submarino']['id']);
            $sql = "insert into veiculo values( NULL, :modelo, :anomodelo, :anofabricacao, :valor, :tipo, :fotoDestaque, :marca_id, :cor_id, :usuario_id, :opcionais )";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(':modelo', $modelo);
            $consulta->bindParam(':anomodelo', $anomodelo);
            $consulta->bindParam(':anofabricacao', $anofabricacao);
            $consulta->bindParam(':valor', $valor);
            $consulta->bindParam(':tipo', $tipo);
            $consulta->bindParam(':fotoDestaque', $fotoDestaque);
            $consulta->bindParam(':marca_id', $marca_id);
            $consulta->bindParam(':cor_id', $cor_id);
            $consulta->bindParam(':usuario_id', $usuario_id);
            $consulta->bindParam(':opcionais', $opcionais);

        } else if ( empty ( $imagem ) ) {
            $usuario_id = ($_SESSION['submarino']['id']);
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
            $usuario_id = ($_SESSION['submarino']['id']);
            $sql = "update veiculo set modelo = :modelo, anomodelo = :anomodelo, anofabricacao = :anofabricacao, valor = :valor, tipo = :tipo, fotoDestaque = :fotoDestaque, marca_id = :marca_id, cor_id = :cor_id, usuario_id = :usuario_id,  opcionais = :opcionais where id = :id limit 1";
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(':modelo', $modelo);
            $consulta->bindParam(':anomodelo', $anomodelo);
            $consulta->bindParam(':anofabricacao', $anofabricacao);
            $consulta->bindParam(':valor', $valor);
            $consulta->bindParam(':tipo', $tipo);
            $consulta->bindParam(':fotoDestaque', $fotoDestaque);
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