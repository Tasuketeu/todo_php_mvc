<?php
/**
 * Класс Router
 * Компонент для работы с маршрутами
 */
class Router {
    /**
     * Свойство для хранения массива роутов
     * @var array 
     */
	private $routes;
	/**
     * Конструктор
     */
	public function __construct()
	{
		// Путь к файлу с роутами
		$routesPath = ROOT.'/includes/routes/Routes.php';

		// Получаем роуты из файла
		$this->routes = include($routesPath);
	}
	/**
     * Возвращает строку запроса
     */
	private function getRoute() 
	{
		if(!empty($_SERVER['REQUEST_URI']))
		{
			if(strpos(ROOT,'/'))
			{
			$segments = explode('/',ROOT);
			}
			if(strpos(ROOT,'\\'))
			{
			$segments = explode('\\',ROOT);
			}

			$url_segments = explode('/',$_SERVER['REQUEST_URI']);
			$url = "";

			foreach ($url_segments as $key=>$url_segment) {
				$url_array[$key] = $url_segment;
			}

			foreach ($segments as $value) {
				foreach ($url_array as $key=>$url_segment) {
						if($value==$url_segment){
						$url_array[$key] = str_replace($value, "", $url_segment);
						break;
						}
				}
			}

			$i = 0;
			foreach ($url_array as $key=>$url_segment) {

				if($url_array[$key]!=""){
					if($i==0){
						$url .= $url_array[$key] . '/';
					}
					if($i==1){
						$url .= $url_array[$key];
					}
					if($i>1){
						$url .= '/' . $url_array[$key];
					}
					$i++;
				}
			}

			return $url;
		}
	}
    /**
     * Метод для обработки запроса
     */
	public function run() {

				// Получаем строку запроса
				//get request string
				$uri = $this->getRoute();
				// Проверяем наличие такого запроса в массиве маршрутов (routes.php)
				//check if request exists in routes array (routes.php)
				foreach ($this->routes as $uriPattern => $path) {
					// Сравниваем $uriPattern и $uri
					if(preg_match("~$uriPattern~", $uri))
					{
							// Получаем внутренний путь из внешнего согласно правилу
							$internalRoute = preg_replace("~$uriPattern~", $path, $uri);
							// Определить контроллер, action, параметры
							$segments = explode('/',$internalRoute);

							$controllerName = ucfirst(array_shift($segments));
							$controllerName .= 'Controller';

							$actionName = 'action'.ucfirst(array_shift($segments));
							$parameters = $segments;

							// Подключить файл класса-контроллера
							$controllerFile = ROOT.'/includes/controllers/'.$controllerName. '.php';
							if(file_exists($controllerFile)) {
								include_once($controllerFile);
							}
							// Создать объект, вызвать метод (т.е. action)
							$controllerObject = new $controllerName;
							/* Вызываем необходимый метод ($actionName) у определенного 
                 * класса ($controllerObject) с заданными ($parameters) параметрами
                 */
							$result = call_user_func_array(array($controllerObject, $actionName), $parameters);
							// Если метод контроллера успешно вызван, завершаем работу роутера
							if($result!=null) {
								break;
							}
					}

				}
	}

}
?>