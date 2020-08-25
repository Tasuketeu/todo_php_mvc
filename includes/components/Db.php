	<?php
	/**
 * Класс Db
 * Компонент для работы с базой данных
 */
	class Db
{
	/**
     * Устанавливает соединение с базой данных
     * @return mysqli <p>Объект класса mysqli для работы с БД</p>
     */
		public static function con()
	{
	  $db = mysqli_connect('localhost','root','','todo') or die(mysqli_error($db));
	  return $db;
	}
}
?>