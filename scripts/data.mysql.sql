/*
-- Query: 
-- Date: 2012-02-24 00:56
*/
INSERT INTO `entry` (`id`,`title`,`body`,`created`) VALUES (NULL,'First Entry','<p>many  words</p>','2012-02-24 00:49:49');
INSERT INTO `entry` (`id`,`title`,`body`,`created`) VALUES (NULL,'Second Entry','<b>Bold</b> <p>Second Post</p>','2012-02-20 13:00:00');

INSERT INTO `comment` (`id`,`entry`,`body`,`created`) VALUES (NULL,'1','Good comment','2012-02-24 00:49:49');
INSERT INTO `comment` (`id`,`entry`,`body`,`created`) VALUES (NULL,'1','<b>Bold</b> <p>Bad comment</p>','2012-04-20 13:00:00');
INSERT INTO `comment` (`id`,`entry`,`body`,`created`) VALUES (NULL,'2','comment 3333','2012-24-20 13:00:00');
