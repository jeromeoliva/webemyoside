CREATE TABLE IF NOT EXISTS `EeProfilCompetence` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CategoryId` INT  NULL ,
`Code` VARCHAR(200)  NULL ,
`Name` VARCHAR(200)  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeProfil_competenceCategory_EeProfil_competence` FOREIGN KEY (`CategoryId`) REFERENCES `EeProfilCompetenceCategory`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 