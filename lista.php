<?php
$listaCompras = [];

function handleFile() {
	$arquivo = file_get_contents("lista-compras.txt");

	$arrayListaDeCompras = unserialize($arquivo);

	if ($arrayListaDeCompras === false) {
        	return "Erro ao converter a lista de compras";
    	} 

	if (count($arrayListaDeCompras) == 0) {
        	return "A lista está vazia, não há itens para remover.\n";
    	}

	return $arrayListaDeCompras;
}

function adicionarItem($item) {
	global $listaCompras;

	array_push($listaCompras, $item);

	$arrayConvertido = serialize($listaCompras);

	$conteudo = file_put_contents("lista-compras.txt", $arrayConvertido);

	if ($conteudo == false) {
		return "Erro ao adicionar item no arquivo \n";
	}

	return "Item adicionado com sucesso \n";
}

function removerItem() {
	$resultado = handleFile();

	if (is_array($resultado)) {
		$item = array_pop($resultado);

   	 	$arquivoSalvo = file_put_contents("lista-compras.txt", serialize($resultado)); 

    		if ($arquivoSalvo === false) {
        		return "Falha ao remover $item da lista!\n";
    		}
	
        	return "$item removido da lista!\n";
	} else {
		echo $resultado;
	} 
}

function listarItens() {
	$resultado = handleFile();

	if (is_array($resultado)) {
		foreach ($resultado as $item) {
			echo " - " .$item . PHP_EOL;
		}
	}
	
}

while(true) {
	// Exibe o menu para o usuário
    	echo "Escolha uma opção:\n";
    	echo "1. Adicionar item\n";
    	echo "2. Remover item\n";
    	echo "3. Listar itens\n";
    	echo "4. Consultar quantidade\n";
    	echo "5. Sair\n";

	$opcao = readline("Digite uma opção: ");

	echo PHP_EOL;
	echo '------------------------------';
	echo PHP_EOL;

	if ($opcao == 0 || $opcao > 5) {
		echo "Opção inválida, digite alguma do menu. \n";
	}
	
	if ($opcao == 1) {
		$item = readline("Digite o nome do item: ");
		$mensagem = adicionarItem($item);
		
		echo $mensagem;
	}

	if ($opcao == 2) {
		$mensagem = removerItem();

		echo $mensagem;
	}

	if ($opcao == 3) {
		listarItens();
	}

	if ($opcao == 4) {
		exibirQuantidade();
	}

	if ($opcao == 5) {
		exit;
	}
}
