-- MySQL dump 10.11
--
-- Host: localhost    Database: game_ballotaccess
-- ------------------------------------------------------
-- Server version	5.0.75-0ubuntu10.2


LOCK TABLES `mj_lists` WRITE;
/*!40000 ALTER TABLE `mj_lists` DISABLE KEYS */;
INSERT INTO `mj_lists` VALUES (6,'Tile Selector','single','sql','SELECT id,name FROM tiles ',''),(7,'Level Selector','single','sql','SELECT id, title FROM levels','');
/*!40000 ALTER TABLE `mj_lists` ENABLE KEYS */;
UNLOCK TABLES;


LOCK TABLES `mj_menus` WRITE;
/*!40000 ALTER TABLE `mj_menus` DISABLE KEYS */;
INSERT INTO `mj_menus` VALUES (1,'search','rooms_list','Rooms',1),(2,'add','rooms_form','Rooms',2),(3,'search','questions_list','Questions',2),(4,'add','questions_form','Questions',3),(5,'search','levels_list','Levels',3),(6,'add','levels_form','Levels',4),(7,'search','responses_list','Responses',4),(8,'add','responses_form','Responses',5),(9,'search','responses_list','Responses',5),(10,'add','responses_form','Responses',6),(11,'search','tiles_list','Tiles',6),(12,'add','tiles_form','Tiles',7);
/*!40000 ALTER TABLE `mj_menus` ENABLE KEYS */;
UNLOCK TABLES;


