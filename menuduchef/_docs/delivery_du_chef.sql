
SET FOREIGN_KEY_CHECKS=0;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

SET AUTOCOMMIT=0;
START TRANSACTION;




DROP TABLE IF EXISTS administrador;
CREATE TABLE administrador (
  id int(11) NOT NULL AUTO_INCREMENT,
  usuario_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY usuario_id (usuario_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


INSERT INTO administrador (id, usuario_id) VALUES
(1, 1),
(3, 2),
(11, 10),
(13, 12),
(14, 13);



DROP TABLE IF EXISTS bairro;
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
(15, 'Redinha', 1),
(16, 'ch�o de giz', 2);



DROP TABLE IF EXISTS cidade;
CREATE TABLE cidade (
  id int(11) NOT NULL AUTO_INCREMENT,
  nome varchar(100) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


INSERT INTO cidade (id, nome) VALUES
(1, 'Natal'),
(2, 'Jo&atilde;o Pessoa'),
(4, 'Campina Grande');



DROP TABLE IF EXISTS consumidor;
CREATE TABLE consumidor (
  id int(11) NOT NULL AUTO_INCREMENT,
  usuario_id int(11) NOT NULL,
  ativo tinyint(1) unsigned NOT NULL DEFAULT '0',
  cpf varchar(15) NOT NULL,
  data_nascimento varchar(10) NOT NULL,
  sexo varchar(10) NOT NULL,
  PRIMARY KEY (id),
  KEY usuario_id (usuario_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


INSERT INTO consumidor (id, usuario_id, ativo, cpf, data_nascimento, sexo) VALUES
(1, 3, 1, '63463447', '1243243', 'Masculino');



DROP TABLE IF EXISTS endereco_consumidor;
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
(1, 1, 'Rua dos Mosquitos', 4, 1);



DROP TABLE IF EXISTS pedido;
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
(3, 1, 2, '2011-10-26 14:24:42', '$$$$$$$$$$$$$$$', 0, 0, '', 'rhrhsdrdsrs', '', 0),
(5, 1, 1, '2011-10-11 14:21:36', '', 0, 0, '', '', '', 1),
(6, 1, 2, '2011-10-26 13:41:37', 'Barras de Ouro', 0, 0, '', '', '', 1),
(7, 1, 2, '2011-10-26 13:45:31', 'Cartaoe', 0, 0, '', '', '', 1),
(8, 1, 2, '2011-10-26 11:17:19', 'Cartiones de Creditis', 0, 0, '', '', 'a situacao ta foda mano', 1),
(9, 1, 4, '2011-10-26 14:23:48', 'nenhuma', 0, 0, '', '', '', 1),
(10, 1, 2, '2011-10-27 05:07:21', 'DInheiro', 0, 0, '', '', '', 1),
(11, 1, 1, '2011-10-27 06:24:54', 'Dinheiro', 0, 0, '', '', '', 1);



DROP TABLE IF EXISTS pedido_tem_produto;
CREATE TABLE pedido_tem_produto (
  id int(11) NOT NULL AUTO_INCREMENT,
  pedido_id int(11) NOT NULL,
  produto_id int(11) NOT NULL,
  qtd int(11) NOT NULL,
  obs varchar(500) NOT NULL,
  tamanho varchar(20) NOT NULL,
  produto_id2 int(11) DEFAULT NULL COMMENT 'usado geralmente pra segundo sabor de pizzas',
  produto_id3 int(11) DEFAULT NULL,
  produto_id4 int(11) DEFAULT NULL,
  preco_unitario int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY pedido_id (pedido_id),
  KEY produto_id2 (produto_id2),
  KEY produto_id3 (produto_id3),
  KEY produto_id4 (produto_id4)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


INSERT INTO pedido_tem_produto (id, pedido_id, produto_id, qtd, obs, tamanho, produto_id2, produto_id3, produto_id4, preco_unitario) VALUES
(3, 3, 1, 6, 'asuhes', '', 0, 0, 0, 1000),
(6, 3, 11, 1, '', '', NULL, 0, 0, 2000),
(17, 3, 14, 13, '', '', 0, 0, 0, 0),
(21, 3, 11, 0, '', '', 0, 0, 0, 0),
(23, 3, 1, 0, '', '', 0, 0, 0, 0),
(24, 5, 10, 2, 'obs', '', 0, 0, 0, 36),
(25, 5, 4, 3, '', '', 0, 0, 0, 3000);



DROP TABLE IF EXISTS pedido_tem_produto_adicional;
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



DROP TABLE IF EXISTS produto;
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
  aceita_segundo_sabor tinyint(1) NOT NULL,
  PRIMARY KEY (id),
  KEY restaurante_id (restaurante_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


INSERT INTO produto (id, nome, preco, disponivel, esta_em_promocao, preco_promocional, descricao, qtd_produto_adicional, restaurante_id, codigo, texto_promocao, ativo, tamanho, aceita_segundo_sabor) VALUES
(1, 'BigMac', 1000, 1, 0, 0, 'Grande BigMac!!!', 0, 2, '4405', '', 0, '', 0),
(3, 'Pizza Mussarela', 2000, 1, 0, 1500, 'Pizza feita com queijo mussarela.', 0, 1, '333', 'promo texto', 1, '', 1),
(4, 'Pizza Frango Catupiry', 3000, 1, 0, 2200, 'Pizza feita com queijo mussarela, frango e catupiry.', 0, 1, '334', '', 0, '', 1),
(8, 'Camarao Irado', 2000, 1, 1, 0, '', 0, 9, '', '', 1, 'GIGANTEEE', 0),
(9, 'teste', 34, 1, 0, 0, '', 0, 6, '', '', 1, '', 0),
(10, 'Picanha com queijo', 40, 1, 0, 0, '', 0, 1, '', '', 1, '', 0),
(11, 'Quarteir&atilde;o', 2000, 1, 0, 0, '', 0, 2, '', '', 1, '', 0),
(12, 'Coca-Cola', 500, 1, 0, 0, '', 0, 2, '', '', 1, 'Pequena', 0),
(13, 'Coca-Cola', 700, 1, 0, 0, '', 0, 2, '', '', 1, 'M&eacute;dia', 0),
(14, 'Coca-Cola', 900, 1, 0, 0, '', 0, 2, '', '', 1, 'Grande', 0);



DROP TABLE IF EXISTS produto_adicional;
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
(1, 'arroz', 0, 1, 1, 2, 1),
(3, 'rsdbrdsrds', 0, 0, 1, 1, 1),
(4, 'brdsrdsrds', 0, 1, 1, 1, 0),
(5, 'Borda Recheada com Catupiry', 0, 1, 1, 1, 1),
(6, 'arroz', 0, 1, 1, 9, 1),
(7, 'pur�', 0, 1, 1, 9, 1),
(8, 'feij�o', 0, 1, 1, 9, 1);



DROP TABLE IF EXISTS produto_tem_produto_adicional;
CREATE TABLE produto_tem_produto_adicional (
  id int(11) NOT NULL AUTO_INCREMENT,
  produtoadicional_id int(11) NOT NULL,
  produto_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY produtoadicional_id (produtoadicional_id),
  KEY produto_id (produto_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


INSERT INTO produto_tem_produto_adicional (id, produtoadicional_id, produto_id) VALUES
(11, 5, 4),
(12, 5, 3),
(14, 7, 8),
(15, 1, 10),
(17, 3, 10),
(18, 4, 10),
(19, 1, 1);



DROP TABLE IF EXISTS produto_tem_tipo;
CREATE TABLE produto_tem_tipo (
  id int(11) NOT NULL AUTO_INCREMENT,
  tipoproduto_id int(11) NOT NULL,
  produto_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY tipoproduto_id (tipoproduto_id),
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
(9, 10, 10),
(10, 1, 11),
(11, 9, 12),
(12, 9, 13),
(13, 9, 14);



DROP TABLE IF EXISTS restaurante;
CREATE TABLE restaurante (
  id int(11) NOT NULL AUTO_INCREMENT,
  nome varchar(200) NOT NULL,
  cidade_id int(11) NOT NULL,
  endereco varchar(1000) NOT NULL,
  administrador_cadastrou_id int(11) NOT NULL,
  ativo tinyint(1) unsigned NOT NULL DEFAULT '0',
  desativado tinyint(1) NOT NULL DEFAULT '0',
  qtd_max_sabores int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY cidade_id (cidade_id),
  KEY administrador_cadastrou_id (administrador_cadastrou_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


INSERT INTO restaurante (id, nome, cidade_id, endereco, administrador_cadastrou_id, ativo, desativado, qtd_max_sabores) VALUES
(1, 'Bari Palesi', 1, 'Av. Engenheiro Roberto Freire, 564 - Capim Macio', 1, 0, 0, NULL),
(2, 'MC Donalds', 1, 'Rua Salgado Filho, numero 6576 - Natal Shopping - Candel&aacute;ria', 1, 0, 0, NULL),
(3, 'Bobs', 1, 'Av. Salgado Filho, 670 - Lagoa Nova', 1, 0, 0, NULL),
(4, 'Pastel Paulista', 2, 'Av. Eng. Roberto Freire, 800 - Capim Macio', 5, 0, 1, NULL),
(6, 'pensilvanio', 1, 'rua do cacete amarelo', 1, 0, 0, NULL),
(9, 'Bonaparte', 1, 'lbalbalabla', 1, 1, 0, NULL);



DROP TABLE IF EXISTS restaurante_atende_bairro;
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
(22, 6, 15, 4),
(24, 1, 2, 300);



DROP TABLE IF EXISTS restaurante_tem_tipo;
CREATE TABLE restaurante_tem_tipo (
  id int(11) NOT NULL AUTO_INCREMENT,
  restaurante_id int(11) NOT NULL,
  tiporestaurante_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY restaurante_id (restaurante_id),
  KEY tiporestauante_id (tiporestaurante_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


INSERT INTO restaurante_tem_tipo (id, restaurante_id, tiporestaurante_id) VALUES
(1, 2, 3),
(2, 1, 1),
(4, 1, 4),
(5, 3, 2);



DROP TABLE IF EXISTS restaurante_tem_tipo_produto;
CREATE TABLE restaurante_tem_tipo_produto (
  id int(11) NOT NULL AUTO_INCREMENT,
  restaurante_id int(11) NOT NULL,
  tipoproduto_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY restaurante_id (restaurante_id),
  KEY tipoproduto_id (tipoproduto_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


INSERT INTO restaurante_tem_tipo_produto (id, restaurante_id, tipoproduto_id) VALUES
(2, 3, 9);



DROP TABLE IF EXISTS telefone_consumidor;
CREATE TABLE telefone_consumidor (
  id int(11) NOT NULL AUTO_INCREMENT,
  consumidor_id int(11) NOT NULL,
  numero varchar(20) NOT NULL,
  PRIMARY KEY (id),
  KEY consumidor_id (consumidor_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


INSERT INTO telefone_consumidor (id, consumidor_id, numero) VALUES
(1, 1, '3642-1341');



DROP TABLE IF EXISTS tipo_produto;
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



DROP TABLE IF EXISTS tipo_restaurante;
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



DROP TABLE IF EXISTS usuario;
CREATE TABLE usuario (
  id int(11) NOT NULL AUTO_INCREMENT,
  tipo tinyint(1) NOT NULL COMMENT '1 - Administrador; 2 - Gerente; 3 - Atendente; 4 - Consumidor',
  nome varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  senha varchar(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY email (email)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


INSERT INTO usuario (id, tipo, nome, email, senha) VALUES
(1, 1, 'Paulo Egito', 'paulo@agenciabiro.com.br', '202cb962ac59075b964b07152d234b70'),
(2, 1, 'Tiago Freire', 'tiago@agenciabiro.com.br', '202cb962ac59075b964b07152d234b70'),
(3, 4, 'Jo�o Consumo', 'joao@gmail.com', '202cb962ac59075b964b07152d234b70');



DROP TABLE IF EXISTS usuario_restaurante;
CREATE TABLE usuario_restaurante (
  id int(11) NOT NULL AUTO_INCREMENT,
  restaurante_id int(11) NOT NULL,
  usuario_id int(11) NOT NULL,
  PRIMARY KEY (id),
  KEY usuario_id (usuario_id),
  KEY restaurante_id (restaurante_id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


ALTER TABLE `administrador`
  ADD CONSTRAINT administrador_usuario_id FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `bairro`
  ADD CONSTRAINT bairro_ibfk_1 FOREIGN KEY (cidade_id) REFERENCES cidade (id);

ALTER TABLE `consumidor`
  ADD CONSTRAINT consumidor_usuario_id FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE ON UPDATE CASCADE;

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

ALTER TABLE `produto_adicional`
  ADD CONSTRAINT produto_adicional_ibfk_1 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `produto_tem_produto_adicional`
  ADD CONSTRAINT produto_tem_produto_adicionalibfk_2 FOREIGN KEY (produtoadicional_id) REFERENCES produto_adicional (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT produto_tem_produto_adicionalibfk_1 FOREIGN KEY (produto_id) REFERENCES produto (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `produto_tem_tipo`
  ADD CONSTRAINT produto_tem_tipoibfk_1 FOREIGN KEY (produto_id) REFERENCES produto (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT produto_tem_tipoibfk_2 FOREIGN KEY (tipoproduto_id) REFERENCES tipo_produto (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `restaurante`
  ADD CONSTRAINT restauranteibfk_2 FOREIGN KEY (cidade_id) REFERENCES cidade (id),
  ADD CONSTRAINT restauranteibfk_1 FOREIGN KEY (administrador_cadastrou_id) REFERENCES administrador (id);

ALTER TABLE `restaurante_atende_bairro`
  ADD CONSTRAINT restaurante_atende_bairroibfk_1 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT restaurante_atende_bairroibfk_2 FOREIGN KEY (bairro_id) REFERENCES bairro (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `restaurante_tem_tipo`
  ADD CONSTRAINT restaurante_tem_tipoibfk_1 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT restaurante_tem_tipoibfk_2 FOREIGN KEY (tiporestaurante_id) REFERENCES tipo_restaurante (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `restaurante_tem_tipo_produto`
  ADD CONSTRAINT restaurante_tem_tipo_produtoibfk_1 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT restaurante_tem_tipo_produtoibfk_2 FOREIGN KEY (tipoproduto_id) REFERENCES tipo_produto (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `telefone_consumidor`
  ADD CONSTRAINT telefone_consumidor_ibfk_1 FOREIGN KEY (consumidor_id) REFERENCES consumidor (id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `usuario_restaurante`
  ADD CONSTRAINT usuario_restaurante_usuario_id FOREIGN KEY (usuario_id) REFERENCES usuario (id) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT usuario_restaurante_ibfk_1 FOREIGN KEY (restaurante_id) REFERENCES restaurante (id) ON DELETE CASCADE ON UPDATE CASCADE;

SET FOREIGN_KEY_CHECKS=1;

COMMIT;
