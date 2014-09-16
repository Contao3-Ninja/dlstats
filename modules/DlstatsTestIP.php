<?php
/**
 * Run in a custom namespace, so the class can be replaced
 */
namespace BugBuster\DLStats;

/**
 *
 * @author bibo
 *        
 */
class DlstatsTestIP extends \Module 
{
    /**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'mod_dlstats_fe_test_ip';
    
	
	/**
	 * Display a wildcard in the back end
	 * @return string
	 */
	public function generate()
	{
	    if (TL_MODE == 'BE')
	    {
	        $objTemplate = new \BackendTemplate('be_wildcard');
	        $objTemplate->wildcard = '### DLStats Test IP ###';
	        $objTemplate->title = $this->headline;
	        $objTemplate->id = $this->id;
	        $objTemplate->link = $this->name;
	        $objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;
	
	        return $objTemplate->parse();
	    }
	    return parent::generate();
	}
	
	/**
	 * Generate module
	 */
	public function compile()
	{   //TESTS, only with patch in Environment class
	    //if ($strKey == 'ip') { static::$arrCache[$strKey] = static::$strKey(); return static::$arrCache[$strKey];} 
	    //141.39.2.1    : $_SERVER['REMOTE_ADDR'] = '141.39.2.1'; $_SERVER['HTTP_X_FORWARDED_FOR'] = '192.168.17.144';
	    //92.168.17.144 : $_SERVER['REMOTE_ADDR'] = '141.39.2.1'; $_SERVER['HTTP_X_FORWARDED_FOR'] = '92.168.17.144';
	    //141.39.2.1 :    $_SERVER['REMOTE_ADDR'] = '141.39.2.1'; 
	    //141.39.2.1 :    $GLOBALS['TL_CONFIG']['proxyServerIps']='8.8.8.8,141.39.2.1'; $_SERVER['REMOTE_ADDR'] = '141.39.2.1, 8.8.8.8';$_SERVER['HTTP_X_FORWARDED_FOR'] = '192.168.17.144';
	    //92.168.17.144 : $GLOBALS['TL_CONFIG']['proxyServerIps']='8.8.8.8,141.39.2.1'; $_SERVER['REMOTE_ADDR'] = '141.39.2.1, 8.8.8.8';$_SERVER['HTTP_X_FORWARDED_FOR'] = '92.168.17.144';
	    //141.39.2.1    : $GLOBALS['TL_CONFIG']['proxyServerIps']='8.8.8.8'; $_SERVER['REMOTE_ADDR'] = '141.39.2.1, 8.8.8.8';
	    $env_remote_addr = (isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR']: '---';
	    $env_forward_for = (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR']: '---';
	    $env_proxy_server_ips = (strlen($GLOBALS['TL_CONFIG']['proxyServerIps'])>0) ? $GLOBALS['TL_CONFIG']['proxyServerIps'] : '---';
	    $env_ip = \Environment::get('ip');
	    $objHelper = new \DLStats\DlstatsHelper();
	    $ip_by_dlstats = $objHelper->dlstatsGetIp();
	    $ip_version = $objHelper->dlstatsGetIpVersion();
	    
	    $this->Template->env_remote_addr = $env_remote_addr;
	    $this->Template->env_forward_for = $env_forward_for;
	    $this->Template->env_proxy_server_ips = $env_proxy_server_ips;
	    $this->Template->env_ip = $env_ip;
	    $this->Template->ip_by_dlstats = $ip_by_dlstats;
	    $this->Template->ip_version  = $ip_version;
	     
	}
}
