<?php

class AjaxController extends Controller
{
	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow(array('loadData', 'export', 'getPreview'));
	}

	public function loadData()
	{ 
		$directory 	= FILES_ROOT.'Templates';
		$path 		= FILES.'Templates'.DS;
		$iterator 	= new DirectoryIterator($directory);

		$content 	= array();

		foreach($iterator as $file)
		{
			if($file->isDot() || !$file->isDir())
				continue;

			try
			{
				$tmp = array(
					'name' => $file->getFilename(),
					'path' => base64_encode($path.$file->getFilename())
				);

				// Load controllers
				$controllers 	= array();
				$controllersDir = new DirectoryIterator($directory.DS.$file->getFilename().DS.'Controllers');

				foreach($controllersDir as $c)
				{
					if($c->isDot() || $c->isDir() || strpos($c->getFilename(), 'Controller.php') == false)
						continue;

					$controllers[] = array(
						'name' => substr($c->getFilename(), 0, strlen($c->getFilename()) - strlen('Controller.php'))
					);
				}
				$tmp['modules'] = $controllers;

				// Load pages
				$pages 		= array();
				$viewsDir 	= new DirectoryIterator($directory.DS.$file->getFilename().DS.'Views');

				foreach($viewsDir as $pc)
				{
					// Si ce n'est pas une "catégorie" de page valide
					if($pc->isDot() || !$pc->isDir() || $pc->getFilename() == 'Elements' || $pc->getFilename() == 'Errors' || $pc->getFilename() == 'Layouts')
						continue;

					$pages[$pc->getFilename()] = array();
					$pageDir = new DirectoryIterator($directory.DS.$file->getFilename().DS.'Views'.DS.$pc->getFilename());

					foreach($pageDir as $page)
					{
						if($page->isDot() || $page->isDir())
							continue;

						$pages[$pc->getFilename()][] = array(
							'name' => substr($page->getFilename(), 0, strlen($page->getFilename()) - strlen('.php'))
						);
					}
				}
				
				$tmp['pages'] = $pages;

				// Write content
				$content[] = $tmp;
			}
			catch(Exception $e)
			{
				continue;
			}
		}

		$this->set(compact('content'));
	}

	public function getPreview()
	{
		if(is_array($this->request->data))
		{
			$path = FILES_ROOT.'Templates'.DS.$this->request->data['name'].DS.'preview.html';

			if(file_exists($path))
				echo file_get_contents($path);
		}
		die();
	}

	public function export()
	{
		$date = date("d-m-Y_H-i-s");

		if(isset($this->request->data['template']) 	&& is_array($this->request->data['template'])
		&& isset($this->request->data['pages']) 	&& is_array($this->request->data['pages'])
		&& isset($this->request->data['modules']) 	&& is_array($this->request->data['modules'])
		&& isset($this->request->data['db']) 		&& is_array($this->request->data['db']))
		{
			$template 	= $this->request->data['template'];
			$pages 		= $this->request->data['pages'];
			$modules 	= $this->request->data['modules'];
			$db 		= $this->request->data['db'];

			$directory 	= FILES_ROOT.'generated'.DS.$date;

			// Si le dossier existe: erreur, sinon il est créé
			if(file_exists($directory))
			{
				$this->set('error', 'Generated directory already exists');
				return false;
			}

			// On copie le coeur de la MVC
			$this->recursive_copy(FILES_ROOT.'MVC', $directory);

			// On copie le contenu du template
			$template['path'] = FILES_ROOT.'Templates'.DS.$template['name'];

			$this->recursive_copy($template['path'].DS.'Models', $directory.DS.'Models');
			$this->recursive_copy($template['path'].DS.'webroot', $directory.DS.'webroot');
			mkdir($directory.DS.'Views', 0777);
			$this->recursive_copy($template['path'].DS.'Views'.DS.'Elements', $directory.DS.'Views'.DS.'Elements');
			$this->recursive_copy($template['path'].DS.'Views'.DS.'Errors', $directory.DS.'Views'.DS.'Errors');
			$this->recursive_copy($template['path'].DS.'Views'.DS.'Layouts', $directory.DS.'Views'.DS.'Layouts');

			// Modules
			mkdir($directory.DS.'Controllers', 0777);

			// Create SQL script based on modules
			$script  = "CREATE DATABASE IF NOT EXISTS `".base64_decode($db['name'])."`;\n";
			$script .= "USE `".base64_decode($db['name'])."`;\n\n";

			// Table `config` commune à tous les sites générés
			$script .= "CREATE TABLE IF NOT EXISTS `configs` (
  `key` varchar(30) NOT NULL,
  `generated` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `enabled` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `value` text NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;\n\n";

			// Routes
			if(file_exists($template['path'].DS.'Routes'.DS.'default.php'))
				$routes = "<?php\n\n".file_get_contents($template['path'].DS.'Routes'.DS.'default.php')."\n\n";

			for($i = 0; $i < count($modules); $i++)
			{
				copy($template['path'].DS.'Controllers'.DS.$modules[$i]['name'].'Controller.php',
					 $directory.DS.'Controllers'.DS.$modules[$i]['name'].'Controller.php'
				);

				$this->recursive_copy($template['path'].DS.'Views'.DS.$modules[$i]['name'], $directory.DS.'Views'.DS.$modules[$i]['name']);

				if(file_exists($template['path'].DS.'Scripts'.DS.$modules[$i]['name'].'.sql'))
					$script .= file_get_contents($template['path'].DS.'Scripts'.DS.$modules[$i]['name'].'.sql')."\n\n";
				$script .= "INSERT INTO `configs` (`key`, `generated`, `enabled`, `value`) VALUES ('module_".strtolower($modules[$i]['name'])."', '1', '1', '".$modules[$i]['name']."');\n\n";

				if(file_exists($template['path'].DS.'Routes'.DS.$modules[$i]['name'].'.php'))
					$routes .= file_get_contents($template['path'].DS.'Routes'.DS.$modules[$i]['name'].'.php')."\n\n";

				if(file_exists($template['path'].DS.'Dependencies'.DS.$modules[$i]['name'].'.txt'))
				{
					$deps = explode(',', str_replace(' ', '', file_get_contents($template['path'].DS.'Dependencies'.DS.$modules[$i]['name'].'.txt')));

					for($j = 0; $j < count($deps); $j++)
					{
						$inarray = false;

						foreach($modules as $value)
						{
							if($value['name'] == $deps[$j])
							{
								$inarray = true;
								break;
							}
						}

						if(!$inarray)
							array_push($modules, array('name' => $deps[$j]));
					}
				}
			}

			// Write SQL
			file_put_contents($directory.DS.base64_decode($db['name']).'.sql', $script);

			// Write Routes.php
			$routes .= "\n\n?>";
			file_put_contents($directory.DS.'Core'.DS.'Routes.php', $routes);

			// Update Config.php
			$config = file_get_contents($directory.DS.'Core'.DS.'Config.php');
			$config = str_replace('[[DB_HOST]]', base64_decode($db['host']), $config);
			$config = str_replace('[[DB_NAME]]', base64_decode($db['name']), $config);
			$config = str_replace('[[DB_LOGIN]]', base64_decode($db['user']), $config);
			$config = str_replace('[[DB_PASS]]', base64_decode($db['pass']), $config);
			file_put_contents($directory.DS.'Core'.DS.'Config.php', $config);

			// Si l'archive est correctement créée, on renvoie l'url de téléchargement et on supprime le dossier
			if($this->create_zip($directory))
				$this->set('url', FILES.'generated'.DS.$date.'.zip');
			else
				$this->set('error', 'Unable to create ZIP file');

			$this->recursive_rmdir($directory);
		}
		else
			$this->set('error', 'Invalid data specified');
	}
	
	private function recursive_copy($source, $dest, $mode = 0777, $itMode = RecursiveIteratorIterator::SELF_FIRST)
	{
		$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS), $itMode);

		if(!file_exists($dest))
			mkdir($dest, $mode, true);

		foreach($iterator as $item)
		{
			if(!file_exists($dest.DS.$iterator->getSubPathName()))
			{
			  	if($item->isDir())
			  	    mkdir($dest.DS.$iterator->getSubPathName(), $mode);
			    else
			    	copy($item, $dest.DS.$iterator->getSubPathName());
			}
		}
	}

	private function recursive_rmdir($dir) 
	{
		if(is_dir($dir)) 
		{
			$files = array_diff(scandir($dir), array('.', '..'));
			foreach($files as $file)
				is_dir($dir.DS.$file) ? $this->recursive_rmdir($dir.DS.$file) : unlink($dir.DS.$file);

			return rmdir($dir);
		}
		else
			return false;
	}

	private function create_zip($source, $dest = '', $overwrite = false)
	{
		if($dest === '')
			$dest = $source.'.zip';

		if(!file_exists($source)
		|| (file_exists($dest) && !$overwrite))
			return false;

		$zip = new ZipArchive();

		if($zip->open($dest, $overwrite ? ZIPARCHIVE::OVERWRITE : ZIPARCHIVE::CREATE) !== true)
			return false;

		$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST);
		$lastDir = null;
		$filesCount = 0;

		foreach($iterator as $item)
		{
			$fullPath = substr($item, strlen($source)+1);

			if($lastDir == null || $lastDir != substr($fullPath, 0, strpos($fullPath, $item->getFilename())))
			{
				$lastDir = substr($fullPath, 0, strpos($fullPath, $item->getFilename()));
				$filesCount = 0;
			}

		  	if(!$item->isDir() && ($filesCount == 0 || $filesCount >= 1 && $item->getFilename() != 'empty'))
		  	{
		    	$zip->addFile($item, $fullPath);
		    	$filesCount++;
		  	}
		}

		$zip->close();

		return file_exists($dest);
	}

}

?>