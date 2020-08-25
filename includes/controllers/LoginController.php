<?php
/**
 * Контроллер LoginController
 */
class LoginController{
	/**
     * Action для страницы "Вход на сайт"
     */
	public static function actionLogin(){
		// Переменные для формы
		$name = '';
		$password = '';
		// Обработка формы
		if(isset($_POST['login']))
		{
				// Если форма отправлена 
        // Получаем данные из формы
				$name = $_POST['username1'];
				$password = $_POST['password1'];

				// Флаг ошибок
				$errors = false;
		}
		// Валидация полей
		if($name!='' && $password !=''){
		if(!User::checkName($name)){
			$errors[] = 'Имя не должно быть короче 2-х символов';
		}
		if(!User::checkPassword($password)) {
			$errors[] = 'Пароль не должен быть короче 2-х символов';
		}
		// Проверяем существует ли пользователь
		$userId = User::checkUserAuthData($name, $password);

		if($userId == false) {
			// Если данные неправильные - показываем ошибку
			$errors[] = 'Неправильные данные для входа на сайт';
		}
		else{
			// Если данные правильные, запоминаем пользователя (сессия)
			User::auth($userId);
		}
	}
		// Подключаем вид
		require_once(ROOT.'/includes/views/Login.php');

		return true;
	}
}
?>
