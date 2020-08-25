<?php

/**
 * Класс Pagination - модель для генерации постраничной навигации
 */
class Pagination
{
	/**
     * Возвращает текущую страницу
     * @return integer $page <p>Номер страницы</p>
     */
	public function getPage(&$page){

		if(isset($_GET['page'])){
			$page=$_GET['page'];
		}
		else{
			$page=1;
		}
	}
		/**
     * Возвращает сортировку
     * @return string $sort <p>Тип сортировки</p>
     */
		public function getSort(&$sort){

				if(isset($_GET['sort'])){
				$sort=$_GET['sort'];
		}
		else{
			$sort='ASC';
		}
	}
		/**
     * Возвращает столбец, по которому производится сортировка
     * @return string $order <p>Столбец, по которому производится сортировка</p>
     */
			public function getOrder(&$order){

						if(isset($_GET['order']))
		{
				 $order=$_GET['order']; 
		} 
		else{$order='id';} 
	}
		/**
     * Отвечает за генерирование ссылок для кнопок сортировки
     * @param array $textArr <p>Массив с типами сортировки</p>
     * @param string $sort <p>Тип сортировки</p>
     * @return string $sortBtn <p>Ссылка с данными о типе сортировки</p>
     */
	public function generateSortButtons($page,$sort,&$sortBtn){

		$textArr = array(
				"name" => "Имя пользователя",
				"email" => "E-mail",
				"status" => "Статус",
			);

			$sort=='DESC'? $sort='ASC' : $sort='DESC';

			foreach ($textArr as $order => $text) {
				$sortBtn[$order] = "<a href=\"index.php/?page=$page&&order=$order&&sort=$sort\">$text</a>";
			}
	}
		/**
     * Отвечает за пагинацию
     * @param integer $tasksOnPage <p>Максимальное кол-во записей на одной странице</p>
     * @param integer $pagesCount <p>Кол-во страниц</p>
     */
public function doPagination(&$result1,&$pagesCount,&$page){
	// Соединение с БД
	$db=Db::con();
	$tasksOnPage = 3;
	$fromTask = ($page -1) * $tasksOnPage;

	if(isset($_GET['order'])){
		$order = $_GET['order'];
		$sort = $_GET['sort'];

		$orderWhiteList = array(
				"id",
				"name",
				"email",
				"status",
			);
		$sortWhiteList = array(
				"ASC",
				"DESC",
			);
		// Получение и возврат результатов. Используется подготовленный запрос
		foreach ($orderWhiteList as $orderwl) {
			foreach ($sortWhiteList as $sortwl) {
		if(($order==$orderwl)&&($sort==$sortwl))
		{
		$query = "SELECT * FROM tasks,statuses WHERE id>0 AND status=status_id ORDER BY $order $sort LIMIT $fromTask,$tasksOnPage";
		$result1 = mysqli_query($db,$query) or die(mysqli_error($db));
		}
	}
}
	}
	else{
			$query = "SELECT * FROM tasks,statuses WHERE id>0 AND status=status_id ORDER BY id ASC LIMIT $fromTask,$tasksOnPage";
			$result1 = mysqli_query($db,$query) or die(mysqli_error($db));
	}

	$query = "SELECT COUNT(*) as count FROM tasks";
	$result2 = mysqli_query($db,$query) or die(mysqli_error($db));
	$count = mysqli_fetch_assoc($result2)['count'];
	$pagesCount = ceil($count/$tasksOnPage);
	}
}

		?>