<?php
class Site_Model_TestSoap extends Site_Model_ParentTestSoap
{

    /**
     * Geeft de nederlandse namen en countrycodes van beschikbare landen terug
     * @return array met landen
     */
    public function getCountries()
    {
        if ( APPLICATION_ENV == 'development')
        {
            return $this->soapClient->getCountries();
        }

        return array(
            'Nederland' => '0031',
            'Belgie'    => '0032'
        );
    }
}