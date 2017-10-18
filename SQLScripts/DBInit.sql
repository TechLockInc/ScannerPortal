CREATE TABLE `ScannerPortal`.`appliances` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `ClientCode` VARCHAR(5) NOT NULL,
  `ClientName` VARCHAR(45) NOT NULL,
  `Tunnel` VARCHAR(16) NOT NULL,
  `External` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`id`));

CREATE TABLE `ScannerPortal`.`routes` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `Subnet` VARCHAR(16) NOT NULL,
  `Mask` VARCHAR(16) NOT NULL,
  `Gateway` INT NOT NULL,
  PRIMARY KEY (`ID`),
  INDEX `fk_Routes_Appliances_idx` (`Gateway` ASC),
  CONSTRAINT `fk_Routes_Appliances`
    FOREIGN KEY (`Gateway`)
    REFERENCES `ScannerPortal`.`Appliances` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);
