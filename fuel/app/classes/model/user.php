<?php

class Model_User extends Orm\Model
{
	protected static $_table_name = 'users';

	protected static $_properties = array(
		'id',
		'username',
		'group',
		'profile_fields',
		'last_login',
		'login_hash',
	);
}
