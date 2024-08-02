<?php

$config = array(

	'login/index' => array(
			array('field'=>'inputCPF', 					'label'=>'CPF', 				'rules'=>'trim|required|callback__valid_cpf'),
			array('field'=>'inputSenha', 				'label'=>'Senha', 				'rules'=>'trim|required|callback__valid_senha'), 
	),
		
	'recuperar_senha/index' => array(
			array('field'=>'inputCPF', 					'label'=>'CPF', 				'rules'=>'trim|required|callback__valid_cpf|callback__check_cpf_usuario_inexistence'),
	),
		
	'usuario/novo' => array(
			array('field'=>'cpf',						'label'=>'CPF',					'rules'=>'callback__valid_cpf|trim|required'),
			array('field'=>'matricula',					'label'=>'Matrícula',			'rules'=>'trim|required'),
			array('field'=>'perfil',					'label'=>'perfil',			    'rules'=>'trim|required'),
			array('field'=>'nome',						'label'=>'Nome',				'rules'=>'trim|required'),
			array('field'=>'senha',						'label'=>'Senha',				'rules'=>'trim|required'),
			array('field'=>'email',						'label'=>'Email',				'rules'=>'valid_email|trim|required'),
			array('field'=>'telefone',					'label'=>'Telefone',			'rules'=>'trim|required'),
				
	),
		
	'usuario/pesquisar' => array(
			array('field'=>'nome',						'label'=>'Nome',					'rules'=>'required'),
	),
		
	'usuario/editar_usuario' => array(
			array('field'=>'cpf',						'label'=>'CPF',					'rules'=>'trim|required'),
			array('field'=>'matricula',					'label'=>'Matrícula',			'rules'=>'trim|required'),
			array('field'=>'nome',						'label'=>'Nome',				'rules'=>'trim|required'),
			array('field'=>'email',						'label'=>'Email',				'rules'=>'valid_email|trim|required'),
			array('field'=>'telefone',					'label'=>'Telefone',			'rules'=>'trim|required'),
		
	),
		
    'motorista/uso_veiculo' =>	array(
    		array('field'=>'motorista',					'label'=>'Motorista',					'rules'=>'trim|required'),
    		array('field'=>'horario_saida',				'label'=>'Horário de Saída',			'rules'=>'trim|required'),
    		array('field'=>'horario_retorno',			'label'=>'Horário de Retorno',			'rules'=>'trim|required'),
    		array('field'=>'veiculo_id',				'label'=>'Veículo',						'rules'=>'trim|required'),
    		array('field'=>'km_saida',					'label'=>'Quilometragem na saída',		'rules'=>'trim|required'),
    		array('field'=>'km_retorno',				'label'=>'Quilometragem no retorno',	'rules'=>'trim|required'),
	),	
	
	'motorista/cadastrar_motoristas' =>	array(
			array('field'=>'nome',						'label'=>'Nome do Motorista',			'rules'=>'trim|required'),
			array('field'=>'cpf',						'label'=>'CPF do Motorista',			'rules'=>'trim|required'),
			array('field'=>'cnh',						'label'=>'CNH',							'rules'=>'trim|required'),
			array('field'=>'validade_habilitacao',		'label'=>'Validade da Habilitação',		'rules'=>'trim|required'),
	),
	
	'motorista/editar_motorista' =>	array(
			array('field'=>'nome',						'label'=>'Nome do Motorista',			'rules'=>'trim|required'),
			array('field'=>'cpf',						'label'=>'CPF do Motorista',			'rules'=>'trim|required'),
			array('field'=>'cnh',						'label'=>'CNH',							'rules'=>'trim|required'),
			array('field'=>'validade_habilitacao',		'label'=>'Validade da Habilitação',		'rules'=>'trim|required'),
	),
		
	'relatorio/relatorio_uso_veiculo' =>	array(
			array('field'=>'veiculo',					'label'=>'Veículo',						'rules'=>'trim|required'),
			array('field'=>'data_inicial',				'label'=>'Data Inicial',				'rules'=>'trim|required'),
			array('field'=>'data_final',				'label'=>'Data Final',					'rules'=>'trim|required'),
	),
	
	'relatorio/relatorio_uso_motorista' =>	array(
			array('field'=>'motorista',					'label'=>'Motorista',					'rules'=>'trim|required'),
			array('field'=>'data_inicial',				'label'=>'Data Inicial',				'rules'=>'trim|required'),
			array('field'=>'data_final',				'label'=>'Data Final',					'rules'=>'trim|required'),
	),
		
	'motorista/pesquisar_motoristas' =>	array(
			array('field'=>'nome',						'label'=>'Nome',			'rules'=>'trim|required'),
	),

	'veiculo/cadastrar' => array(	
			array('field'=>'modelo',					'label'=>'Modelo',					'rules'=>'trim|required'),
			array('field'=>'placa',						'label'=>'Placa',					'rules'=>'trim|required'),
			array('field'=>'renavan',					'label'=>'Renavan',					'rules'=>'trim|required'),
			array('field'=>'chassi',					'label'=>'Chassi',					'rules'=>'trim|required'),
			array('field'=>'cor',						'label'=>'Cor',						'rules'=>'trim|required'),
			array('field'=>'ano',						'label'=>'Ano',						'rules'=>'trim|required'),
			array('field'=>'data_emplacamento',			'label'=>'Data Emplacamento',		'rules'=>'trim|required'),
			array('field'=>'combustivel',				'label'=>'Combustivel',				'rules'=>'trim|required'),
			array('field'=>'prox_licenciamento',		'label'=>'Próximo licenciamento',	'rules'=>'trim|required'),			
	),
	
    'veiculo/pesquisar' => array(
			array('field'=>'placa',						'label'=>'Placa',					'rules'=>'trim'),
	),
    
    'veiculo/editar' => array(
	        array('field'=>'modelo',					'label'=>'Modelo',					'rules'=>'trim|required'),
	        array('field'=>'placa',						'label'=>'Placa',					'rules'=>'trim|required'),
	        array('field'=>'cor',						'label'=>'Cor',						'rules'=>'trim|required'),
	        array('field'=>'ano',						'label'=>'Ano',						'rules'=>'trim|required'),
	        array('field'=>'data_emplacamento',			'label'=>'Data Emplacamento',		'rules'=>'trim|required'),
	        array('field'=>'combustivel',				'label'=>'Combustivel',				'rules'=>'trim|required'),
	        array('field'=>'prox_licenciamento',		'label'=>'Próximo licenciamento',	'rules'=>'trim|required'),
    ),

	'manutencao/cadastrar_manutencao' => array(
			array('field'=>'veiculo_id',				'label'=>'Placa',					'rules'=>'trim|required'),
			array('field'=>'data',						'label'=>'data',					'rules'=>'trim|required'),
			array('field'=>'resp_trans',				'label'=>'Valor',					'rules'=>'trim|required'),
			array('field'=>'oficina',					'label'=>'Quantidade',				'rules'=>'trim|required'),
			array('field'=>'resp_oficina',		        'label'=>'Observação',	            'rules'=>'trim|required'),
			array('field'=>'descricao',		            'label'=>'Observação',	            'rules'=>'trim|required'),
			array('field'=>'userfile',		            'label'=>'Arquivo',	         		'rules'=>'trim'),
	),
	
	'manutencao/pesquisar_manutencao' => array(
			array('field'=>'veiculo_id',			    'label'=>'Placa',					'rules'=>'required'),
				
	),
	
	'manutencao/editar_manutencao' => array(
			array('field'=>'data',						'label'=>'data',					'rules'=>'trim|required'),
			array('field'=>'resp_trans',				'label'=>'Valor',					'rules'=>'trim|required'),
			array('field'=>'oficina',					'label'=>'Oficina',					'rules'=>'trim|required'),
			array('field'=>'resp_oficina',		        'label'=>'Responsavel ',	        'rules'=>'trim|required'),
			array('field'=>'descricao',		            'label'=>'Observação',				'rules'=>'trim|required'),
			array('field'=>'userfile',		            'label'=>'Arquivo',	       			'rules'=>'trim'),
	),
	'abastecimento/cadastrar_abastecimento' => array(
			array('field'=>'veiculo_id',				'label'=>'Placa',					'rules'=>'trim|required'),
			array('field'=>'data',						'label'=>'Mês de Cadastro',					'rules'=>'trim|required'),
			array('field'=>'valor',					    'label'=>'Valor',					'rules'=>'trim|required'),
			array('field'=>'userfile',		            'label'=>'Arquivo',	         		'rules'=>'trim')
	),
		
	'abastecimento/pesquisar_abastecimento' => array(
			array('field'=>'veiculo_id',			    'label'=>'Placa',					'rules'=>'required'),
	),
		
	'abastecimento/editar_abastecimento' => array(
			array('field'=>'data',						'label'=>'Mês de Cadastro',					'rules'=>'trim|required'),
			array('field'=>'valor',				        'label'=>'Valor',					'rules'=>'trim|required'),
			array('field'=>'userfile',		            'label'=>'Arquivo',	       			'rules'=>'trim'),
	),
		
	'relatorio/relatorio_veiculo' => array(
			array('field'=>'veiculo_id',				'label'=>'Placa',					'rules'=>'trim|required'),
	),
	
	'relatorio/relatorio_manutencao' => array(
			array('field'=>'veiculo_id',			'label'=>'Placa',					 	'rules'=>'trim|required'),
			array('field'=>'data_inicial',			'label'=>'Data Inicial',				'rules'=>'trim|required'),
			array('field'=>'data_final',			'label'=>'Data Final',					'rules'=>'trim|required'),
	),
	
		'relatorio/relatorio_abastecimento' => array(
				array('field'=>'veiculo_id',			'label'=>'Placa',					'rules'=>'trim|required'),
				array('field'=>'data_inicial',			'label'=>'Mês Inicial',			'rules'=>'trim|required'),
				array('field'=>'data_final',			'label'=>'Mês Final',				'rules'=>'trim|required'),
	),
		'relatorio/relatorio_operacional' => array(
				array('field'=>'veiculo_id',			'label'=>'Placa',					'rules'=>'trim|required'),
				array('field'=>'data_inicial',			'label'=>'Data Inicial',			'rules'=>'trim|required'),
				array('field'=>'data_final',			'label'=>'Data Final',				'rules'=>'trim|required'),
	),
		
);
