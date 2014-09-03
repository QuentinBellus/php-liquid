<?php

/**
 * This file is part of the Liquid package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package Liquid
 */

namespace Liquid;

class BlockTest extends TestCase
{
	function test_blackspace()
	{
		$template = new Template;
		$template->parse('  ');
		
		$nodelist = $template->getRoot()->getNodelist();
		
		$this->assertEqual(array('  '), $nodelist);
	}
	
	function test_variable_beginning()
	{
		$template = new Template;
		$template->parse('{{funk}}  ');
		
		$nodelist = $template->getRoot()->getNodelist();
		
		$this->assertEqual(2, count($nodelist));
		$this->assertIsA($nodelist[0], 'Variable');
		$this->assertIsA($nodelist[1], 'string');
	}

	function test_variable_end()
	{
		$template = new Template;
		$template->parse('  {{funk}}');
		
		$nodelist = $template->getRoot()->getNodelist();
		
		$this->assertEqual(2, count($nodelist));
		$this->assertIsA($nodelist[0], 'string');
		$this->assertIsA($nodelist[1], 'Variable');
	}

	function test_variable_middle()
	{
		$template = new Template;
		$template->parse('  {{funk}}  ');
		
		$nodelist = $template->getRoot()->getNodelist();
		
		$this->assertEqual(3, count($nodelist));
		$this->assertIsA($nodelist[0], 'string');		
		$this->assertIsA($nodelist[1], 'Variable');
		$this->assertIsA($nodelist[2], 'string');
	}	

	function test_variable_many_embedded_fragments()
	{
		$template  = new Template;
		$template->parse('  {{funk}}  {{soul}}  {{brother}} ');
		
		$nodelist = $template->getRoot()->getNodelist();
		
		$this->assertEqual(7, count($nodelist));
		$this->assertIsA($nodelist[0], 'string');		
		$this->assertIsA($nodelist[1], 'Variable');
		$this->assertIsA($nodelist[2], 'string');
		$this->assertIsA($nodelist[3], 'Variable');
		$this->assertIsA($nodelist[4], 'string');
		$this->assertIsA($nodelist[5], 'Variable');
		$this->assertIsA($nodelist[6], 'string');		
	}

	function test_with_block()
	{
		$template = new Template;
		$template->parse('  {% comment %}  {% endcomment %} ');		
		
		$nodelist = $template->getRoot()->getNodelist();
		
		$this->assertEqual(3, count($nodelist));
		$this->assertIsA($nodelist[0], 'string');		
		$this->assertIsA($nodelist[1], 'LiquidTagComment');
		$this->assertIsA($nodelist[2], 'string');	
	}
}
