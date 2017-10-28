# 
# Create the Tokens table
#

CREATE TABLE `tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` varchar(255) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `generationDateTime` datetime DEFAULT CURRENT_TIMESTAMP,
  `lastUpdateDateTime` datetime DEFAULT CURRENT_TIMESTAMP,
  `expirationDateTime` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
