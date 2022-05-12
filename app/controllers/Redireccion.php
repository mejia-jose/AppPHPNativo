<?php
	class Redireccion extends Controlador
    {
		public function __construct()
        {
			session_start();
		}

		public function index()
		{
			$this->vista('empleado', NULL);
		}

	}
?>
