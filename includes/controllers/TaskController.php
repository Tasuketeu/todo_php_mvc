<?php
/**
 * Контроллер TaskController
 */
class TaskController {
	/**
     * Action для добавления задачи
     */
	public function actionAdd()
	{
		  // Переменные для задачи
			$name = '';
			$email = '';
			$task = '';
			$status = '';
			// Обработка формы
			if(isset($_POST['addTask']))
		{
			// Если форма отправлена 
      // Получаем данные из формы
			$name = $_POST['username'];
			$email = $_POST['email'];
			$task = $_POST['task'];
			$status = $_POST['status1'];
			// Флаг ошибок
			$errors = false;
			// Флаг успешного выполнения
			$success = false;
		}
		// Валидация полей
		if(!Task::checkName($name)){
			$errors[] = 'Имя не должно быть короче 2-х символов';
		}
		if(!Task::checkEmail($email)){
			$errors[] = 'Неправильный email';
		}
		if(!Task::checkTask($task)) {
			$errors[] = 'Задача не должна быть короче 6-ти символов';
		}
		if(!Task::checkStatus($status)) {
			$errors[] = 'Необходимо выбрать статус задачи!';
		}
		if(!$errors){
			// Если ошибок нет
      // Создаем сообщение об успешном добавлении задачи
			$success[] = 'Задача была успешно добавлена!';
			// Добавляем задачу в общий список
			Task::addTask($name,$email,$task,$status);
		}
		//Создаем куки сообщений об успехе и ошибках
		$json = json_encode($errors);
		$json1 = json_encode($success);
		setcookie('error',$json,time()+60,"/");
		setcookie('success',$json1,time()+60,"/");

		// Перенаправляем пользователя на главную страницу
		header('location: /index.php');
	}
	/**
    * Action для редактирования задачи
    */
	public function actionEdit()
	{
				//Проверяем авторизацию пользователя
				if(isset($_SESSION['user'])){

				//Проверяем, является ли пользователь администратором
				$isAdmin = User::isAdmin($_SESSION['user']);

				//Проверяем, может ли пользователь редактировать данную задачу
				if(($isAdmin==1)||($_SESSION['user']==$_GET['editor_name'])){

					if(isset($_GET['edit_task'])){

				//Устанавливаем куки для начального текста задачи, статуса, режима редактора и т.д.
				//set cookies for initial status text, task text, editorMode etc.
				Task::onPressEditButton();
			}
				if(isset($_POST['editedTask'])){

					//По нажатии на кнопку "Завершить редактирование" заканчиваем работу редактора
					setcookie('editor','',time()-3600,"/");

				//Если текст, статус были изменены отправляем изменения в базу данных  
				if(($_COOKIE['task1']!=$_POST['editedTask'])&&empty($_POST['status']))
				{
				 Task::editTask($_POST['editedTask'],$isAdmin);
				}

				if(isset($_POST['status'])){

				if($_COOKIE['task1']!=$_POST['editedTask'])
				{
				Task::editTaskAndStatus($_POST['editedTask'],$_POST['status'],$isAdmin);
				}
				else if($_COOKIE['edit_status']!=$_POST['status']){
					Task::editStatus($_POST['status'],$isAdmin);
				}

				}

				}
				//Изменяем статус без нажатия на кнопку "Завершить редактирование"
				if(isset($_POST['status'])){
					if($_COOKIE['edit_status']!=$_POST['status']){
				Task::editStatus($_POST['status']);
						}
				}
			}
		// Перенаправляем пользователя на главную страницу
		$page=$_GET['page'];
		header('location: /index.php/?page=' . $page);
		}
			else{
				// Перенаправляем пользователя на страницу авторизации
				header('location: /login.php');

				// Заканчиваем работу редактора
				setcookie('editor','',time()-3600,"/");
			}
		
	}
	/**
    * Action для удаления задачи
    */
	public function actionDelete()
	{
		//Проверяем авторизацию пользователя
		if($_SESSION['user']){
			//Проверяем, является ли пользователь администратором
			$isAdmin = User::isAdmin($_SESSION['user']);
					//Проверяем, может ли пользователь удалить данную задачу
					if(($_SESSION['user']==$_GET['user_name']) || $isAdmin)
					{
						//Удаляем данную задачу
						Task::deleteTask($_GET['del_task']);  
					}
		}
		//Перенаправление пользователя на нужную страницу списка задач на главной странице
		$page=$_GET['page'];
		header('location: /index.php/?page=' . $page);
	}
}
?>