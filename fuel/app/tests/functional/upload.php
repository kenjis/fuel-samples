<?php
/**
 * FuelPHP 1.x Samples
 *
 * @author     Kenji Suzuki https://github.com/kenjis
 * @copyright  2012 Kenji Suzuki
 * @license    MIT License http://www.opensource.org/licenses/mit-license.php
 */

use GuzzleHttp\Client;
use GuzzleHttp\Promise;

/**
* Upload Functional Tests
*
* @group Functional
*/
class Test_Functional_Upload extends FunctionalTestCase
{	
	public static function setUpBeforeClass()
	{
		parent::setUpBeforeClass();
	}
	
	public function test_フォームにアクセス()
	{
		try
		{
			static::$crawler = static::$client->request('GET', static::open('upload'));
		}
		catch (Exception $e)
		{
			echo $e->getMessage(), PHP_EOL, 'Error: レスポンスエラーです。', PHP_EOL;
			exit;
		}
		
		//var_dump(static::$client->getResponse()->getContent());
		//exit;
		
		$this->assertNotNull(static::$crawler);
	}
	
	public function test_レスポンスコードの確認()
	{
		$this->assertEquals(200, static::$client->getResponse()->getStatus());
	}

	public function test_レスポンスヘッダの確認()
	{
		$test = static::$client->getResponse()->getHeader('Content-Type');
		$expected = 'text/html; charset=UTF-8';
		$this->assertEquals($expected, $test);
	}
	
	public function test_titleの確認()
	{
		$expected = 'アップロードフォーム';
		$this->assertEquals($expected, static::$crawler->filter('title')->text());
	}
	
	public function test_同時アップロード()
	{
		/*
		Content-Disposition: form-data; name="file"; filename="drops.png"
		Content-Type: image/png
		*/
		
		system("rm " . DOCROOT . 'public/uploads/drops*.png');

		$client = new Client(['base_uri' => static::open('')]);

		// Initiate each request but do not block
		$expected = 20;  // 同時アクセス
		for ($i = 0; $i < $expected; $i++)
		{
			$promises[$i] = $client->postAsync('upload', [
				'multipart' => [
					[
						'name'     => 'file',
						'contents' => fopen(APPPATH.'tests/fixture/drops.png', 'r')
					],
				]
			]);
		}
		
		// Wait on all of the requests to complete.
		$results = Promise\unwrap($promises);

		$test = system("ls " . DOCROOT . 'public/uploads/drops*.png | wc -l');
		
		$this->assertEquals($expected, $test);
		
		/* 以下は filename が拡張子なしの一時ファイルになってしまうため
		 * アップロードエラーになる
		$form = static::$crawler->selectButton('form_submit')->form();
		$form['file']->upload(APPPATH . 'tests/fixture/drops.png');
		static::$crawler = static::$client->submit($form);
		*/
	}
}
