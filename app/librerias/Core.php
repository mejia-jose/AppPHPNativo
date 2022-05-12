<?php
	class Core {
		protected $controladorActual = 'Redireccion';
		protected $metodoActual = 'index';
		protected $parametros = [];

		public function __construct(){
			$url = $this->getUrl();

			if (isset($url) && file_exists('../app/controllers/'.ucwords($url[0]).'.php')) {
				$this->controladorActual = ucwords($url[0]);
			
				unset($url[0]);

				require_once '../app/controllers/'.$this->controladorActual.'.php';
				$this->controladorActual = new $this->controladorActual;

				if (isset($url[1])) {
					if (method_exists($this->controladorActual, $url[1])) {
						$this->metodoActual = $url[1];

						unset($url[1]);
					}
				}
			}else{
				require_once '../app/controllers/'.$this->controladorActual.'.php';
				
				$this->controladorActual = new $this->controladorActual;
						
				if (isset($url[0])) {
					if (method_exists($this->controladorActual, $url[0])) {
						$this->metodoActual = $url[0];
	
						unset($url[0]);
					}
				}
			}

			$this->parametros = $url ? array_values($url) : [];
			call_user_func_array([$this->controladorActual, $this->metodoActual], $this->parametros);
		}

		public function getUrl(){
			if (isset($_GET['url'])) {
				$caracter = substr($_GET['url'], -1);

				$url = rtrim($_GET['url'], '/');

				if($caracter=='/'){
					header("Location: ".RUTA_URL."/".$url);
				}else{
					$url = filter_var($url, FILTER_SANITIZE_URL);
					$url = explode('/',$url);
				}

				return $url;
			}
		}
	}
?>