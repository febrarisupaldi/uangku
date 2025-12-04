-- MariaDB dump 10.17  Distrib 10.4.11-MariaDB, for Win64 (AMD64)
--
-- Host: 127.0.0.1    Database: uangku
-- ------------------------------------------------------
-- Server version	10.4.11-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping events for database 'uangku'
--
/*!50106 SET @save_time_zone= @@TIME_ZONE */ ;
/*!50106 DROP EVENT IF EXISTS `check_monthly_admin_fee` */;
DELIMITER ;;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client  = utf8 */ ;;
/*!50003 SET character_set_results = utf8 */ ;;
/*!50003 SET collation_connection  = utf8_general_ci */ ;;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;;
/*!50003 SET @saved_time_zone      = @@time_zone */ ;;
/*!50003 SET time_zone             = 'SYSTEM' */ ;;
/*!50106 CREATE*/ /*!50117 DEFINER=`paldi`@`localhost`*/ /*!50106 EVENT `check_monthly_admin_fee` ON SCHEDULE EVERY 1 DAY STARTS '2025-11-13 12:30:00' ON COMPLETION NOT PRESERVE ENABLE COMMENT 'Daily check Admin Fee' DO BEGIN
	
	INSERT INTO `uangku`.`expenses` (
	  `user_id`,
	  `payment_id`,
	  `expense_category_id`,
	  `expense_title`,
	  `expense_amount`,
	  `expense_date`,
	  `description`,
	  `created_at`
	)
	select payment.user_id, wallet.payment_id, 9, CONCAT('Biaya Admin ',wallet.name), wallet.`nominal_admin_fee`,CURRENT_DATE(), CONCAT('Biaya Admin ',wallet.name), NOW() from uangku.wallets as wallet 
	join uangku.payments as payment on wallet.payment_id = payment.id  
	where wallet.admin_fee = 1 and wallet.date_admin_fee = date_format(CURRENT_DATE(),'%d');
	
	 UPDATE uangku.wallets AS wallet
	    JOIN uangku.payments AS payment ON wallet.payment_id = payment.id
	    SET wallet.balance = wallet.balance - wallet.nominal_admin_fee
	    WHERE wallet.admin_fee = 1
	      AND wallet.date_admin_fee = DATE_FORMAT(CURRENT_DATE(), '%d');
  END */ ;;
/*!50003 SET time_zone             = @saved_time_zone */ ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;;
/*!50003 SET character_set_client  = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection  = @saved_col_connection */ ;;
/*!50106 DROP EVENT IF EXISTS `check_monthly_subs` */;;
DELIMITER ;;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;;
/*!50003 SET character_set_client  = utf8 */ ;;
/*!50003 SET character_set_results = utf8 */ ;;
/*!50003 SET collation_connection  = utf8_general_ci */ ;;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;;
/*!50003 SET sql_mode              = 'NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */ ;;
/*!50003 SET @saved_time_zone      = @@time_zone */ ;;
/*!50003 SET time_zone             = 'SYSTEM' */ ;;
/*!50106 CREATE*/ /*!50117 DEFINER=`paldi`@`localhost`*/ /*!50106 EVENT `check_monthly_subs` ON SCHEDULE EVERY 1 DAY STARTS '2025-10-15 16:00:40' ON COMPLETION NOT PRESERVE DISABLE COMMENT 'Daily check subscription' DO BEGIN
	declare trans_type, hari, subs_id, last_id integer;
	    SELECT id, subscriptions_type_id  into subs_id,trans_type from uangku.`subscriptions` where subscription_days = DATE_FORMAT(CURRENT_DATE(), '%d');
	    if(trans_type = 1) then
		INSERT INTO `uangku`.`expenses` (
		  `user_id`,
		  `payment_id`,
		  `expense_category_id`,
		  `expense_title`,
		  `expense_amount`,
		  `expense_date`,
		  `description`
		)
		select
		user_id,
		credit_cards_id,
		expense_category_id,
		subscriptions_name,
		amount,
		current_date(),
		subscriptions_name
		from uangku.`subscriptions`
		where subscription_days = DATE_FORMAT(CURRENT_DATE(), '%d') and subscriptions_type_id = 1;
		
		select last_insert_id into last_id;
		
		insert into uangku.`expense_subscriptions`(
		subscriptions_id, expneses_id) values (subs_id, last_id);
	    end if;
	END */ ;;
/*!50003 SET time_zone             = @saved_time_zone */ ;;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;;
/*!50003 SET character_set_client  = @saved_cs_client */ ;;
/*!50003 SET character_set_results = @saved_cs_results */ ;;
/*!50003 SET collation_connection  = @saved_col_connection */ ;;
DELIMITER ;
/*!50106 SET TIME_ZONE= @save_time_zone */ ;

--
-- Dumping routines for database 'uangku'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-04 10:15:34
