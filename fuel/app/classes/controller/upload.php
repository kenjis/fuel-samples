<?php
/**
 * FuelPHP 1.x Samples
 *
 * @author     Kenji Suzuki https://github.com/kenjis
 * @copyright  2012 Kenji Suzuki
 * @license    MIT License http://www.opensource.org/licenses/mit-license.php
 */

class Controller_Upload extends Controller
{
	function get_index()
	{	
		// ビューファイル upload/index.php を表示
		return Response::forge(View::forge('upload/index'));
	}
	
	function post_index()
	{
		// Upload クラスの設定
		$config = array(
			'path'          => DOCROOT . 'uploads/',         // 保存先フォルダ
			'ext_whitelist' => array('gif', 'jpg', 'png'),  // 許可する拡張子
			'max_size'      => 100 * 1024,                  // 最大サイズ(100KB)
		);
		
		// 画像のチェック
		Upload::register('validate', function (&$file) {
			if ($file['error'] == Upload::UPLOAD_ERR_OK)
			{
				switch($file['extension'])
				{
					case 'jpg':
					case 'png':
					case 'gif':
						//Debug::dump($file);
						
						$checkImage = getimagesize($file['file']);
						$type = $checkImage[2];  // 画像タイプを取得
						if ($checkImage === false)
						{
							return Upload::UPLOAD_ERR_EXT_BLACKLISTED;
						}
						else if ($file['extension'] === 'gif' && $type !== IMAGETYPE_GIF)
						{
							return Upload::UPLOAD_ERR_EXT_BLACKLISTED;
						}
						else if ($file['extension'] === 'png' && $type !== IMAGETYPE_PNG)
						{
							return Upload::UPLOAD_ERR_EXT_BLACKLISTED;
						}
						else if ($file['extension'] === 'jpg' && $type !== IMAGETYPE_JPEG)
						{
							return Upload::UPLOAD_ERR_EXT_BLACKLISTED;
						}
						break;
					default:
				}
			}
		});
		
		// アップロード処理
		Upload::process($config);
		
		if (Upload::is_valid())
		{
			// ファイルを保存
			Upload::save();
		}
		
		// エラーがある場合
		foreach (Upload::get_errors() as $file)
		{
			$error = $file['errors']['0']['message'];
				
			$view = View::forge('upload/index');
			$view->set('error', $error);
				
			return Response::forge($view);
		}
		
		// 成功したファイル
		foreach (Upload::get_files() as $file)
		{	
			// upload/success ビューを表示
			$view = View::forge('upload/success');
			$view->set('file_data', $file);
			
			return Response::forge($view);
		}
	}
}
