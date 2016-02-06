<?php
/**
 * FuelPHP 1.x Samples
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License <http://www.opensource.org/licenses/mit-license.php>
 * @copyright  2016 Kenji Suzuki
 * @link       https://github.com/kenjis/fuel-samples
 */

class Controller_Validation extends Controller
{
	protected function get_validation()
	{
		$val = Validation::forge();
		$val->add('username', 'Your username')
			->add_rule('trim')
			->add_rule('required');
		$val->add('password', 'Your password')
			->add_rule('trim')
			->add_rule('required')
			->add_rule('min_length', 3);
		$val->add('gender', 'Your gender')
			->add_rule('required')
			->add_rule('match_collection', ['M', 'F']);

		return $val;
	}

	public function action_index()
	{
		$_POST = [
			'username' => '   MyName   ',
			'password' => '   MyPassword   ',
			'gender'   => 'F',
		];

		$val = $this->get_validation();

		if ($val->run($_POST))
		{
			echo '<pre>Pass'."\n\n";
		}
		else
		{
			echo '<pre>Fail'."\n\n";
		}

		echo 'Input::post():'."\n";
		// Input data are not changed
		var_dump(Input::post());
		echo "\n";
		
		echo '$val->validated():'."\n";
		// username and password are trimed
		var_dump($val->validated());
		echo "\n";
		
		echo '$val->error_message():'."\n";
		// No errors
		var_dump($val->error_message());
	}

	public function action_extra()
	{
		$_POST = [
			'username' => '   MyName   ',
			'password' => '   MyPassword   ',
			'gender'   => 'F',
			'dummy'    => 'dummy',	// extra field
		];

		$val = $this->get_validation();

		if ($val->run($_POST))
		{
			echo '<pre>Pass'."\n\n";
		}
		else
		{
			echo '<pre>Fail'."\n\n";
		}

		echo 'Input::post():'."\n";
		// Input data has dummy field
		var_dump(Input::post());
		echo "\n";
		
		echo '$val->validated():'."\n";
		// validated() does not return dummy field
		var_dump($val->validated());
		echo "\n";
		
		echo '$val->error_message():'."\n";
		// No errors
		var_dump($val->error_message());
	}

	public function action_partial()
	{
		$_POST = [
			'username' => '   MyName   ',
			'gender'   => 'F',
		];

		$val = $this->get_validation();

		// Partical validation (2nd argment = true)
		if ($val->run($_POST, true))
		{
			echo '<pre>Pass'."\n\n";
		}
		else
		{
			echo '<pre>Fail'."\n\n";
		}

		echo 'Input::post():'."\n";
		var_dump(Input::post());
		echo "\n";
		
		echo '$val->validated():'."\n";
		var_dump($val->validated());
		echo "\n";
		
		echo '$val->error_message():'."\n";
		// No errors
		var_dump($val->error_message());
	}
}
