SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE usuario (
  id int(11) NOT NULL AUTO_INCREMENT,
  tipo tinyint(1) NOT NULL COMMENT '1 - Administrador; 2 - Gerente; 3 - Atendente; 4 - Consumidor',
  nome varchar(255) NOT NULL,
  cpf varchar(11) NOT NULL,
  email varchar(255) NOT NULL,
  senha varchar(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY email (email)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO usuario (id, tipo, nome, cpf, email, senha) VALUES
(1, 1, 'Paulo Egito', '11111111111', 'paulo@agenciabiro.com.br', '202cb962ac59075b964b07152d234b70'),
(2, 1, 'Tiago Freire', '22222222222', 'tiago@agenciabiro.com.br', '202cb962ac59075b964b07152d234b70');

CREATE TABLE administrador (
  id int(11) NOT NULL AUTO_INCREMENT,
  usuario_id int(11) NOT NULL,
  nome varchar(200) NOT NULL,
  login varchar(50) NOT NULL,
  senha varchar(32) NOT NULL,
  PRIMARY KEY (id),
  KEY usuario_id (usuario_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO administrador (id, usuario_id, nome, login, senha) VALUES
(1, 1, 'Paulo Egito', 'pvegito', '53e2ddad2909445819367acc79fe2cc9'),
(4, 1, 'Novoooo', 'Novaoo', '93b8004c63cb098c7c7cf5ca98d9898b'),
(5, 2, 'Maluki', 'maluki', 'eccbc87e4b5ce2fe28308fd9f2a7baf3');

CREATE TABLE bairro (
  id int(11) NOT NULL AUTO_INCREMENT,
  nome varchar(100) NOT NULL,
  cidade_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY bairro_ibfk_1 (cidade_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO bairro (id, nome, cidade_id) VALUES
(2, 'Capim Macio', 1),
(3, 'Lagoa Nova', 1),
(4, 'Candel&aacute;ria', 1),
(6, 'Barro Vermelh&atilde;o', 2),
(11, 'Camboinha', 2),
(12, 'Cristo Redentor', 2),
(13, 'bairro de campina', 4),
(15, 'Redinha', 1);

CREATE TABLE cidade (
  id int(11) NOT NULL AUTO_INCREMENT,
  nome varchar(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO cidade (id, nome) VALUES
(1, 'Natal'),
(2, 'Jo&atilde;o Pessoa'),
(4, 'Campina Grande');

CREATE TABLE consumidor (
  id int(11) NOT NULL AUTO_INCREMENT,
  usuario_id int(11) NOT NULL,
  nome varchar(500) NOT NULL,
  login varchar(500) NOT NULL,
  senha varchar(32) NOT NULL,
  ativo tinyint(1) unsigned NOT NULL DEFAULT '0',
  cpf varchar(15) NOT NULL,
  email varchar(200) NOT NULL,
  data_nascimento varchar(10) NOT NULL,
  sexo varchar(10) NOT NULL,
  PRIMARY KEY (id),
  KEY usuario_id (usuario_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO consumidor (id, usuario_id, nome, login, senha, ativo, cpf, email, data_nascimento, sexo) VALUES
(3, 1, 'Paulo Egito', 'pvegito@hotmail.com', '182be0c5cdcd5072bb1864cdee4d3d6e', 0, '63463447', 'pvuhsiuhf@hotmail', '1243243', 'Masculino');

CREATE TABLE endereco_consumidor (
  id int(11) NOT NULL AUTO_INCREMENT,
  consumidor_id int(11) NOT NULL,
  logradouro varchar(300) NOT NULL,
  bairro_id int(11) NOT NULL,
  favorito tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  KEY consumidor_id (consumidor_id),
  KEY bairro_id (bairro_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO endereco_consumidor (id, consumidor_id, logradouro, bairro_id, favorito) VALUES
(1, 3, 'Rua dos Mosquitos', 4, 1);

CREATE TABLE pedido (
  id int(11) NOT NULL AUTO_INCREMENT,
  consumidor_id int(11) NOT NULL,
  restaurante_id int(11) NOT NULL,
  quando datetime NOT NULL,
  forma_pagamento varchar(50) NOT NULL,
  preco int(11) NOT NULL,
  troco int(11) NOT NULL,
  cupom varchar(200) NOT NULL,
  endereco varchar(1000) NOT NULL,
  situacao varchar(100) NOT NULL,
  pagamento_efetuado tinyint(1) NOT NULL,
  PRIMARY KEY (id),
  KEY consumidor_id (consumidor_id),
  KEY restaurante_id (restaurante_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO pedido (id, consumidor_id, restaurante_id, quando, forma_pagamento, preco, troco, cupom, endereco, situacao, pagamento_efetuado) VALUES
(3, 3, 2, '2011-10-11 10:47:32', '', 0, 0, '', '', '', 0),
(5, 3, 1, '2011-10-11 14:21:36', '', 0, 0, '', '', '', 1);

CREATE TABLE pedido_tem_produto (
  id int(11) NOT NULL AUTO_INCREMENT,
  pedido_id int(11) NOT NULL,
  produto_id int(11) NOT NULL,
  qtd int(11) NOT NULL,
  obs varchar(500) NOT NULL,
  tamanho varchar(20) NOT NULL,
  produto_id2 int(11) DEFAULT NULL COMMENT 'usado geralmente pra segundo sabor de pizzas',
  PRIMARY KEY (id),
  KEY pedido_id (pedido_id),
  KEY produto_id (produto_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO pedido_tem_produto (id, pedido_id, produto_id, qtd, obs, tamanho, produto_id2) VALUES
(3, 3, 1, 7, '', 'Pequena', 0),
(5, 5, 4, 0, '', '', 0);

CREATE TABLE pedido_tem_produto_adicional (
  id int(11) NOT NULL AUTO_INCREMENT,
  pedidotemproduto_id int(11) NOT NULL,
  produtoadicional_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY pedidotemproduto_id (pedidotemproduto_id),
  KEY produtoadicional_id (produtoadicional_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO pedido_tem_produto_adicional (id, pedidotemproduto_id, produtoadicional_id) VALUES
(3, 3, 1);

CREATE TABLE produto (
  id int(11) NOT NULL AUTO_INCREMENT,
  nome varchar(200) NOT NULL,
  preco int(11) NOT NULL,
  disponivel tinyint(1) NOT NULL,
  esta_em_promocao tinyint(1) NOT NULL,
  preco_promocional int(11) NOT NULL,
  descricao varchar(2000) NOT NULL,
  qtd_produto_adicional int(11) NOT NULL,
  restaurante_id int(11) NOT NULL,
  codigo varchar(100) NOT NULL,
  texto_promocao varchar(500) NOT NULL,
  ativo tinyint(1) NOT NULL,
  tamanho varchar(20) NOT NULL,
  PRIMARY KEY (id),
  KEY restaurante_id (restaurante_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO produto (id, nome, preco, disponivel, esta_em_promocao, preco_promocional, descricao, qtd_produto_adicional, restaurante_id, codigo, texto_promocao, ativo, tamanho) VALUES
(1, 'BigMac', 1000, 1, 0, 0, 'Grande BigMac!!!', 0, 2, '4405', '', 0, ''),
(3, 'Pizza Mussarela', 2000, 1, 0, 1500, 'Pizza feita com queijo mussarela.', 0, 1, '333', 'promo texto', 1, ''),
(4, 'Pizza Frango Catupiry', 3000, 1, 0, 2200, 'Pizza feita com queijo mussarela, frango e catupiry.', 0, 1, '334', '', 0, ''),
(8, 'Camarao Irado', 2000, 1, 1, 0, '', 0, 9, '', '', 1, 'GIGANTEEE'),
(9, 'teste', 34, 1, 0, 0, '', 0, 6, '', '', 1, ''),
(10, 'Picanha com queijo', 36, 1, 0, 0, '', 0, 1, '', '', 1, '');

CREATE TABLE produto_adicional (
  id int(11) NOT NULL AUTO_INCREMENT,
  nome varchar(200) NOT NULL,
  preco_adicional int(11) NOT NULL,
  disponivel int(11) NOT NULL,
  quantas_unidades_ocupa int(11) NOT NULL DEFAULT '1',
  restaurante_id int(11) NOT NULL,
  ativo tinyint(1) NOT NULL,
  PRIMARY KEY (id),
  KEY restaurante_id (restaurante_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO produto_adicional (id, nome, preco_adicional, disponivel, quantas_unidades_ocupa, restaurante_id, ativo) VALUES
(1, 'arroz', 0, 1, 1, 1, 1),
(3, 'rsdbrdsrds', 0, 0, 1, 1, 1),
(4, 'brdsrdsrds', 0, 1, 1, 1, 0),
(5, 'Borda Recheada com Catupiry', 0, 1, 1, 1, 1),
(6, 'arroz', 0, 1, 1, 9, 1),
(7, 'purê', 0, 1, 1, 9, 1),
(8, 'feijão', 0, 1, 1, 9, 1);

CREATE TABLE produto_tem_produto_adicional (
  id int(11) NOT NULL AUTO_INCREMENT,
  produtoadicional_id int(11) NOT NULL,
  produto_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY produto_adicional_id (produtoadicional_id),
  KEY produto_id (produto_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO produto_tem_produto_adicional (id, produtoadicional_id, produto_id) VALUES
(11, 5, 4),
(12, 5, 3),
(14, 7, 8),
(15, 1, 10),
(17, 3, 10),
(18, 4, 10);

CREATE TABLE produto_tem_tipo (
  id int(11) NOT NULL AUTO_INCREMENT,
  tipoproduto_id int(11) NOT NULL,
  produto_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY tipo_id (tipoproduto_id),
  KEY produto_id (produto_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO produto_tem_tipo (id, tipoproduto_id, produto_id) VALUES
(1, 9, 1),
(2, 1, 1),
(4, 2, 4),
(5, 4, 3),
(6, 2, 3),
(7, 10, 4),
(8, 10, 1),
(9, 10, 10);

CREATE TABLE restaurante (
  id int(11) NOT NULL AUTO_INCREMENT,
  nome varchar(200) NOT NULL,
  cidade_id int(11) NOT NULL,
  endereco varchar(1000) NOT NULL,
  administrador_cadastrou_id int(11) NOT NULL,
  ativo tinyint(1) unsigned NOT NULL DEFAULT '0',
  desativado tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (id),
  KEY cidade_id (cidade_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO restaurante (id, nome, cidade_id, endereco, administrador_cadastrou_id, ativo, desativado) VALUES
(1, 'Bari Palesi', 1, 'Av. Engenheiro Roberto Freire, 564 - Capim Macio', 1, 0, 0),
(2, 'MC Donalds', 1, 'Rua Salgado Filho, numero 6576 - Natal Shopping - Candel&aacute;ria', 1, 0, 0),
(3, 'Bobs', 1, 'Av. Salgado Filho, 670 - Lagoa Nova', 1, 0, 0),
(4, 'Pastel Paulista', 2, 'Av. Eng. Roberto Freire, 800 - Capim Macio', 5, 0, 1),
(6, 'pensilvanio', 1, 'rua do cacete amarelo', 1, 0, 0),
(9, 'Bonaparte', 1, 'lbalbalabla', 1, 1, 0);

CREATE TABLE restaurante_atende_bairro (
  id int(11) NOT NULL AUTO_INCREMENT,
  restaurante_id int(11) NOT NULL,
  bairro_id int(11) NOT NULL,
  preco_entrega int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY restaurante_id (restaurante_id),
  KEY bairro_id (bairro_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO restaurante_atende_bairro (id, restaurante_id, bairro_id, preco_entrega) VALUES
(5, 2, 3, 200),
(6, 2, 4, 800),
(8, 2, 6, 400),
(9, 3, 11, 1300),
(11, 1, 3, 100),
(13, 1, 4, 200),
(15, 1, 15, 100),
(16, 4, 11, 1),
(17, 4, 12, 2),
(18, 4, 6, 3),
(19, 6, 4, 1),
(21, 6, 3, 3),
(22, 6, 15, 4);

CREATE TABLE restaurante_tem_tipo (
  id int(11) NOT NULL AUTO_INCREMENT,
  restaurante_id int(11) NOT NULL,
  tiporestaurante_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY restaurante_id (restaurante_id),
  KEY tipo_id (tiporestaurante_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO restaurante_tem_tipo (id, restaurante_id, tiporestaurante_id) VALUES
(1, 2, 3),
(2, 1, 1),
(4, 1, 4),
(5, 3, 2);

CREATE TABLE restaurante_tem_tipo_produto (
  id int(11) NOT NULL AUTO_INCREMENT,
  restaurante_id int(11) NOT NULL,
  tipoproduto_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY restaurante_id (restaurante_id),
  KEY tipo_id (tipoproduto_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO restaurante_tem_tipo_produto (id, restaurante_id, tipoproduto_id) VALUES
(2, 3, 9);

CREATE TABLE telefone_consumidor (
  id int(11) NOT NULL AUTO_INCREMENT,
  consumidor_id int(11) NOT NULL,
  numero varchar(20) NOT NULL,
  PRIMARY KEY (id),
  KEY consumidor_id (consumidor_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO telefone_consumidor (id, consumidor_id, numero) VALUES
(1, 3, '3642-1341');

CREATE TABLE tipo_produto (
  id int(11) NOT NULL AUTO_INCREMENT,
  nome varchar(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO tipo_produto (id, nome) VALUES
(1, 'Sanduiche'),
(2, 'Pizza'),
(4, 'Comida Italiana'),
(9, 'Sanduba Esperto'),
(10, 'Carnes'),
(11, 'Chinesa');

CREATE TABLE tipo_restaurante (
  id int(11) NOT NULL AUTO_INCREMENT,
  nome varchar(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO tipo_restaurante (id, nome) VALUES
(1, 'Pizzaria'),
(2, 'Sanduicheria'),
(3, 'Restaurante'),
(4, 'Comida Italiana');

CREATE TABLE usuario_restaurante (
  id int(11) NOT NULL AUTO_INCREMENT,
  usuario_id int(11) NOT NULL,
  nome varchar(200) NOT NULL,
  restaurante_id int(11) NOT NULL,
  login varchar(100) NOT NULL,
  senha varchar(32) NOT NULL,
  perfil int(1) NOT NULL,
  PRIMARY KEY (id),
  KEY restaurante_id (restaurante_id),
  KEY usuario_id (usuario_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

INSERT INTO usuario_restaurante (id, usuario_id, nome, restaurante_id, login, senha, perfil) VALUES
(4, 1, 'manda-shuva do bonaparte', 9, 'bona', 'd3d9446802a44259755d38e6d163e820', 1),
(6, 2, 'joahsg', 1, 'rrr', 'c4ca4238a0b923820dcc509a6f75849b', 2);


ALTER TABLE `bairro`
  ADD CONSTRAINT bairro_ibfk_1 FOREIGN KEY (cidade_id) REFERENCES cidade (id);
  
ALTER TABLE `administrador`
  ADD CONSTRAINT administrador_usuario_id FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `consumidor`
  ADD CONSTRAINT consumidor_usuario_id FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `usuario_restaurante`
  ADD CONSTRAINT usuario_restaurante_usuario_id FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `endereco_consumidor`
  ADD CONSTRAINT endereco_consumidor_ibfk_1 FOREIGN KEY (consumidor_id) REFERENCES consumidor (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT endereco_consumidor_ibfk_2 FOREIGN KEY (bairro_id) REFERENCES bairro (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `pedido`
  ADD CONSTRAINT pedido_ibfk_1 FOREIGN KEY (consumidor_id) REFERENCES consumidor (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT pedido_ibfk_2 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `pedido_tem_produto`
  ADD CONSTRAINT pedido_tem_produto_ibfk_1 FOREIGN KEY (pedido_id) REFERENCES pedido (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT pedido_tem_produto_ibfk_2 FOREIGN KEY (produto_id) REFERENCES produto (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `pedido_tem_produto_adicional`
  ADD CONSTRAINT pedido_tem_produto_adicional_ibfk_1 FOREIGN KEY (pedidotemproduto_id) REFERENCES pedido_tem_produto (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT pedido_tem_produto_adicional_ibfk_2 FOREIGN KEY (produtoadicional_id) REFERENCES produto_adicional (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `produto`
  ADD CONSTRAINT produto_ibfk_1 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `produto_tem_tipo`
  ADD CONSTRAINT produto_tem_tipoibfk_1 FOREIGN KEY (produto_id) REFERENCES produto (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT produto_tem_tipoibfk_2 FOREIGN KEY (tipoproduto_id) REFERENCES tipo_produto (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `telefone_consumidor`
  ADD CONSTRAINT telefone_consumidor_ibfk_1 FOREIGN KEY (consumidor_id) REFERENCES consumidor (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `usuario_restaurante`
  ADD CONSTRAINT usuario_restaurante_ibfk_1 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id) ON DELETE CASCADE ON UPDATE CASCADE;
