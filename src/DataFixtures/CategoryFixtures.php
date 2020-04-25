<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Category;

class CategoryFixtures extends Fixture
{
    public const FIRST_CATEGORY_REFERENCE = 'first-category';
    public const SECOND_CATEGORY_REFERENCE = 'second-category';
    public const THIRD_CATEGORY_REFERENCE = 'third-category';

    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setName("First category");
        $this->addReference(self::FIRST_CATEGORY_REFERENCE, $category);

        $manager->persist($category);


        $category = new Category();
        $category->setName("Second category");
        $this->addReference(self::SECOND_CATEGORY_REFERENCE, $category);

        $manager->persist($category);


        $category = new Category();
        $category->setName("Third category");
        $this->addReference(self::THIRD_CATEGORY_REFERENCE, $category);

        $manager->persist($category);

        $manager->flush();
    }
}
