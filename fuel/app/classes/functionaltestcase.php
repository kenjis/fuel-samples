<?php
/**
 * FuelPHP 1.x Samples
 *
 * @author     Kenji Suzuki https://github.com/kenjis
 * @copyright  2012 Kenji Suzuki
 * @license    MIT License http://www.opensource.org/licenses/mit-license.php
 */

require_once APPPATH . 'vendor/Goutte/goutte.phar';
//require_once APPPATH . 'vendor/Goutte/vendor/autoload.php';

use Goutte\Client;

abstract class FunctionalTestCase extends \Fuel\Core\TestCase
{
	const BASE_URL = 'http://localhost/fuel-samples/';
	
	protected static $client;  // Clientオブジェクト
	protected static $crawler; // Crawlerオブジェクト
	protected static $post;    // POSTデータ
	
	public static function setUpBeforeClass()
	{
		// .htaccessをテスト環境用に変更
		$htaccess = DOCROOT . 'public/.htaccess';
		if ( ! file_exists($htaccess . '_develop'))
		{
			$ret = rename($htaccess, $htaccess . '_develop');
			if ($ret === false)
			{
				exit('Error: can\'t backup ".htaccess" !');
			}
		}
		$ret = copy($htaccess . '_test', $htaccess);
		if ($ret === false)
		{
			exit('Error: can\'t copy ".htaccess_test" !');
		}
		
		// GoutteのClientオブジェクトを生成
		static::$client = new Client();
	}
	
	public static function tearDownAfterClass()
	{
		static::$client  = null;
		static::$crawler = null;
		static::$post    = null;
		
		// .htaccessを開発環境用に戻す
		$htaccess = DOCROOT . 'public/.htaccess';
		copy($htaccess . '_develop', $htaccess);
	}
	
	// 絶対URLを返す
	public static function open($uri)
	{
		return static::BASE_URL . $uri;
	}
}
