SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';


-- -----------------------------------------------------
-- Table `entry`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `entry` ;

CREATE  TABLE IF NOT EXISTS `entry` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `title` VARCHAR(255) NULL ,
  `body` TEXT NULL ,
  `created` DATETIME NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table `comment`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `comment` ;

CREATE  TABLE IF NOT EXISTS `comment` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `entry` INT UNSIGNED NOT NULL ,
  `body` TEXT NULL ,
  `created` DATETIME NULL ,
  PRIMARY KEY (`id`, `entry`) ,
  INDEX `fk_comment_entry` (`entry` ASC) ,
  CONSTRAINT `fk_comment_entry`
    FOREIGN KEY (`entry` )
    REFERENCES `entry` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
