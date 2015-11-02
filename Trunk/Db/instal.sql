CREATE TABLE IF NOT EXISTS `EeAgendaEvent` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `UserId` int(11) ,
  `Title` varchar(500) NOT NULL,
  `DateStart` DATETIME NULL ,
  `DateEnd` DATETIME NULL ,
  `Commentaire` varchar(500) NOT NULL,
  `AppName` VARCHAR(200)  NULL ,
  `AppId` INT  NULL ,
  `EntityName` VARCHAR(200)  NULL ,
  `EntityId` INT  NULL ,
  PRIMARY KEY (`Id`),
  CONSTRAINT `eeAgenda_event` FOREIGN KEY (`UserId`) REFERENCES ee_user(`Id`))
  ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;

CREATE TABLE IF NOT EXISTS `EeAgendaMember` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `EventId` int(11) ,
  `UserId` int(11) ,
  `Accept` TINYINT(1)  NULL ,
  PRIMARY KEY (`Id`),
  CONSTRAINT `eeAgenda_member_user` FOREIGN KEY (`UserId`) REFERENCES ee_user(`Id`),
  CONSTRAINT `eeAgenda_member_event` FOREIGN KEY (`EventId`) REFERENCES EeAgendaEvent(`Id`))
  ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`;

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

CREATE TABLE IF NOT EXISTS `EeMessageMessage` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`Subjet` VARCHAR(200)  NULL ,
`Message` TEXT  NULL ,
`DateCreated` DATE  NULL ,
`ParentId` INT  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_EeMessageMessage` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `EeMessageUser` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`MessageId` INT  NULL ,
`UserId` INT  NULL ,
`Read` INT  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `EeMessageMessage_EeMessageUser` FOREIGN KEY (`MessageId`) REFERENCES `EeMessageMessage`(`Id`),
CONSTRAINT `ee_user_EeMessageUser` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 


CREATE TABLE IF NOT EXISTS `EeNotifyNotify` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`UserId` INT  NULL ,
`Code` VARCHAR(200)  NULL ,
`Description` TEXT  NULL ,
`DateCreate` DATE  NULL ,
`DestinataireId` INT  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_eeNotify_notify` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`Id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 

CREATE TABLE IF NOT EXISTS `EePadDocument` ( 
`Id` int(11) NOT NULL AUTO_INCREMENT, 
`Name` VARCHAR(200)  NULL ,
`UserId` INT  NULL ,
`DateCreated` DATE  NULL ,
`DateModified` DATE  NULL ,
`Content` TEXT  NULL ,
`AppName` VARCHAR(200)  NULL ,
`AppId` INT  NULL ,
`EntityName` VARCHAR(200)  NULL ,
`EntityId` INT  NULL ,
PRIMARY KEY (`Id`),
CONSTRAINT `ee_user_EePadDocument` FOREIGN KEY (`UserId`) REFERENCES `ee_user`(`id`)
) ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; 


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


INSERT INTO EeProfilCompetenceCategory (Code, Name)
VALUES
('Administration', 'Administration'),
('Animation', 'Animation'),
('Editorial', 'Éditorial'),
('GestionDeProjet', 'Gestion de projet'),
('MarketingEtCommerce', 'Marketing et commerce'),
('Programmation', 'Programmation et d&nbsp;veloppement'),
('Graphisme', 'Graphisme'),
('ExpertComptable', 'Expert Comptable'),
('AccompagnementEntreprise', 'Accompagnement entreprise');


INSERT INTO EeProfilCompetence (Code, Name, CategoryId) 
VALUES
('AdministrateurSiteWeb', 'Administration de site Web', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'Administration' )),
('ExpertSecuriteInformatique', 'Expert en securite informatique', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'Administration' )),

('AnimateurSiteWeb', 'Animateur de site Web', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'Animation' )),
('CommunityManager', 'Community manager', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'Animation' )),

('JournalisteEnLigne', 'Journaliste en ligne', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'Editorial' )),
('ProducteurVideo', 'Producteur video', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'Editorial' )),

('ChefDeProjetFonctionnel', 'Chef de projet fonctionnel', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'GestionDeProjet' )),
('ChefDeProjetTecnique', 'Chef de projet technique', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'GestionDeProjet' )),
('ConcepteurWeb', 'Concepteur web', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'GestionDeProjet' )),

('Business developer', 'Business developer', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'MarketingEtCommerce' )),
('Commercial', 'Commercial', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'MarketingEtCommerce' )),
('Webmarketeur', 'Webmarketeur', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'MarketingEtCommerce' )),

('ArchitecteWeb', 'Architecte Web', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'Programmation' )),
('DeveloppeurMobile', 'Développeur mobile', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'Programmation' )),
('DeveloppeurMultimedia', 'Développeur Multimédia', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'Programmation' )),
('DeveloppeurWeb', 'Développeur web', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'Programmation' )),
('IntegrateurHTML', 'Intégrateur HTML', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'Programmation' )),

('DesignerFlash', 'Designer Flash', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'Graphisme' )),
('Illustrateur3D', 'Illustrateur 3D', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'Graphisme' )),
('Webdesigner', 'Webdesigner', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'Graphisme' )),

('ExpertComptable', 'ExpertComptable', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'ExpertComptable' )),
('AideFinancement', 'AideRechercheFinancement', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'ExpertComptable' )),

('ConseilCreation', 'Conseil création', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'AccompagnementEntreprise' )),
('RealisationEtudeDeMarche', 'Realisation étude de Marche', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'AccompagnementEntreprise' )),
('RealisationBusinnesPlan', 'Realisation de businnes Plan', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'AccompagnementEntreprise' )),
('MontageFinancier', 'Montage Financier', (SELECT Id FROM EeProfilCompetenceCategory WHERE Code =  'AccompagnementEntreprise' ));