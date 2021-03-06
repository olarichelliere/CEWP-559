CREATE DATABASE IF NOT EXISTS CCE_PHPMySQL2;

# 
# Create the items table
#
CREATE TABLE `items` (
  `ID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) NOT NULL DEFAULT '',
  `Description` text,
  `Price` float DEFAULT NULL,
  `DateTimeAdded` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Insert some values to the items table
#
INSERT INTO `items` (`ID`, `Name`, `Description`, `Price`, `DateTimeAdded`)
VALUES
	(1,'Expert PHP & MySQL','Book',75.34,'2017-09-20 18:24:11');

INSERT INTO `items` (`ID`, `Name`, `Description`, `Price`, `DateTimeAdded`)
VALUES
	(2,'Modular Programming with PHP 7','Book',87.43,'2017-09-20 18:25:03');
