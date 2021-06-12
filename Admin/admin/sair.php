<?php

	//iniciar a sessao
	session_start();

	//apagar a sessao cherrymotors
	unset( $_SESSION['cherrymotors'] );

	//redirecionar para a página inicial
	header("Location: index.php");