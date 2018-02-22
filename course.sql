DROP TABLE IF EXISTS `attendee`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attendee` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `registration_id` int(11) NOT NULL,
  `name_on_ticket` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attendee`
--

LOCK TABLES `attendee` WRITE;
/*!40000 ALTER TABLE `attendee` DISABLE KEYS */;
INSERT INTO `attendee` VALUES (1,1,'Clark Senior'),(2,1,'Clark Junior'),(3,2,'Matthew'),(4,2,'Ralph'),(5,2,'Enrico'),(6,2,'Slavey'),(7,3,'Doug'),(8,3,'Siri'),(9,4,'Lada'),(10,4,'Tongsoi'),(11,6,'Josie'),(12,7,'Milo'),(13,7,'Tami'),(14,5,'Tonsoi'),(15,5,'Tami'),(16,8,'Lada'),(17,8,'Saleen'),(18,9,'D. Trump'),(19,9,'B. Simpson'),(20,9,'L. Simpson'),(21,10,'Doug'),(22,10,'Daryl'),(23,13,'Marge'),(24,13,'Bart'),(25,13,'Lisa'),(26,14,'Test 1'),(27,14,'Test 2'),(28,14,'Test 3'),(29,15,'Test 1'),(30,15,'Test 2'),(31,16,'Test'),(32,19,'Go'),(33,19,'Again');
/*!40000 ALTER TABLE `attendee` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `event`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `event` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT '',
  `max_attendees` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `event`
--

LOCK TABLES `event` WRITE;
/*!40000 ALTER TABLE `event` DISABLE KEYS */;
INSERT INTO `event` VALUES (1,'Event A',25,'2013-10-01 00:00:00'),(2,'Event B',150,'2013-12-12 00:00:00');
/*!40000 ALTER TABLE `event` ENABLE KEYS */;
UNLOCK TABLES;

DROP TABLE IF EXISTS `registration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registration` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `registration_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registration`
--

LOCK TABLES `registration` WRITE;
/*!40000 ALTER TABLE `registration` DISABLE KEYS */;
INSERT INTO `registration` VALUES (1,1,'Clark','Everetts','2013-06-06 13:51:10'),(2,2,'Matthew','Weir O\'Phinney','2013-06-06 13:52:03'),(3,1,'Doug','Bierer','2015-09-02 18:03:55'),(4,1,'Cal','Evans','2017-08-10 10:16:40'),(5,1,'Susie','Pollock','2017-08-10 10:18:31'),(6,1,'Daryl','Wood','2017-08-10 10:19:42'),(7,2,'Siri','Jamikorn','2017-08-10 10:23:44'),(8,1,'Doug','Bierer','2017-08-22 13:13:44'),(9,1,'Lynn','Flink','2017-09-20 15:00:30'),(10,1,'Cal','Evans','2017-11-06 16:35:50'),(11,2,'Homer','Simpson','2017-11-07 13:13:13'),(12,2,'Homer','Simpson','2017-11-07 13:13:50'),(13,2,'Homer','Simpson','2017-11-07 13:15:27'),(14,1,'Test','Test','2017-11-07 13:19:22'),(15,2,'Test','Again','2017-11-07 13:26:49'),(16,2,'Yet','Another','2017-11-07 14:49:33'),(17,2,'Here','We','2017-11-07 14:59:23'),(18,2,'Here','We','2017-11-07 15:40:29'),(19,2,'Here','We','2017-11-07 15:41:32');
/*!40000 ALTER TABLE `registration` ENABLE KEYS */;
UNLOCK TABLES;

