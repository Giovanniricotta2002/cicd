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
        dump($errors);
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

    public function testInvalidBlankNumber()
    {
        $this->assertHasErrors($this->getEntity()->setNumberA(4));
    }

    public function testInvalidUsedCode ()
    {
        $this->assertHasErrors($this->getEntity()->setNumberB(4));
    }
}