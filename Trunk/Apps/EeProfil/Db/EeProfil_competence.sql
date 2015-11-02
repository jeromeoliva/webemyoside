CREATE TABLE IF NOT EXISTS `EeProfil_competence` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`CategoryId` INT  NULL ,
`Code` VARCHAR(200)  NULL ,
`Name` VARCHAR(200)  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeProfil_competenceCategory_EeProfil_competence` FOREIGN KEY (`CategoryId`) REFERENCES `EeProfil_competenceCategory`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 