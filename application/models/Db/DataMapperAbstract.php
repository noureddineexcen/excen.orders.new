<?php
/*
 * @package Site_Model_Db
 */

/**
 * Deze klasse is de verbinding tussen de Model-klasse en de bijbehorende DAO-klasse. Het zorgt ervoor
 * dat applicatielogica volledig wordt gescheiden van de opslag van gegevens.
 * Iedere Model-klasse die gegevens opslaat in de database, krijgt een eigen DataMapper die is
 * afgeleidt van dit object
 *
 */
abstract class Site_Model_Db_DataMapperAbstract
{
	/**
	 * Het object dat toegang tot de database geeft
	 * @var Zend_Db_Table_Abstract $_dao
	 */
	private $_dao;

	/**
	 * constructor
	 */
	public function __construct($dao) {
		$this->setDao($dao);
	}
	/**
	 * zet het object dat de database acties uitvoert. Krijgt of een DAO object of een string
	 * @param Zend_Db_Table_Abstract|string $dao
	 * @throws InvalidArgumentException
	 */
	public function setDao($dao) {
		if (is_string($dao)) {
		// creeer een DAO object
			$dao = new $dao();
		}
		if (!$dao instanceof Zend_Db_Table_Abstract) {
			throw new InvalidArgumentException('DAO is nog correct type');
		}
		$this->_dao = $dao;
	}

	/**
	 * @return Zend_Db_Table_Abstract
	 */
	public function getDao() {
		return $this->_dao;
	}

	/**
	 * sla de gegevens van het gegeven modelobject op in de database
	 * @param object $model
	 * @throws InvalidArgumentException
	 */
	//abstract public function save($model);

	/**
	 * Zoek het record met het gegeven id en geef een gevuld model object terug. Als
	 * het id niet wordt gevonden, wordt null teruggegeven
	 * De tweede parameter is optioneel. Wordt deze niet meegegeven, dan wordt een nieuw
	 * object geretourneerd
	 * @param int $id
	 * @param object $model
	 * @return object|null
	 */
	abstract public function find($id, $model = null);
        
	/**
	 *
	 * verwijder het object met het gegeven id
	 * @param int $id
	 * @return int het aantal verwijderde records
	 */
//	public function delete($id) {
//		// delete altijd vanuit het row-obejct, dit is nodig voor cascading deletes
//		$select = $this->getDao()->select();
//		$select->where('id = ?', $id);
//		$row = $this->getDao()->fetchRow($select);
//		if (null !== $row) {
//			return $row->delete();
//		} else {
//			return 0;
//		}
//	}

	/**
	 * Geef een array met model-objecten voor alle records in de database
	 * @return array
	 */
//	public function fetchAll() {
//		return $this->createObjectArray($this->getDao()->fetchAll());
//	}

    /**
     * Geef een array met model-object voor het gegeven filter (Select-object)
     * @param string|array|Zend_Db_Table_Select $where  OPTIONAL An SQL WHERE clause or Zend_Db_Table_Select object.
     * @param string|array                      $order  OPTIONAL An SQL ORDER clause.
     * @param int                               $count  OPTIONAL An SQL LIMIT count.
     * @param int                               $offset OPTIONAL An SQL LIMIT offset.
     * @return array
     */
//	public function fetchFiltered($where = null, $order = null, $count = null, $offset = null) {
//		return $this->createObjectArray($this->getDao()->fetchAll($where, $order, $count, $offset));
//	}

	/**
	 * vul een array met objecten van het juiste type
	 * @param Zend_Db_Table_Rowset_Abstract $rowset
	 * @return array
	 */
	//abstract protected function createObjectArray(Zend_Db_Table_Rowset_Abstract $rowset);
}