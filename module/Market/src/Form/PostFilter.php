<?php
namespace Market\Form;

use Zend\InputFilter\ {InputFilter,Input};
use Zend\Filter\ {Digits, StripTags, StringTrim, StringToLower, StringToUpper, Callback, };
use Zend\Validator\ {InArray, StringLength, Regex, Callback as CallValid};
use Zend\I18n\Validator\Alnum;

class PostFilter extends InputFilter 
{

    protected $categories;
    protected $expireDays;

    public function __construct(array $categories, array $expireDays) 
    {
        $this->categories = $categories;
        $this->expireDays = $expireDays;

        $category = new Input('category');
        $category->getFilterChain()
                 ->attachByName('StringToLower');
        $category->getValidatorChain()
                 ->attachByName('InArray', array('haystack' => $this->categories));

        $title = new Input('title');
        $titleRegex = new Regex(array('pattern' => '/^[a-zA-Z0-9 ]*$/'));
        $titleRegex->setMessage('Title should only contain numbers, letters or spaces!');
        $title->getValidatorChain()
              ->attach($titleRegex)
              ->attachByName('StringLength', array('min' => 1, 'max' => 128));

        $photo = new Input('photo_filename');
        $photo->getValidatorChain()
              ->attachByName('Regex', array('pattern' => '!^(http(s)?://)?[a-z0-9./_-]+(jp(e)?g|png)$!i'));
        $photo->setErrorMessage('Photo must be a URL or a valid filename ending with jpg or png');

        $float = new Callback(function ($val) { return (float) $val; });
        $price = new Input('price');
        $price->setAllowEmpty(TRUE);
        $price->getValidatorChain()
              ->attachByName('GreaterThan', array('min' => 0.00));
        $price->getFilterChain()
              ->attach($float);

        $expires = new Input('expires');
        $expires->setAllowEmpty(TRUE);
        $expires->getValidatorChain()
                ->attachByName('InArray', array('haystack' => array_keys($this->expireDays)));
        $expires->getFilterChain()
                ->attach(new Digits());

        // validates "city" field
        $cityCheck = new CallValid(function ($val) {
            [$city, $country] = explode(',', $val);
            if ($city === NULL || $country === NULL) return FALSE;
            if (strlen($country) != 2) return FALSE;
            if ($country !== strtoupper($country)) return FALSE;
            return TRUE;
        });
        $cityCheck->setMessage('What you entered did take this form: NNNN,CC where NNNN = the city name, and CC = 2 digit ISO country code');
        $cityCode = new Input('cityCode');
        $cityCode->getValidatorChain()
                 ->attach($cityCheck);

        $name = new Input('contact_name');
        $name->setAllowEmpty(TRUE);
        $name->getValidatorChain()
              ->attachByName('Regex', array('pattern' => '/^[a-z0-9., -]{1,255}$/i'));
        $name->setErrorMessage('Name should only contain letters, numbers, and some punctuation.');

        $phone = new Input('contact_phone');
        $phone->setAllowEmpty(TRUE);
        $phone->getValidatorChain()
              ->attachByName('Regex', array('pattern' => '/^\+?\d{1,4}(-\d{3,4})+$/'));
        $phone->setErrorMessage('Phone number must be in this format: +nnnn-nnn-nnn-nnnn');

        $email = new Input('contact_email');
        $email->setAllowEmpty(TRUE);
        $email->getValidatorChain()
              ->attachByName('EmailAddress');

        $description = new Input('description');
        $description->setAllowEmpty(TRUE);
        $description->getValidatorChain()
                    ->attachByName('StringLength', array('min' => 1, 'max' => 4096));

        $delCode = new Input('delete_code');
        $delCode->setRequired(TRUE);
        $delCode->getValidatorChain()
                ->addByName('Digits');

        $this->add($category)
             ->add($title)
             ->add($photo)
             ->add($price)
             ->add($expires)
             ->add($cityCode)
             ->add($name)
             ->add($phone)
             ->add($email)
             ->add($description)
             ->add($delCode);

        // add StripTags + StringTrim to all
        $stripTags = new StripTags();
        $stringTrim = new StringTrim();
        foreach ($this->getInputs() as $input) {
            $input->getFilterChain()
                  ->attach($stripTags)
                  ->attach($stringTrim);
        }
    }
}
