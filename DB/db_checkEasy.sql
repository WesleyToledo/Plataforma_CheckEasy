-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.7.22 - MySQL Community Server (GPL)
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para db_checkeasy
DROP DATABASE IF EXISTS `db_checkeasy`;
CREATE DATABASE IF NOT EXISTS `db_checkeasy` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `db_checkeasy`;

-- Copiando estrutura para tabela db_checkeasy.aluno
DROP TABLE IF EXISTS `aluno`;
CREATE TABLE IF NOT EXISTS `aluno` (
  `idaluno` int(11) NOT NULL AUTO_INCREMENT,
  `id_aluno_turma` int(11) DEFAULT NULL,
  `id_aluno_professor` int(11) DEFAULT NULL,
  `matricula` varchar(20) DEFAULT NULL,
  `nome` varchar(20) NOT NULL,
  `sobrenome` varchar(45) NOT NULL,
  PRIMARY KEY (`idaluno`),
  UNIQUE KEY `idaluno` (`idaluno`),
  KEY `id_aluno_turma` (`id_aluno_turma`),
  KEY `id_aluno_professor` (`id_aluno_professor`),
  CONSTRAINT `id_aluno_professor` FOREIGN KEY (`id_aluno_professor`) REFERENCES `professor` (`idprofessor`),
  CONSTRAINT `id_aluno_turma` FOREIGN KEY (`id_aluno_turma`) REFERENCES `turma` (`idturma`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.aluno: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `aluno` DISABLE KEYS */;
INSERT INTO `aluno` (`idaluno`, `id_aluno_turma`, `id_aluno_professor`, `matricula`, `nome`, `sobrenome`) VALUES
	(1, 1, 8, '123', 'Wesley', '   Toledo'),
	(2, 1, 8, '21234 ', 'André', '     Amaral di Salvo (the versalete men)'),
	(10, 8, 9, '1234', 'Wesley', ' Evangelista '),
	(11, 9, 9, '2342354', 'André', ' Amaral diSalvo '),
	(12, 8, 9, '1234', 'Eduardo', ' NAscimento ');
/*!40000 ALTER TABLE `aluno` ENABLE KEYS */;

-- Copiando estrutura para tabela db_checkeasy.avaliacao
DROP TABLE IF EXISTS `avaliacao`;
CREATE TABLE IF NOT EXISTS `avaliacao` (
  `idavaliacao` int(11) NOT NULL AUTO_INCREMENT,
  `gabarito` varchar(150) NOT NULL,
  `quant_questoes` int(11) NOT NULL,
  `id_avaliacao_professor` int(11) NOT NULL,
  `quant_alternativas` int(11) NOT NULL,
  `valor` float NOT NULL,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`idavaliacao`),
  UNIQUE KEY `idavaliacao` (`idavaliacao`),
  KEY `id_avaliacao_professor` (`id_avaliacao_professor`),
  CONSTRAINT `id_avaliacao_professor` FOREIGN KEY (`id_avaliacao_professor`) REFERENCES `professor` (`idprofessor`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.avaliacao: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `avaliacao` DISABLE KEYS */;
INSERT INTO `avaliacao` (`idavaliacao`, `gabarito`, `quant_questoes`, `id_avaliacao_professor`, `quant_alternativas`, `valor`, `nome`) VALUES
	(12, '1/a/2/2/b/2/3/c/2/4/d/2/5/a/2.5/6/d/1.5/7/d/2/8/a/2/9/a/2/10/a/2', 10, 8, 5, 20, 'Matemática Aplicada III '),
	(17, '1/a/2/2/b/2/3/c/2/4/c/2/5/c/2/6/c/2/7/d/2/8/b/2/9/c/2/10/e/2', 10, 9, 5, 20, 'Matemática Aplicada III'),
	(18, '1/a/1/2/a/1/3/a/1/4/a/1/5/a/1/6/a/1/7/a/1/8/a/1/9/a/1/10/a/1/', 10, 8, 5, 10, 'Matemática Aplicada III'),
	(20, '1/a/1/2/a/1/3/a/1/4/a/1/5/a/1/6/a/1/7/a/1/8/a/1/9/a/1/10/a/1/', 10, 8, 5, 10, 'Matemática Aplicada III');
/*!40000 ALTER TABLE `avaliacao` ENABLE KEYS */;

-- Copiando estrutura para tabela db_checkeasy.correcoes
DROP TABLE IF EXISTS `correcoes`;
CREATE TABLE IF NOT EXISTS `correcoes` (
  `idcorrecoes` int(11) NOT NULL AUTO_INCREMENT,
  `id_correcoes_avaliacao` int(11) NOT NULL,
  `id_correcoes_turma` int(11) NOT NULL,
  `id_correcoes_professor` int(11) NOT NULL,
  `id_correcoes_aluno` int(11) NOT NULL,
  `nota` float NOT NULL,
  `acertos` varchar(50) NOT NULL,
  `erros` varchar(50) NOT NULL,
  `gabarito` varchar(150) NOT NULL,
  PRIMARY KEY (`idcorrecoes`),
  UNIQUE KEY `idprovas` (`idcorrecoes`),
  KEY `id_provas_avaliacao` (`id_correcoes_avaliacao`),
  KEY `id_provas_turma` (`id_correcoes_turma`),
  KEY `id_provas_aluno` (`id_correcoes_aluno`),
  KEY `id_provas_professor` (`id_correcoes_professor`),
  CONSTRAINT `id_provas_aluno` FOREIGN KEY (`id_correcoes_aluno`) REFERENCES `aluno` (`idaluno`),
  CONSTRAINT `id_provas_avaliacao` FOREIGN KEY (`id_correcoes_avaliacao`) REFERENCES `avaliacao` (`idavaliacao`),
  CONSTRAINT `id_provas_professor` FOREIGN KEY (`id_correcoes_professor`) REFERENCES `professor` (`idprofessor`),
  CONSTRAINT `id_provas_turma` FOREIGN KEY (`id_correcoes_turma`) REFERENCES `turma` (`idturma`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.correcoes: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `correcoes` DISABLE KEYS */;
INSERT INTO `correcoes` (`idcorrecoes`, `id_correcoes_avaliacao`, `id_correcoes_turma`, `id_correcoes_professor`, `id_correcoes_aluno`, `nota`, `acertos`, `erros`, `gabarito`) VALUES
	(1, 17, 8, 9, 1, 10, '10', '0', '1/as/0.2/2/as/0.2/3/as/0.2/4/as/0.2/5/as/0.2/6/as/0.2/7/as/0.2/8/as/0.2/9/as/0.2/10/as/0.2'),
	(14, 17, 8, 9, 1, 10, '10', '0', '1/as/0.2/2/as/0.2/3/as/0.2/4/ae/0.2/5/as/0.2/6/as/0.2/7/as/0.2/8/as/0.2/9/as/0.2/10/as/0.2'),
	(15, 17, 8, 9, 1, 10, '10', '0', '1/as/0.2/2/as/0.2/3/as/0.2/4/ae/0.2/5/as/0.2/6/as/0.2/7/as/0.2/8/as/0.2/9/as/0.2/10/as/0.2'),
	(16, 17, 8, 9, 1, 10, '10', '0', '1/as/0.2/2/as/0.2/3/as/0.2/4/ae/0.2/5/as/0.2/6/as/0.2/7/as/0.2/8/as/0.2/9/as/0.2/10/as/0.2'),
	(17, 17, 8, 9, 1, 10, '10', '0', '1/as/0.2/2/as/0.2/3/as/0.2/4/ae/0.2/5/ae/0.2/6/as/0.2/7/as/0.2/8/as/0.2/9/as/0.2/10/as/0.2');
/*!40000 ALTER TABLE `correcoes` ENABLE KEYS */;

-- Copiando estrutura para tabela db_checkeasy.professor
DROP TABLE IF EXISTS `professor`;
CREATE TABLE IF NOT EXISTS `professor` (
  `idprofessor` int(11) NOT NULL AUTO_INCREMENT,
  `primeiro_nome` varchar(20) NOT NULL,
  `sobrenome` varchar(45) NOT NULL,
  `nome_user` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL DEFAULT 'Unique',
  `instituicao` varchar(45) NOT NULL,
  `cidade` varchar(45) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `curriculo` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `estado` varchar(30) NOT NULL,
  PRIMARY KEY (`idprofessor`),
  UNIQUE KEY `idprofessor` (`idprofessor`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.professor: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `professor` DISABLE KEYS */;
INSERT INTO `professor` (`idprofessor`, `primeiro_nome`, `sobrenome`, `nome_user`, `email`, `instituicao`, `cidade`, `cep`, `curriculo`, `senha`, `estado`) VALUES
	(8, 'Chicão', 'Felipe', '123', '123', 'IFSULDEMINAS', 'Inconfidentes', '37.570-000', 'Professor de Física Foda pra cacete', '123', 'Minas Gerais'),
	(9, 'Wesley', ' Evangelista de Toledo', '1234', 'wesley.toledo191@gmail.com', 'IFSULDEMINAS', 'MONTE SIAO', '37.580-000', 'Triste Estudante de TI Triste e Foda', '', 'Minas Gerais');
/*!40000 ALTER TABLE `professor` ENABLE KEYS */;

-- Copiando estrutura para tabela db_checkeasy.serie
DROP TABLE IF EXISTS `serie`;
CREATE TABLE IF NOT EXISTS `serie` (
  `idserie` int(11) NOT NULL AUTO_INCREMENT,
  `cor` varchar(10) DEFAULT NULL,
  `icone` varchar(25) DEFAULT NULL,
  `nome` varchar(25) DEFAULT NULL,
  `id_serie_professor` int(11) DEFAULT NULL,
  PRIMARY KEY (`idserie`),
  UNIQUE KEY `idserie` (`idserie`),
  KEY `id_serie_professor` (`id_serie_professor`),
  CONSTRAINT `id_serie_professor` FOREIGN KEY (`id_serie_professor`) REFERENCES `professor` (`idprofessor`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.serie: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `serie` DISABLE KEYS */;
INSERT INTO `serie` (`idserie`, `cor`, `icone`, `nome`, `id_serie_professor`) VALUES
	(8, 'blue400', 'fa fa-graduation-cap', 'Ensino Técnico', 8),
	(9, 'purple400', 'fa fa-graduation-cap', 'Técnico', 8),
	(10, 'green400', 'fa fa-graduation-cap', 'Ensino Médio', 8),
	(11, 'blue400', 'fa fa-graduation-cap', 'Ensino Básico', 8),
	(12, 'purple400', 'fa fa-graduation-cap', 'Técnico', 8),
	(13, 'purple400', 'fa fa-graduation-cap', 'Ensino Técnico', 9);
/*!40000 ALTER TABLE `serie` ENABLE KEYS */;

-- Copiando estrutura para tabela db_checkeasy.turma
DROP TABLE IF EXISTS `turma`;
CREATE TABLE IF NOT EXISTS `turma` (
  `idturma` int(11) NOT NULL AUTO_INCREMENT,
  `id_turma_professor` int(11) NOT NULL DEFAULT '0',
  `id_turma_serie` int(11) NOT NULL DEFAULT '0',
  `nome` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`idturma`),
  UNIQUE KEY `idturma` (`idturma`),
  KEY `id_turma_professor` (`id_turma_professor`),
  KEY `id_turma_serie` (`id_turma_serie`),
  CONSTRAINT `id_turma_professor` FOREIGN KEY (`id_turma_professor`) REFERENCES `professor` (`idprofessor`),
  CONSTRAINT `id_turma_serie` FOREIGN KEY (`id_turma_serie`) REFERENCES `serie` (`idserie`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.turma: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `turma` DISABLE KEYS */;
INSERT INTO `turma` (`idturma`, `id_turma_professor`, `id_turma_serie`, `nome`) VALUES
	(1, 8, 10, '3º E1'),
	(8, 9, 13, '3º E1'),
	(9, 9, 13, '3 ºE2 ');
/*!40000 ALTER TABLE `turma` ENABLE KEYS */;

-- Copiando estrutura para tabela db_checkeasy.turma_prova
DROP TABLE IF EXISTS `turma_prova`;
CREATE TABLE IF NOT EXISTS `turma_prova` (
  `idturma_prova` int(11) NOT NULL AUTO_INCREMENT,
  `id_turma_prova_professor` int(11) NOT NULL,
  `id_turma_prova_turma` int(11) NOT NULL,
  `id_turma_prova_avaliacao` int(11) NOT NULL,
  PRIMARY KEY (`idturma_prova`),
  UNIQUE KEY `idturma_prova` (`idturma_prova`),
  KEY `id_turma_prova_professor` (`id_turma_prova_professor`),
  KEY `id_turma_prova_avaliacao` (`id_turma_prova_avaliacao`),
  KEY `id_turma_prova_turma` (`id_turma_prova_turma`),
  CONSTRAINT `id_turma_prova_avaliacao` FOREIGN KEY (`id_turma_prova_avaliacao`) REFERENCES `avaliacao` (`idavaliacao`),
  CONSTRAINT `id_turma_prova_professor` FOREIGN KEY (`id_turma_prova_professor`) REFERENCES `professor` (`idprofessor`),
  CONSTRAINT `id_turma_prova_turma` FOREIGN KEY (`id_turma_prova_turma`) REFERENCES `turma` (`idturma`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.turma_prova: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `turma_prova` DISABLE KEYS */;
INSERT INTO `turma_prova` (`idturma_prova`, `id_turma_prova_professor`, `id_turma_prova_turma`, `id_turma_prova_avaliacao`) VALUES
	(11, 8, 1, 12),
	(35, 9, 8, 17),
	(46, 9, 9, 17);
/*!40000 ALTER TABLE `turma_prova` ENABLE KEYS */;

-- Copiando estrutura para tabela db_checkeasy.users
DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `idusers` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `nome_user` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idusers`),
  UNIQUE KEY `idusers` (`idusers`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.users: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
