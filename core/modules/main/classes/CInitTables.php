<?
class CInitTables 
{
	function NewTableForPlatform()
	{
		global $DB;	
		
		////Данные о компании
		$strSql = "
			CREATE TABLE IF NOT EXISTS ga_company (
				`ID`				int(11) NOT NULL AUTO_INCREMENT, 
				`ACTIVE`			text	NOT NULL,
				`NAME`				text	NOT NULL,
				`PHONE`				text	NOT NULL,
				`ADDRESS`			text	NOT NULL,
				`ADDRESS_MAP`		text	NOT NULL,
				`EMAIL`				text	DEFAULT NULL,
				`LOGO`				text	DEFAULT NULL,
				`DESCRIPTION`		text	DEFAULT NULL,
				PRIMARY KEY			(`ID`)
			)
		";	
		$rs = $DB->Query($strSql);
		echo "Данные о компании <br>";
		
		////Данные о клиенте
		$strSql = "
			CREATE TABLE IF NOT EXISTS ga_user (
				`ID`				int(11) NOT NULL AUTO_INCREMENT,
				`ACTIVE`			text	NOT NULL,
				`FIRST_NAME`		text	NOT NULL,
				`PHONE`				text	DEFAULT NULL,
				`MAIN_AUTO`			text	NOT NULL,
				`EMAIL`				text	DEFAULT NULL,
				`AVATAR`			text	DEFAULT NULL,
				`SESSION`			text	DEFAULT NULL,
				PRIMARY KEY			(`ID`)
			)
		";	
		$rs = $DB->Query($strSql);
		echo "Данные о клиенте <br>";
		
		////Отзывы о компании
		$strSql = "
			CREATE TABLE IF NOT EXISTS ga_rewview (
				`ID`				int(11) NOT NULL AUTO_INCREMENT,
				`ACTIVE`			text	NOT NULL,
				`RATING`			text	NOT NULL,
				`ANONIME`			text	NOT NULL,
				`DESCRIPTION`		text	NOT NULL,
				`ID_USER`			int(11)	NOT NULL,
				`ID_COMPANY`		int(11)	NOT NULL,				
				PRIMARY KEY 		(`ID`),
				KEY `ga_user`		(`ID_USER`),
				KEY `ga_company`	(`ID_COMPANY`)
			)
		";	
		$rs = $DB->Query($strSql);	
		echo "Отзывы о компании <br>";
		
		////Авто клиента
		$strSql = "
			CREATE TABLE IF NOT EXISTS ga_user_car (
				`ID`					int(11) NOT NULL AUTO_INCREMENT,
				`ACTIVE`				text	NOT NULL,
				`ID_USER`				int(11)	NOT NULL,			
				`ID_CAR_MARK`			int(11)	NOT NULL,			
				`ID_CAR_MODEL`			int(11)	NOT NULL,			
				`ID_CAR_GENERATION`		int(11)	DEFAULT NULL,			
				`ID_CAR_SERIE`			int(11)	DEFAULT NULL,			
				`ID_CAR_MODIFICATION`	int(11)	DEFAULT NULL,			
				PRIMARY KEY				(`ID`),
				KEY `ga_user`			(`ID_USER`),
				KEY `car_mark`			(`ID_CAR_MARK`),
				KEY `ga_model`			(`ID_CAR_MODEL`),
				KEY `car_generation`	(`ID_CAR_GENERATION`),
				KEY `car_serie`			(`ID_CAR_SERIE`),
				KEY `car_modification`	(`ID_CAR_MODIFICATION`)
			)
		";		
		$rs = $DB->Query($strSql);	
		echo "Авто клиента <br>";
		
		////Поддерживаемые авто,обслуживание по гарантии
		$strSql = "
			CREATE TABLE IF NOT EXISTS ga_specifical (
				`ID`					int(11) NOT NULL AUTO_INCREMENT,
				`ID_CAR_MARK`			int(11)	NOT NULL,
				`ID_COMPANY`			int(11)	NOT NULL,
				`SERVICE_GUARANTEE`		int(11)	NOT NULL,	
				PRIMARY KEY 			(`ID`),		
				KEY `car_mark`			(`ID_CAR_MARK`),
				KEY `ga_company`		(`ID_COMPANY`)					
			)
		";	
		$rs = $DB->Query($strSql);
		echo "Поддерживаемые авто,обслуживание по гарантии <br>";
		
		////Ремонт
		$strSql = "
			CREATE TABLE IF NOT EXISTS ga_allservices (
				`ID`					int(11) NOT NULL AUTO_INCREMENT,
				`ACTIVE`				int(11)	NOT NULL,
				`ID_ALLSERVICES`			int(11)	NOT NULL,	
				`MAINPATH`				text	DEFAULT NULL,			
				`NAME`					text	NOT NULL,			
				PRIMARY KEY 			(`ID`),		
				KEY `ga_allservices`	(`ID_ALLSERVICES`)				
			)
		";	
		$rs = $DB->Query($strSql);
		echo "Ремонт <br>";
		
		////Цены на ремонт и услуги
		$strSql = "
			CREATE TABLE IF NOT EXISTS ga_prices (
				`ID`					int(11) NOT NULL AUTO_INCREMENT,
				`ID_COMPANY`			int(11)	NOT NULL,
				`ID_CAR_MARK`			int(11)	NOT NULL,
				`ID_ALLREPAIRS`			int(11)	NOT NULL,
				`PRICE`					text	DEFAULT NULL,		
				PRIMARY KEY 			(`ID`),
				KEY `car_mark`			(`ID_CAR_MARK`),
				KEY `ga_company`		(`ID_COMPANY`),	
				KEY `ga_allservices`	(`ID_ALLREPAIRS`)				
			)
		";	
		$rs = $DB->Query($strSql);
		echo "Цены на ремонт и услуги <br>";
		
		////Заказ в компанию от клиента
		$strSql = "
			CREATE TABLE IF NOT EXISTS ga_order (
				`ID`				int(11) NOT NULL AUTO_INCREMENT,
				`ID_COMPANY`		int(11)	NOT NULL,
				`ID_USER`			int(11)	NOT NULL,	
				`ID_PRICES`			int(11)	NOT NULL,	
				`FIRST_NAME`		text	NOT NULL,				
				`PHONE`				text	NOT NULL,	
				`DATE`				text	NOT NULL,	
				`COMMENT`			text	DEFAULT NULL,		
				PRIMARY KEY 		(`ID`),
				KEY `ga_user`		(`ID_USER`),
				KEY `ga_company`	(`ID_COMPANY`),				
				KEY `ga_prices`		(`ID_PRICES`)				
			)
		";	
		$rs = $DB->Query($strSql);		
		echo "Заказ в компанию от клиента <br>";		
		return $rs;
	}
}
?>