<?php
/* 
 * Dit object is het Data Access Object (DAO) voor het User model
 * @package Site_Model_Db
 */

/**
 * UserDao geeft toegang tot de gegevens voor een gebruiker in de database
 *
  */
class Site_Model_Db_UserDao extends Zend_Db_Table_Abstract
{
	protected $_name = 'users';
	protected $_primary = 'id';
}