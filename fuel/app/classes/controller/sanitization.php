<?php
/**
 * FuelPHP 1.x Samples
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License <http://www.opensource.org/licenses/mit-license.php>
 * @copyright  2016 Kenji Suzuki
 * @link       https://github.com/kenjis/fuel-samples
 */

class Controller_Sanitization extends Controller
{
	public function action_index()
	{
		// Orm\Model implements Sanitization interface
		$user = new Model_User();
		$user->id = 1;
		$user->username = '<s>abc</s>';
		$user->group = 1;
		
		// Not escaped
		var_dump($user->username);
		
		$data['user'] = $user;
		$view = View::forge('sanitization/index', $data);
		
		// Output filter htmlentities automatically turns on sanitization
		echo $view;
		
		// Escaped because sanitization is on
		var_dump($user->username);
		
		// Turn off sanitization
		$user->unsanitize();
		// Not escaped
		var_dump($user->username);
	}
}
