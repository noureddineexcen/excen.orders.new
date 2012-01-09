<?php
class Site_Model_Role extends Zend_Db_Table_Abstract
{
    protected $_name = 'roles';
    protected $_primary = 'id';
    protected $_dependentTables = array('User');

    /**
     * get rolename by role_id
     * @param integer $iRoleId
     * @return string/boolean
     */
    public function getRoleName($iRoleId) {
        $select = $this->select('rolename');
        $select->where('id = ?', $iRoleId);
        $row = $this->fetchRow($select)->toArray();
        return $row;
    }
}