<?php
namespace Market\Form;
use Zend\Form\ {Form,Element};
use Zend\Captcha\Image as ImageCaptcha;

class PostForm extends Form 
{

    protected $categories;
    protected $expiredDays;
    protected $captchaOptions;

    public function __construct($categories,$expiredDays,$captchaOptions) 
    {

        parent::__construct('post-form');

        $this->categories = $categories;
        $this->expiredDays = $expiredDays;
        $this->captchaOptions = $captchaOptions;

        $category = new Element\Select('category');
        $category->setLabel('Category')
                 ->setAttribute('title', 'Select a category')
                 ->setValueOptions(array_combine($this->categories, $this->categories))
                 ->setLabelAttributes(['style' => 'display: block']);

        $title = new Element\Text('title');
        $title->setLabel('Title')
              ->setAttribute('placeholder', 'Enter posting title')
              ->setLabelAttributes(['style'=>'display:block']);

        $photo = new Element\Text('photo_filename');
        $photo->setLabel('Photo File ')
            ->setAttribute('maxlength', 1024)
            ->setAttribute('placeholder', 'Enter image URL')
            ->setLabelAttributes(['style'=>'display:block']);

        $price = new Element\Text('price');
        $price->setLabel('Price ')
            ->setAttribute('title', 'Enter price as nnn.nn')
            ->setAttribute('size', 16)
            ->setAttribute('maxlength', 16)
            ->setAttribute('placeholder', 'Enter a value')
            ->setLabelAttributes(['style'=>'display:block']);

        $expires = new Element\Radio('expires');
        $expires->setLabel('Expires')
            ->setAttribute('title', 'The expiration date will be calculated from today')
            ->setAttribute('class', 'expiresButton')
            ->setValueOptions($this->expiredDays);

        $city = new Element\Text('cityCode');
        $city->setLabel('City / Country')
            ->setAttribute('title', 'Enter as "city,country" using 2 letter ISO code for country')
            ->setAttribute('id', 'cityCode')
            ->setAttribute('placeholder', 'City Name,CC')
            ->setLabelAttributes(['style'=>'display:inline;font-size:14pt;font-weight:normal;margin-right: 20px;']);

        $name = new Element\Text('contact_name');
        $name->setLabel('Contact Name ')
            ->setAttribute('title', 'Enter the name of the person to contact for this item')
            ->setAttribute('size', 40)
            ->setAttribute('maxlength', 255)
            ->setLabelAttributes(['style'=>'display:block']);

        $phone = new Element\Text('contact_phone');
        $phone->setLabel('Contact Phone Number ')
            ->setAttribute('title', 'Enter the phone number of the person to contact for this item')
            ->setAttribute('size', 20)
            ->setAttribute('maxlength', 32)
            ->setLabelAttributes(['style'=>'display:block']);

        $email = new Element\Email('contact_email');
        $email->setLabel('Contact Email ')
            ->setAttribute('title', 'Enter the email address of the person to contact for this item')
            ->setAttribute('size', 40)
            ->setAttribute('maxlength', 255)
            ->setLabelAttributes(['style'=>'display:block']);

        $description = new Element\Textarea('description');
        $description->setLabel('Description')
            ->setAttribute('title', 'Enter a suitable description for this posting')
            ->setAttribute('rows', 4)
            ->setAttribute('cols', 80);

        $delCode = new Element\Text('delete_code');
        $delCode->setLabel('Delete Code ')
            ->setAttribute('title', 'Enter the delete code for this item')
            ->setAttribute('size', 16)
            ->setAttribute('maxlength', 16)
            ->setLabelAttributes(['style'=>'display:block']);

        $captcha = new Element\Captcha('captcha');
        $captchaAdapter = new ImageCaptcha();
        $captchaAdapter->setWordlen(4)
            ->setOptions($this->captchaOptions);
        $captcha->setCaptcha($captchaAdapter)
            ->setLabel('Help us to prevent SPAM!')
            ->setAttribute('title', 'Help to prevent SPAM');

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Post')
               ->setAttribute('style', 'font-size: 16pt; font-weight:bold;')
               ->setAttribute('class', 'btn btn-success white');

        $this->add($category)
            ->add($title)
            ->add($photo)
            ->add($price)
            ->add($expires)
            ->add($city)
            ->add($name)
            ->add($phone)
            ->add($email)
            ->add($description)
            ->add($delCode)
            ->add($captcha)
            ->add($submit);
    }
}
