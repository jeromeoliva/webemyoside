CREATE TABLE IF NOT EXISTS `EeIdeProjet` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`Name` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`UserId` INT NOT NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,

PRIMARY KEY (`Id`),
CONSTRAINT `EeIdeProjet_user` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 