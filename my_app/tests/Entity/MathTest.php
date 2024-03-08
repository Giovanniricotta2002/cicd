<?php
namespace App\Tests\Entity;

use App\Entity\Math;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

class MathTest extends KernelTestCase
{
    private $validator;

    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        self::bootKernel(); 
        $container = static::getContainer(); 
        $this->validator = $container->get('validator'); 
    }
    
    public function getEntity(): Math
    {
        return (new Math())
            ->setNumberA(3)
            ->setNumberB(5);
    }

    public function assertHasErrors(Math $math, int $number = 0)
    {
        self::bootKernel();
        $errors = $this->validator->validate($math);
        $messages = [];
        /** @var ConstraintViolation $error */
        foreach($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }
        $this->assertCount($number, $errors, implode(', ', $messages));
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidMathEntity()
    {
        $this->assertHasErrors($this->getEntity()->setNumberA(1), 1);
        $this->assertHasErrors($this->getEntity()->setNumberB(1), 1);
    }

    public function testInvalidBlankNumber()
    {
        $this->assertHasErrors($this->getEntity()->setNumberA(''), 1);
    }

    public function testInvalidUsedCode ()
    {
        $this->assertHasErrors($this->getEntity()->setNumberB(4), 1);
    }
}