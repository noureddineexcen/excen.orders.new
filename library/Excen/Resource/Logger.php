<?php
class Excen_Resource_Logger extends Zend_Application_Resource_ResourceAbstract
{
	/**
	 * @var Zend_Log
	 */
	protected $_logger;

	/**
	 *
	 * @return Zend_Log
	 */
	public function init()
	{
		$this->getBootstrap()->bootstrap('FrontController');
		return $this->getLogger();
	}

	/**
	 * lees de opties uit application.ini en maak een log-object aan dat in de
	 * registry wordt gezet. Deze is vanuit de hele code te gebruiken voor debug-logging
	 * @return Zend_Log
	 */
	public function getLogger()
	{
		if (null === $this->_logger) {
			$options = $this->getOptions();

			if (!isset($options['debuglog'])) {
				throw new Exception("Debug log path undefined in application.ini");
			}
			try {
				$writer = new Zend_Log_Writer_Stream($options['debuglog']);
				$this->_logger = new Zend_Log($writer);
			} catch (Exception $e) {
				$this->_logger = null;
			}

			if (isset($options['firebug']) && ("1" == $options['firebug'])) {
				try {
					$writer = new Zend_Log_Writer_Firebug();
					if (null !== $this->_logger) {
						$this->_logger->addWriter($writer);
					} else {
						$this->_logger = new Zend_Log($writer);
					}
				} catch (Exception $e) {
					$this->_logger = null;
				}
			}
			// voeg eventueel een uitvoer filter toe
			if ((null !== $this->_logger) && isset($options['loglevel'])) {
				try {
					$loglevel = intVal($options['loglevel']);
					$filter = new Zend_Log_Filter_Priority($loglevel);
					$this->_logger->addFilter($filter);
				} catch (Exception $e) {

				}
			}
		}
		// voeg toe aan de registry zodat we deze later eenvoudig kunnen gebruiken
		if (null !== $this->_logger) {
			$this->_logger->info('==========================================================');
			Zend_Registry::set('logger', $this->_logger);
		}

		return $this->_logger;
	}
}

