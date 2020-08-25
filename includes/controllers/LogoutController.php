<?php
/**
 * Контроллер LogoutController
 */
class LogoutController {
	/**
   * Удаляем данные о пользователе из сессии
   */
	public function actionLogout()
	{
	// Удаляем информацию о пользователе из сессии
	User::logout();
	// Перенаправляем пользователя на главную страницу
	header('location: index.php/?page=1');
	}
}
?>