		<?php
		/**
 * Класс Task - модель для работы с задачами
 */
		class Task
{
	    /**
     * Добавление задачи 
     * @param string $name <p>Имя</p>
     * @param string $email <p>E-mail</p>
     * @param string $task <p>Задача</p>
     * @param string $task <p>Статус</p>
     */
		public function addTask(&$name,&$email,&$task,&$status)
	{
		// Соединение с БД
		$db = Db::con();

		//Защита от XSS-уязвимости
		$task = htmlspecialchars($_POST['task']);

		//Если пользователь залогинился, тогда подставляем его email в списке для его задачи
		//Иначе используем email, введенный в форме
		// Получение и возврат результатов. Используется подготовленный запрос
		if(isset($_SESSION['user'])){
		$name = $_SESSION['user'];

		$resultSelect = $db->prepare("SELECT email FROM users WHERE name=(?)");
		$resultSelect->bind_param("s",$name);
		$resultSelect->execute();
		$result=$resultSelect->get_result();
		$email=mysqli_fetch_array($result) or die(mysqli_error($db));

		$resultSelect = $db->prepare("INSERT INTO tasks (name,email,task,status) VALUES (?,?,?,?)");
		$resultSelect->bind_param("sssi",$name,$email[0],$task,$status);
		}
		else{
		$name = $_POST['username'];
		$email = $_POST['email'];
		$resultSelect = $db->prepare("INSERT INTO tasks (name,email,task,status) VALUES (?,?,?,?)");
		$resultSelect->bind_param("sssi",$name,$email,$task,$status);
		}
		$resultSelect->execute();
		$result=$resultSelect->get_result();
	}
	    /**
     * Удаление задачи 
     * @param integer $id <p>id задачи</p>
     */
	public function deleteTask($id){

		// Соединение с БД
		$db = Db::con();

		// Получение и возврат результатов. Используется подготовленный запрос
		$id=$_GET['del_task'];
		$resultSelect = $db->prepare("DELETE FROM tasks WHERE id=(?)");
		$resultSelect->bind_param("i",$id);
		$resultSelect->execute();
	}
		    /**
     * Отвечает за создание куки для информации о редактируемой задаче
     * @param integer $id <p>id задачи</p>
     */
		public function onPressEditButton(){
					setcookie('editor',$_GET['row_num'],time()+3600,"/");
					setcookie('editedTaskId',$_GET['edit_task'],time()+3600,"/");
					setcookie('usname',$_GET['editor_name'],time()+3600,"/");
					setcookie('edit_status',$_GET['edit_status'],time()+3600,"/");
					setcookie('task1',$_GET['tasks'],time()+3600*24,"/");
					setcookie('page1',$_GET['page'],time()+3600*24,"/");
		}
		    /**
     * Отвечает за изменение информации о задаче и статусе
     * @param string $editedTask <p>новый текст задачи</p>
     * @param string $editedStatusId <p>новый статус задачи</p>
		 * @param boolean $isAdmin <p>является ли пользователь админом</p>
     */
		public function editTaskAndStatus($editedTask,$editedStatusId,$isAdmin){

			// Соединение с БД
			$db = Db::con();
			
			// Получение и возврат результатов. Используется подготовленный запрос
			$resultSelect = $db->prepare("UPDATE tasks SET task=(?),status=(?), admin_status=(?) WHERE name=(?) AND id=(?)");

			$resultSelect->bind_param("siisi",$editedTask,$editedStatusId,$isAdmin,$_COOKIE['usname'],$_COOKIE['editedTaskId']);
			$resultSelect->execute();
		}
		    /**
     * Отвечает за изменение информации о задаче
     * @param string $editedTask <p>новый текст задачи</p>
		 * @param boolean $isAdmin <p>является ли пользователь админом</p>
     */
		public function editTask($editedTask,$isAdmin){

					// Соединение с БД
					$db = Db::con();

					// Получение и возврат результатов. Используется подготовленный запрос
					$resultSelect = $db->prepare("UPDATE tasks SET task=(?), admin_status=(?) WHERE name=(?) AND id=(?)");

					$resultSelect->bind_param("sisi",$editedTask,$isAdmin,$_COOKIE['usname'],$_COOKIE['editedTaskId']);
					$resultSelect->execute();
		}
		    /**
     * Отвечает за изменение информации о статусе
     * @param string $editedStatusId <p>новый статус задачи</p>
     */
		public function editStatus($editedStatusId){

					// Соединение с БД
					$db = Db::con();

					// Получение и возврат результатов. Используется подготовленный запрос
					$resultSelect = $db->prepare("UPDATE tasks SET status=(?) WHERE name=(?) AND id=(?)");
					$resultSelect->bind_param("isi",$editedStatusId,$_COOKIE['usname'],$_COOKIE['editedTaskId']);
					$resultSelect->execute();
		}
		    /**
     * Проверяет имя: не меньше, чем n символа
     * @param string $name <p>Имя</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
			public static function checkName($name){

				if(strlen($name)>=2)
				{
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

    /**
     * Проверяет текст задачи
     * @param string $task <p>Текст задачи</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
	public static function checkTask($task){

		if(strlen($task)>=6){
			return true;
		}
		return false;
	}

    /**
     * Проверяет статус задачи
     * @param string $status <p>Статус задачи</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
	public static function checkStatus($status){

		if($status==0){
			return false;
		}
		return true;
	}
	
	}
		?>