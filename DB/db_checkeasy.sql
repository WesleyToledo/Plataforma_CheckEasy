-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.7.17 - MySQL Community Server (GPL)
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura do banco de dados para db_checkeasy
CREATE DATABASE IF NOT EXISTS `db_checkeasy` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `db_checkeasy`;


-- Copiando estrutura para tabela db_checkeasy.aluno
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
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.aluno: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `aluno` DISABLE KEYS */;
INSERT INTO `aluno` (`idaluno`, `id_aluno_turma`, `id_aluno_professor`, `matricula`, `nome`, `sobrenome`) VALUES
	(7, 8, 8, '123', 'Guilherme', 'Fabrício Rosa'),
	(8, 8, 8, '321', 'Nivaldo ', 'Machado Foice Filho'),
	(10, 9, 8, '321', 'Weslley', 'Oliveira'),
	(13, 15, 8, '123', 'Guilherme', 'Rosa');
/*!40000 ALTER TABLE `aluno` ENABLE KEYS */;


-- Copiando estrutura para tabela db_checkeasy.avaliacao
CREATE TABLE IF NOT EXISTS `avaliacao` (
  `idavaliacao` int(11) NOT NULL AUTO_INCREMENT,
  `gabarito` varchar(45) NOT NULL,
  `quant_questoes` int(11) NOT NULL,
  `id_avaliacao_professor` int(11) NOT NULL,
  `quant_alternativas` int(11) NOT NULL,
  `valor` float NOT NULL,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`idavaliacao`),
  UNIQUE KEY `idavaliacao` (`idavaliacao`),
  KEY `id_avaliacao_professor` (`id_avaliacao_professor`),
  CONSTRAINT `id_avaliacao_professor` FOREIGN KEY (`id_avaliacao_professor`) REFERENCES `professor` (`idprofessor`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.avaliacao: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `avaliacao` DISABLE KEYS */;
INSERT INTO `avaliacao` (`idavaliacao`, `gabarito`, `quant_questoes`, `id_avaliacao_professor`, `quant_alternativas`, `valor`, `nome`) VALUES
	(7, '1/a/2/d/3/c/4/d/5/b/6/e/7/b/8/a/9/b/10/d', 10, 8, 5, 10, 'Sistemas Lineares'),
	(8, '1/a/2/b/3/a/4/c/5/b/6/a/7/d/8/a/9/c/10/e', 10, 8, 5, 10, 'Matemática Aplicada'),
	(9, '1/a/2/a/3/a/4/a/5/a/6/a/7/a/8/a/9/a/10/a/', 10, 8, 5, 10, 'Matemática Aplicada'),
	(10, '1/a/2/b/3/d/4/c/5/a/6/b/7/c/8/b/9/c/10/e', 10, 8, 5, 10, 'Matemática Aplicada II');
/*!40000 ALTER TABLE `avaliacao` ENABLE KEYS */;


-- Copiando estrutura para tabela db_checkeasy.professor
CREATE TABLE IF NOT EXISTS `professor` (
  `idprofessor` int(11) NOT NULL AUTO_INCREMENT,
  `primeiro_nome` varchar(20) NOT NULL,
  `sobrenome` varchar(45) NOT NULL,
  `nome_user` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `instituicao` varchar(45) NOT NULL,
  `cidade` varchar(45) NOT NULL,
  `cep` varchar(10) NOT NULL,
  `curriculo` varchar(100) NOT NULL,
  `senha` varchar(100) NOT NULL,
  PRIMARY KEY (`idprofessor`),
  UNIQUE KEY `idprofessor` (`idprofessor`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.professor: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `professor` DISABLE KEYS */;
INSERT INTO `professor` (`idprofessor`, `primeiro_nome`, `sobrenome`, `nome_user`, `email`, `instituicao`, `cidade`, `cep`, `curriculo`, `senha`) VALUES
	(8, 'Chicão', ' felipe', 'Chicão', '123@123.com', 'IFSULDEMINAS', 'Inconfidentes', '375700000', 'Professor de Física', '123');
/*!40000 ALTER TABLE `professor` ENABLE KEYS */;


-- Copiando estrutura para tabela db_checkeasy.provas
CREATE TABLE IF NOT EXISTS `provas` (
  `idprovas` int(11) NOT NULL AUTO_INCREMENT,
  `id_provas_avaliacao` int(11) NOT NULL,
  `id_provas_turma` int(11) NOT NULL,
  `id_provas_professor` int(11) NOT NULL,
  `id_provas_aluno` int(11) DEFAULT NULL,
  `nota` float DEFAULT NULL,
  `acertos` varchar(50) DEFAULT NULL,
  `erros` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idprovas`),
  UNIQUE KEY `idprovas` (`idprovas`),
  KEY `id_provas_avaliacao` (`id_provas_avaliacao`),
  KEY `id_provas_turma` (`id_provas_turma`),
  KEY `id_provas_aluno` (`id_provas_aluno`),
  KEY `id_provas_professor` (`id_provas_professor`),
  CONSTRAINT `id_provas_aluno` FOREIGN KEY (`id_provas_aluno`) REFERENCES `aluno` (`idaluno`),
  CONSTRAINT `id_provas_avaliacao` FOREIGN KEY (`id_provas_avaliacao`) REFERENCES `avaliacao` (`idavaliacao`),
  CONSTRAINT `id_provas_professor` FOREIGN KEY (`id_provas_professor`) REFERENCES `professor` (`idprofessor`),
  CONSTRAINT `id_provas_turma` FOREIGN KEY (`id_provas_turma`) REFERENCES `turma` (`idturma`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.provas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `provas` DISABLE KEYS */;
/*!40000 ALTER TABLE `provas` ENABLE KEYS */;


-- Copiando estrutura para tabela db_checkeasy.serie
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
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.serie: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `serie` DISABLE KEYS */;
INSERT INTO `serie` (`idserie`, `cor`, `icone`, `nome`, `id_serie_professor`) VALUES
	(8, 'blue400', 'fa fa-graduation-cap', 'Ensino Técnico', 8),
	(9, 'purple400', 'fa fa-graduation-cap', 'Técnico', 8),
	(10, 'green400', 'fa fa-graduation-cap', 'Ensino Médio', 8),
	(11, 'blue400', 'fa fa-graduation-cap', 'Ensino Básico', 8),
	(12, 'purple400', 'fa fa-graduation-cap', 'Técnico', 8);
/*!40000 ALTER TABLE `serie` ENABLE KEYS */;


-- Copiando estrutura para tabela db_checkeasy.turma
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
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.turma: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `turma` DISABLE KEYS */;
INSERT INTO `turma` (`idturma`, `id_turma_professor`, `id_turma_serie`, `nome`) VALUES
	(8, 8, 8, '3º E1'),
	(9, 8, 10, '3º E3'),
	(15, 8, 12, '3ºE4'),
	(16, 8, 8, '3º E3');
/*!40000 ALTER TABLE `turma` ENABLE KEYS */;


-- Copiando estrutura para tabela db_checkeasy.turma_prova
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
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.turma_prova: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `turma_prova` DISABLE KEYS */;
INSERT INTO `turma_prova` (`idturma_prova`, `id_turma_prova_professor`, `id_turma_prova_turma`, `id_turma_prova_avaliacao`) VALUES
	(14, 8, 15, 7);
/*!40000 ALTER TABLE `turma_prova` ENABLE KEYS */;


-- Copiando estrutura para tabela db_checkeasy.users
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
