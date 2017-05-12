-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: localhost    Database: bdesp
-- ------------------------------------------------------
-- Server version	5.5.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorie` (
  `idCategorie` int(11) NOT NULL AUTO_INCREMENT,
  `nomCategorie` varchar(50) NOT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorie`
--

LOCK TABLES `categorie` WRITE;
/*!40000 ALTER TABLE `categorie` DISABLE KEYS */;
INSERT INTO `categorie` VALUES (1,'Acrylique sur bois'),(2,'Acrylique sur toile'),(3,'Acrylique sur metal'),(4,'Aquarelle sur papier'),(5,'Encre sur bois'),(6,'Techniques mixtes sur bois'),(7,'Techniques mixtes sur metal'),(8,'Photograpgie numerique'),(9,'Infographie'),(10,'Sculture'),(11,'Installation');
/*!40000 ALTER TABLE `categorie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `commanditaire`
--

DROP TABLE IF EXISTS `commanditaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commanditaire` (
  `idCommanditaire` int(11) NOT NULL AUTO_INCREMENT,
  `nomCommanditaire` varchar(100) NOT NULL,
  `pathCommanditaire` varchar(100) NOT NULL,
  PRIMARY KEY (`idCommanditaire`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commanditaire`
--

LOCK TABLES `commanditaire` WRITE;
/*!40000 ALTER TABLE `commanditaire` DISABLE KEYS */;
INSERT INTO `commanditaire` VALUES (1,'McDonald','commanditaire3.png');
/*!40000 ALTER TABLE `commanditaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `emprunt`
--

DROP TABLE IF EXISTS `emprunt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `emprunt` (
  `idEmprunt` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Date` datetime NOT NULL,
  `NomPersonneEmprunt` varchar(45) NOT NULL,
  `PrenomPersonneEmprunt` varchar(45) NOT NULL,
  `MailPersonneEmprunt` varchar(100) NOT NULL,
  `Local` varchar(250) NOT NULL,
  `idOeuvre` int(11) NOT NULL,
  `confirme` tinyint(1) NOT NULL,
  PRIMARY KEY (`idEmprunt`),
  UNIQUE KEY `idOeuvre_UNIQUE` (`idOeuvre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `emprunt`
--

LOCK TABLES `emprunt` WRITE;
/*!40000 ALTER TABLE `emprunt` DISABLE KEYS */;
/*!40000 ALTER TABLE `emprunt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `etat`
--

DROP TABLE IF EXISTS `etat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `etat` (
  `idetat` int(11) NOT NULL AUTO_INCREMENT,
  `NomEtat` varchar(25) NOT NULL,
  `peuxEtreReserve` tinyint(4) NOT NULL,
  PRIMARY KEY (`idetat`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `etat`
--

LOCK TABLES `etat` WRITE;
/*!40000 ALTER TABLE `etat` DISABLE KEYS */;
INSERT INTO `etat` VALUES (1,'En réparation',0),(2,'Installation permanente',0),(3,'Disponible',1),(4,'Non Disponible',1),(5,'Oeuvre retirée',0);
/*!40000 ALTER TABLE `etat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `gestionnaire`
--

DROP TABLE IF EXISTS `gestionnaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gestionnaire` (
  `idgestionnaire` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  PRIMARY KEY (`idgestionnaire`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `gestionnaire`
--

LOCK TABLES `gestionnaire` WRITE;
/*!40000 ALTER TABLE `gestionnaire` DISABLE KEYS */;
INSERT INTO `gestionnaire` VALUES (4,'ypaquin@cegepba.qc.ca','1234');
/*!40000 ALTER TABLE `gestionnaire` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oeuvres`
--

DROP TABLE IF EXISTS `oeuvres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `oeuvres` (
  `idOeuvres` int(11) NOT NULL AUTO_INCREMENT,
  `nomOeuvre` varchar(100) NOT NULL,
  `Auteur` varchar(100) NOT NULL,
  `Hauteur` int(11) NOT NULL,
  `Largeur` int(11) NOT NULL,
  `Profondeur` int(11) DEFAULT NULL,
  `Titre` varchar(100) NOT NULL,
  `Annee` year(4) NOT NULL,
  `idCategorie` int(11) NOT NULL,
  `idEtat` int(11) NOT NULL,
  `lieu` varchar(45) DEFAULT NULL,
  `description` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`idOeuvres`),
  KEY `FK_etatOeuvre` (`idEtat`),
  KEY `FK_categorieOeuvre` (`idCategorie`),
  CONSTRAINT `FK_categorieOeuvre` FOREIGN KEY (`idCategorie`) REFERENCES `categorie` (`idCategorie`),
  CONSTRAINT `FK_etatOeuvre` FOREIGN KEY (`idEtat`) REFERENCES `etat` (`idetat`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oeuvres`
--

LOCK TABLES `oeuvres` WRITE;
/*!40000 ALTER TABLE `oeuvres` DISABLE KEYS */;
INSERT INTO `oeuvres` VALUES (1,'DG_Collection_CBA_09-10.jpg','Daisy Grenier',83,53,NULL,' L\'éveil',2010,3,3,'Entrepôt',NULL),(2,'JF_Collection_CBA_09-10.jpg','Jessica Fecteau',102,64,NULL,'OGM',2010,1,3,'Entrepôt',NULL),(3,'MCP_Collection_CBA_09-10.jpg','Marie-Claude Poulin',127,89,NULL,'Ce qu\'il lui reste?',2010,8,2,'Entrepôt',NULL),(4,'PHV_Collection_CBA_09-10.jpg','Pierre-Hugues Vachon',75,101,NULL,'Citation de Serge Lemoyne',2010,1,3,'Entrepôt',''),(5,'ANC_Collection_CBA_10-11.jpg','Amelie Nadeau-Caron',61,45,NULL,'Payage abstrait',2011,1,3,'Entrepôt',''),(6,'CMP_Collection_CBA_10-11.jpg','Catherine Messier-Poulin',45,185,3,'Light',2011,6,3,'Entrepôt',''),(7,'SC_Collection_CBA_10-11.jpg','Stephanie Cloutier',50,76,NULL,'Sans Titre',2011,8,3,'Entrepôt',''),(8,'FG_Collection_CBA_10-11.jpg','Fanny Gaboury',31,92,NULL,'Dans les lignes de la main',2011,6,3,'Entrepôt',''),(9,'JML_Collection_CBA_10-11.jpg','Jean-Mathieu Lachapelle',153,132,NULL,'Intercoulouré',2011,1,3,'Entrepôt',''),(10,'DD_Collection_CBA_09-10.jpg','David Dulac',216,106,NULL,'Explosion orgasmique du XXIe siècle',2010,8,2,'Entrepôt','');
/*!40000 ALTER TABLE `oeuvres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reservation` (
  `idReservation` int(11) NOT NULL AUTO_INCREMENT,
  `Date` datetime NOT NULL,
  `NomPersonneReserve` varchar(45) NOT NULL,
  `PrenomPersonneReserve` varchar(45) NOT NULL,
  `MailPersonneReserve` varchar(100) NOT NULL,
  `Local` varchar(250) NOT NULL,
  `idOeuvre` int(11) NOT NULL,
  `effectif` tinyint(4) NOT NULL,
  PRIMARY KEY (`idReservation`),
  KEY `Oeuvres_idOeuvre_fk` (`idOeuvre`),
  CONSTRAINT `Oeuvres_idOeuvre_fk` FOREIGN KEY (`idOeuvre`) REFERENCES `oeuvres` (`idOeuvres`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reservation`
--

LOCK TABLES `reservation` WRITE;
/*!40000 ALTER TABLE `reservation` DISABLE KEYS */;
/*!40000 ALTER TABLE `reservation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `variable`
--

DROP TABLE IF EXISTS `variable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `variable` (
  `idVariable` int(11) NOT NULL AUTO_INCREMENT,
  `nomVariable` varchar(200) NOT NULL,
  `value` varchar(200) NOT NULL,
  PRIMARY KEY (`idVariable`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `variable`
--

LOCK TABLES `variable` WRITE;
/*!40000 ALTER TABLE `variable` DISABLE KEYS */;
INSERT INTO `variable` VALUES (1,'Host','mail.kms-quebec.com'),(2,'Username','cba@kms-quebec.com'),(3,'Password','Test1234'),(4,'Port','587'),(7,'maxReservation','4'),(8,'maxEmprunt','4'),(9,'extensionCourriel','cegepba.qc.ca'),(10,'From','cba@kms-quebec.com');
/*!40000 ALTER TABLE `variable` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-05-12 14:00:55
