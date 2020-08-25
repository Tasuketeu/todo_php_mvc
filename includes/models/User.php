<?php
/**
 * Класс User - модель для работы с пользователями
 */
class User {
	    /**
     * Регистрация пользователя 
     * @param string $username <p>Имя</p>
     * @param string $password <p>Пароль</p>
     * @param string $email <p>E-mail</p>
     */
		public static function register(&$username,&$password,&$email){

			// Соединение с БД
			$db=Db::con();

			// Получение и возврат результатов. Используется подготовленный запрос
			$resultSelect = $db->prepare("INSERT INTO users(name,email,password) VALUES (?,?,?)");
			$resultSelect->bind_param("sss",$username,$email,$password);
			$resultSelect->execute();

		}

    /**
     * Проверяем, существует ли пользователь с заданными $email и $username для регистрации
     * $email и $username должны быть уникальными
     * @param string $username <p>Имя</p>
     * @param string $email <p>E-mail</p>
     * @return boolean <p>Результат выполнения запроса</p>
     */
		public function isUserExisted(&$username,&$email){

			// Соединение с БД
			$db=Db::con();

			// Получение и возврат результатов. Используется подготовленный запрос
			$resultSelect = $db->prepare("SELECT * FROM users WHERE name=(?) and email=(?)");
			$resultSelect->bind_param("ss",$username,$email);
			$resultSelect->execute();
			$result=$resultSelect->get_result();
			$count = mysqli_num_rows($result);

			if($count==1)
			{
				return true;
			}
			else{
				return false;
			}
		}

    /**
     * Проверяем, является ли пользователь админом
     * @param string $user <p>Имя</p>
     * @return boolean <p>Результат выполнения запроса</p>
     */
	public function isAdmin($user){

		// Соединение с БД
		$db=Db::con();

		// Получение и возврат результатов. Используется подготовленный запрос
		$resultSelect = $db->prepare("SELECT adminMode FROM users WHERE name=(?)");
		$resultSelect->bind_param("s",$user);
		$resultSelect->execute();
		$result=$resultSelect->get_result();
		$result=mysqli_fetch_array($result);
		if($result['adminMode']==1){
			 return true;
		}
		 return false;
	}

	    /**
     * Проверяем, существует ли пользователь с заданными $username и $password для авторизации
     * $username и $password должны совпадать
     * @param string $username <p>Имя</p>
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения запроса</p>
     */
	public function checkUserAuthData($username,$password){

		// Соединение с БД
		$db=Db::con();
		
		// Получение и возврат результатов. Используется подготовленный запрос
		$resultSelect = $db->prepare("SELECT * FROM users WHERE name=(?) and password=(?)");
		$resultSelect->bind_param("ss",$username,$password);
		$resultSelect->execute();
		$result=$resultSelect->get_result();
		$count = mysqli_num_rows($result);
		if($count==1){
			return $username;
		}
		return false;
	}

	/**
		 * Запоминаем пользователя
		 * @param integer $userId <p>id пользователя</p>
		 */
		public static function auth($userId)
		{
				// Записываем идентификатор пользователя в сессию
				$_SESSION['user'] = $userId;
		}

	/**
		 * Выход из аккаунта 
		 * Уничтожение сессии пользователя
		 */
		public function logout()
		{
		unset($_SESSION['user']);
		}
	
		    /**
     * Проверяет имя: не меньше, чем n символа
     * @param string $name <p>Имя</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
	public static function checkName($name){
		if(strlen($name)>=2){
			return true;
		}
		return false;
	}

		    /**
     * Проверяет пароль: не меньше, чем n символа
     * @param string $password <p>Пароль</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
	public static function checkPassword($password){

		if(strlen($password)>=2){
			return true;
		}
		return false;
	}

    /**
     * Проверяет email
     * @param string $email <p>E-mail</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
	public static function checkEmail($email){
		if(filter_var($email,FILTER_VALIDATE_EMAIL)){
			return true;
		}
		return false;
	}
}
?>