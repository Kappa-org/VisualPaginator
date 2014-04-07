<?php

/**
 * Nette Framework Extras
 *
 * This source file is subject to the New BSD License.
 *
 * For more information please see http://extras.nettephp.com
 *
 * @copyright  Copyright (c) 2009 David Grudl
 * @license    New BSD License
 * @link       http://extras.nettephp.com
 * @package    Nette Extras
 * @version    $Id: VisualPaginator.php 4 2009-07-14 15:22:02Z david@grudl.com $
 */

namespace Kappa\VisualPaginator;

use Nette\Application\UI\Control;

/**
 * Visual paginator control.
 *
 * @author     David Grudl
 * @copyright  Copyright (c) 2009 David Grudl
 * @package    Nette Extras
 */
class Paginator extends Control
{
	/** @var Paginator */
	private $paginator;

	/** @persistent */
	public $page = 1;

	/** @var string */
	private $fileTemplate;

	public function setTemplate($template)
	{
		if (!file_exists($template))
			throw new FileNotFoundException("File {$template} has not been found");
		$this->fileTemplate = realpath($template);

		return $this;
	}

	/**
	 * @return Paginator|\Nette\Utils\Paginator
	 */
	public function getPaginator()
	{
		if (!$this->paginator) {
			$this->paginator = new \Nette\Utils\Paginator();
		}

		return $this->paginator;
	}

	/**
	 * Renders paginator.
	 *
	 * @return void
	 */
	public function render()
	{
		$paginator = $this->getPaginator();
		$page = $paginator->page;
		$steps = array();
		if ($paginator->pageCount < 2) {
			$steps = array($page);
		} else {
			if ($page - 2 > 0) {
				$steps[] = 1;
				$steps[] = '...';
			}
			for ($i = ($page - 1 > 0) ? $page - 1 : 1; $i <= $page + 1; $i++) {
				$steps[] = $i;
			}
			$steps[] = '...';
			$steps[] = $paginator->getLastPage();
		}
		$this->template->steps = $steps;
		$this->template->paginator = $paginator;
		$this->template->setFile($this->fileTemplate ? : __DIR__ . '/template.latte');
		$this->template->render();
	}

	/**
	 * Loads state informations.
	 *
	 * @param  array
	 * @return void
	 */
	public function loadState(array $params)
	{
		parent::loadState($params);
		$this->getPaginator()->page = $this->page;
	}
}