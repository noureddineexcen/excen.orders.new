<?php
class Site_View_Helper_OddEvenSwitcher extends Zend_View_Helper_Abstract
{
    /**
     * How many times the view helper has been called.
     * @var int
     */
    public static $callCount = 0;

    /**
     * Each time this method is called it keeps an internal count of
     * how many times it has been called and if that count is even,
     * it will return the even content, otherwise the odd content will
     * be returned.
     * @param mixed $evenContent The value to return if even
     * @param mixed $oddContent The value to return if odd
     * @return mixed Either the even content passed in or odd content.
     */
    public function oddEvenSwitcher($oddContent = '', $evenContent = '')
    {
        self::$callCount++;

        // if the call count is even return the even content
        if ((self::$callCount%2) == 0) {
            return $evenContent;
        }

        // otherwise return the odd content
        return $oddContent;
    }

}
