<?php
/**
 * ControllerAbstract.php
 *
 * @author M Madadi
 * @copyright De Montfort University
 *
 * @package CryptoShow system CMS
 */
//var_dump(get_included_files());
abstract class ControllerAbstract
{
    protected $html_output;

    public function __construct()
    {
        $this->html_output = '';
    }

    public final function __destruct(){}

    public function getHtmlOutput(): string
    {
        return $this->html_output;
    }

    abstract protected function createHtmlOutput();

}
