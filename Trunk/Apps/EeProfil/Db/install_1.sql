CREATE TABLE IF NOT EXISTS `EeProfilCompetenceCategory` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`Code` VARCHAR(200)  NULL ,
`Name` VARCHAR(200)  NULL ,
PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `EeProfilCompetence` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CategoryId` INT  NULL ,
`Code` VARCHAR(200)  NULL ,
`Name` VARCHAR(200)  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeProfil_competenceCategory_EeProfil_competence` FOREIGN KEY (`CategoryId`) REFERENCES `EeProfilCompetenceCategory`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `EeProfilCompetenceEntity` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CompetenceId` INT  NULL ,
`UserId` INT  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 
