CREATE DATABASE FrezenDB;
USE FrezenDB;


DROP TABLE IF EXISTS `cliente`;
CREATE TABLE IF NOT EXISTS cliente (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `razaosocial` varchar(255) NOT NULL,
  `cnpj` varchar(25) NOT NULL,
  `cep` varchar(12) NOT NULL,
  `endereco` varchar(200) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `estado` varchar(100) NOT NULL,
  `contato_comercial` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `funcionario`;
CREATE TABLE IF NOT EXISTS `funcionario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `CPF` varchar(20) NOT NULL,
  `telefone` varchar(30) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `login` varchar(50) NOT NULL,
  `senha` varchar(50) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `proposta`;
CREATE TABLE IF NOT EXISTS `proposta` (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_usuario INT NOT NULL,
  path_pdf VARCHAR(255) NOT NULL,
  data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
  status ENUM('aberta', 'enviada', 'aceita', 'rejeitada', 'convertida_em_contrato') DEFAULT 'aberta',
  FOREIGN KEY (id_usuario) REFERENCES funcionario(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `contrato`;
CREATE TABLE `contrato` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `id_proposta` INT NULL,
    `path_pdf` VARCHAR(255),
    `data_criacao` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `data_fim` DATE NOT NULL,
    `status` ENUM('ativo','expirado','encerrado', 'cancelado') DEFAULT 'ativo',
    FOREIGN KEY (id_proposta) REFERENCES proposta(id)
);


DROP TABLE IF EXISTS `maquina`;
CREATE TABLE IF NOT EXISTS `maquina` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tipo` VARCHAR(50) NOT NULL,
    `modelo` VARCHAR(50) NOT NULL,
    `serie` VARCHAR(50) NOT NULL,
    `ano` INT NOT NULL,
    `horimetro` VARCHAR(20) NOT NULL,
    `marca` VARCHAR(50) NOT NULL,
    `capacidade_nominal` VARCHAR(20) NOT NULL,
    `torre` VARCHAR(50) NOT NULL,
    `direcao` VARCHAR(50) NOT NULL,
    `deslocador_lateral` CHAR(3) NOT NULL,  -- SIM / NAO
    `motor` VARCHAR(50) NOT NULL,
    `kit_iluminacao` CHAR(3) NOT NULL,
    `protetor_carga` CHAR(3) NOT NULL,
    `protetor_corrente` CHAR(3) NOT NULL,
    `altura_elevacao` VARCHAR(20) NOT NULL, 
    `alarme_re` CHAR(3) NOT NULL,
    `comprimento_garfo` VARCHAR(20) NOT NULL,
    `tipo_combustivel` VARCHAR(20) NOT NULL,
    `pneus` VARCHAR(50) NOT NULL,
    `cabine` CHAR(3) NOT NULL,
    `posicao_operador` VARCHAR(20) NOT NULL,
    `status` ENUM('disponível', 'pendente_proposta', 'em_uso', 'em_manutencao', 'inativa') DEFAULT 'disponível',
    `path_image` VARCHAR(100) NOT NULL,
    `image_date_upload` DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    `id_proposta` INT NULL,
    `id_contrato` INT NULL,
    `updated_status_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_proposta) REFERENCES proposta(id),
    FOREIGN KEY (id_contrato) REFERENCES contrato(id)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

CREATE TABLE proposta_maquina (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_proposta INT NOT NULL,
    id_maquina INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_proposta) REFERENCES proposta(id) ON DELETE CASCADE,
    FOREIGN KEY (id_maquina) REFERENCES maquina(id),

    UNIQUE KEY uk_proposta_maquina (id_proposta, id_maquina)
);

CREATE TABLE contrato_maquina (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_contrato INT NOT NULL,
    id_maquina INT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (id_contrato) REFERENCES contrato(id) ON DELETE CASCADE,
    FOREIGN KEY (id_maquina) REFERENCES maquina(id),

    UNIQUE KEY uk_contrato_maquina (id_contrato, id_maquina)
);




-- Dados de exemplo (fictícios) para testar o sistema após criar o schema
INSERT INTO `funcionario` (`id`, `nome`, `CPF`, `telefone`, `cargo`, `login`, `senha`) VALUES
(1, 'Admin', '00000000000', '00000000000', 'Programador', 'admin', '$2y$10$exemploHashDeSenhaSubstituirAoRodarLocalmenteXXXXXXX');

INSERT INTO `cliente` (`id`, `razaosocial`, `cnpj`, `cep`, `endereco`, `cidade`, `estado`, `contato_comercial`, `email`) VALUES
(1, 'Cliente Exemplo LTDA', '00000000000000', '00000-000', 'Rua Exemplo, 123', 'Cidade Exemplo', 'SC', '0000-0000', 'contato@exemplo.com');

INSERT INTO `maquina` (`tipo`, `modelo`, `serie`, `ano`, `horimetro`, `marca`, `capacidade_nominal`, `torre`, `direcao`, `deslocador_lateral`, `motor`, `kit_iluminacao`,
    `protetor_carga`,`protetor_corrente`, `altura_elevacao`, `alarme_re`, `comprimento_garfo`, `tipo_combustivel`, `pneus`, `cabine`, `posicao_operador`, `path_image`, `image_date_upload`) VALUES
('EMPILHADEIRA', 'H70FT', '0000', 2017, '0', 'HYSTER', '3000.00', 'TRIPLEX', 'Hidráulica', 'SIM', 'YANMAR', 'SIM', 'SIM', 'SIM', '4150.00', 'SIM', '1200.00',
'GLP', 'SUPERALÁSTICO', 'NÃO', 'SENTADO', '../../assets/upload/exemplo.png', NOW());

