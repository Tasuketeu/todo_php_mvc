<?php
/**
 * Контроллер RegisterController
 */
class RegisterController {
/**
     * Action для страницы "Регистрация"
     */
	public function actionRegister()
	{
    // Переменные для формы  
		$name = '';
		$email = '';
		$password = '';
		// Обработка формы
		if(isset($_POST['register']))
		{
			// Если форма отправлена 
      // Получаем данные из формы
			$name = $_POST['username'];
			$email = $_POST['email'];
			$password = $_POST['password'];

			// Флаг ошибок
			$errors = false;

			// Валидация полей
			if($name!='' && $email!='' && $password !=''){
			if(!User::checkName($name)){
				$errors[] = 'Имя не должно быть короче 2-х символов';
			}

			if(!User::checkEmail($email)){
				$errors[] = 'Неправильный email';
			}

			if(!User::checkPassword($password)){
				$errors[] = 'Пароль не должно быть короче 2-ти символов';
			}
			if(User::isUserExisted($name, $email)){
				$errors[] = 'Такой пользователь уже существует';
			}

			if($errors == false){
				// Если ошибок нет
        // Регистрируем пользователя
				User::register($name,$password,$email);
			}

			}
		}
		// Подключаем вид
		require_once(ROOT.'/includes/views/Register.php');

		return true;
	}
}
?>