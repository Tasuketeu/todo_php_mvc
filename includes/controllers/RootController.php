<?php
/**
 * Контроллер RootController
 */
class RootController {
	/**
    * Action для главной страницы 
    */
	public function actionIndex()
	{
		//Подключаем модуль pagination
		Pagination::getPage($page);
		Pagination::getSort($sort);
		Pagination::getOrder($order);
		Pagination::generateSortButtons($page,$sort,$sortBtn);
		Pagination::doPagination($result1,$pagesCount,$page);
		//Проверяем авторизацию пользователя
		// Check auth
		if(isset($_SESSION['user']))
		{
				$uname=$_SESSION['user'];
		}
		// Подключаем вид
		require_once(ROOT.'/includes/views/Root.php');

		return true;
	}

}
?>