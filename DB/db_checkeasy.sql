-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.7.21 - MySQL Community Server (GPL)
-- OS do Servidor:               Win64
-- HeidiSQL Versão:              9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Copiando estrutura do banco de dados para db_checkeasy
CREATE DATABASE IF NOT EXISTS `db_checkeasy` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `db_checkeasy`;

-- Copiando estrutura para tabela db_checkeasy.aluno
CREATE TABLE IF NOT EXISTS `aluno` (
  `idaluno` int(11) NOT NULL AUTO_INCREMENT,
  `id_aluno_professor` int(11) DEFAULT NULL,
  `id_aluno_turma` int(11) DEFAULT NULL,
  `matricula` varchar(20) DEFAULT NULL,
  `nome` varchar(20) NOT NULL,
  `sobrenome` varchar(45) NOT NULL,
  PRIMARY KEY (`idaluno`),
  UNIQUE KEY `idaluno` (`idaluno`),
  KEY `id_aluno_turma` (`id_aluno_turma`),
  KEY `id_aluno_professor` (`id_aluno_professor`),
  CONSTRAINT `id_aluno_professor` FOREIGN KEY (`id_aluno_professor`) REFERENCES `professor` (`idprofessor`),
  CONSTRAINT `id_aluno_turma` FOREIGN KEY (`id_aluno_turma`) REFERENCES `turma` (`idturma`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.aluno: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `aluno` DISABLE KEYS */;
INSERT INTO `aluno` (`idaluno`, `id_aluno_professor`, `id_aluno_turma`, `matricula`, `nome`, `sobrenome`) VALUES
	(4, 8, 8, '37564000', 'Gian', 'Ferreira');
/*!40000 ALTER TABLE `aluno` ENABLE KEYS */;

-- Copiando estrutura para tabela db_checkeasy.avaliacao
CREATE TABLE IF NOT EXISTS `avaliacao` (
  `idavaliacao` int(11) NOT NULL AUTO_INCREMENT,
  `gabarito` varchar(45) NOT NULL,
  `quant_questoes` int(11) NOT NULL,
  `id_avaliacao_professor` int(11) NOT NULL,
  `quant_alternativas` int(11) NOT NULL,
  `valor` float NOT NULL,
  PRIMARY KEY (`idavaliacao`),
  UNIQUE KEY `idavaliacao` (`idavaliacao`),
  KEY `id_avaliacao_professor` (`id_avaliacao_professor`),
  CONSTRAINT `id_avaliacao_professor` FOREIGN KEY (`id_avaliacao_professor`) REFERENCES `professor` (`idprofessor`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.avaliacao: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `avaliacao` DISABLE KEYS */;
INSERT INTO `avaliacao` (`idavaliacao`, `gabarito`, `quant_questoes`, `id_avaliacao_professor`, `quant_alternativas`, `valor`) VALUES
	(2, 'Quimica', 5, 8, 5, 5);
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.professor: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `professor` DISABLE KEYS */;
INSERT INTO `professor` (`idprofessor`, `primeiro_nome`, `sobrenome`, `nome_user`, `email`, `instituicao`, `cidade`, `cep`, `curriculo`, `senha`) VALUES
	(8, 'Guilherme', 'Fabrício', 'gui', 'guifabricio1900@hotmail.com', 'IF', 'Borda da Mata', '37564-000', 'Minha vida é uma merda ', 'admin');
/*!40000 ALTER TABLE `professor` ENABLE KEYS */;

-- Copiando estrutura para tabela db_checkeasy.provas
CREATE TABLE IF NOT EXISTS `provas` (
  `idprovas` int(11) NOT NULL AUTO_INCREMENT,
  `id_provas_avaliacao` int(11) NOT NULL,
  `id_provas_turma` int(11) NOT NULL,
  `id_provas_aluno` int(11) DEFAULT NULL,
  `nota` float DEFAULT NULL,
  `acertos` varchar(50) DEFAULT NULL,
  `erros` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idprovas`),
  UNIQUE KEY `idprovas` (`idprovas`),
  KEY `id_provas_avaliacao` (`id_provas_avaliacao`),
  KEY `id_provas_turma` (`id_provas_turma`),
  KEY `id_provas_aluno` (`id_provas_aluno`),
  CONSTRAINT `id_provas_aluno` FOREIGN KEY (`id_provas_aluno`) REFERENCES `aluno` (`idaluno`),
  CONSTRAINT `id_provas_avaliacao` FOREIGN KEY (`id_provas_avaliacao`) REFERENCES `avaliacao` (`idavaliacao`),
  CONSTRAINT `id_provas_turma` FOREIGN KEY (`id_provas_turma`) REFERENCES `turma` (`idturma`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.provas: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `provas` DISABLE KEYS */;
INSERT INTO `provas` (`idprovas`, `id_provas_avaliacao`, `id_provas_turma`, `id_provas_aluno`, `nota`, `acertos`, `erros`) VALUES
	(3, 2, 8, 4, 5, '5', '0');
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.serie: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `serie` DISABLE KEYS */;
INSERT INTO `serie` (`idserie`, `cor`, `icone`, `nome`, `id_serie_professor`) VALUES
	(8, 'red', 'E1', 'E1', 8);
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.turma: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `turma` DISABLE KEYS */;
INSERT INTO `turma` (`idturma`, `id_turma_professor`, `id_turma_serie`, `nome`) VALUES
	(8, 8, 8, 'E1');
/*!40000 ALTER TABLE `turma` ENABLE KEYS */;

-- Copiando estrutura para tabela db_checkeasy.users
CREATE TABLE IF NOT EXISTS `users` (
  `idusers` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(20) NOT NULL,
  `senha` varchar(100) NOT NULL,
  `nome_user` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idusers`),
  UNIQUE KEY `idusers` (`idusers`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Copiando dados para a tabela db_checkeasy.users: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`idusers`, `login`, `senha`, `nome_user`) VALUES
	(2, 'gui', 'admin', 'Guilherme');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
