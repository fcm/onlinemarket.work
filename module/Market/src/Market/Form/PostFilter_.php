<?php
namespace Market\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator\Regex;


class PostFilter extends InputFilter
{
	private $categories;
	

	public function  buildFilter()
	{
		$category = new Input('category');
		$category->getFilterChain()
		         ->attachByName('StringTrim')
		         ->attachByName('StripTags')
		         ->attachByName('StringToLower');

		$category->getValidatorChain()
				 ->attachByName('InArray', array('haystack' => $this->categories) ); 

		$title = new Input('title');
		$title->getFilterChain()
		         ->attachByName('StringTrim')
		         ->attachByName('StripTags');
		         
		$titleRegex = new Regex(array('pattern'=>'/^[a-zA-Z0-9 ]*$/'));
		$titleRegex->setMessage('Title should only contain numbers, letters or spaces!');

		$title->getValidatorChain()
			  ->attach($titleRegex)
			  ->attachByName('StringLength', array('min'=>1, 'max'=>128));

		$this->add($category)
		     ->add($title);   

	}


	public function getCategories()
	{
		return $this->categories;
	}

	public function setCategories($categories)
	{
		$this->categories = $categories;
	}	
}