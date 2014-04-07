<?php
/**
 * This file is part of the Kappa package.
 *
 * (c) Ondřej Záruba <zarubaondra@gmail.com>
 *
 * For the full copyright and license information, please view the license.md
 * file that was distributed with this source code.
 *
 * @testCase
 */
namespace Kappa\Tests\Packages\VisualPaginator;

use Kappa\Tester\TestCase;
use Kappa\Packages\VisualPaginator;
use Tester\Assert;

require_once __DIR__ . '/../../bootstrap.php';

class PaginatorTest extends TestCase
{
	/** @var \Kappa\Packages\VisualPaginator\Paginator */
	private $paginator;

	protected function setUp()
	{
		$this->paginator = new VisualPaginator\Paginator();
		Assert::true($this->paginator instanceof VisualPaginator\Paginator);
	}

	public function testSetTemplate()
	{
		Assert::true($this->paginator->setTemplate(__DIR__ . '/../../../data/files/template.latte') instanceof VisualPaginator\Paginator);
		Assert::same(realpath(__DIR__ . '/../../../data/files/template.latte'), $this->getReflection()->invokeProperty($this->paginator, 'fileTemplate'));
		Assert::throws(function () {
			$this->paginator->setTemplate('no-exist-template.latte');
		}, '\Kappa\FileNotFoundException');
	}

	public function testGetPaginator()
	{
		Assert::true($this->paginator->getPaginator() instanceof \Nette\Utils\Paginator);
		Assert::true($this->getReflection()->invokeProperty($this->paginator, 'paginator') instanceof \Nette\Utils\Paginator);
	}
}

\run(new PaginatorTest());