<?php
namespace Mipa\ImageBundle\DataFixtures\ORM;
 
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Mipa\ImageBundle\Entity\Images;
 
class LoadImages extends AbstractFixture implements OrderedFixtureInterface
{
  public function load(ObjectManager $em)
  {
    $image1->setTitle('Red flower');
    $image1->setName('tulip');
    $image1->setImage('img');
 
 
    $em->persist($image1);
 
    $em->flush();
  }
 
  public function getOrder()
  {
    return 1; // the order in which fixtures will be loaded
  }
}

?>