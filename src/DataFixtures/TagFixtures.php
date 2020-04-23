<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Tag;

class TagFixtures extends Fixture
{
    public const FIRST_TAG_REFERENCE = 'first-tag';
    public const SECOND_TAG_REFERENCE = 'second-tag';
    public const THIRD_TAG_REFERENCE = 'third-tag';
    public const FOURTH_TAG_REFERENCE = 'fourth-tag';

    public function load(ObjectManager $manager)
    {
        $tag = new Tag();
        $tag->setName("First tag");
        $this->addReference(self::FIRST_TAG_REFERENCE, $tag);

        $manager->persist($tag);


        $tag = new Tag();
        $tag->setName("Second tag");
        $this->addReference(self::SECOND_TAG_REFERENCE, $tag);

        $manager->persist($tag);


        $tag = new Tag();
        $tag->setName("Third tag");
        $this->addReference(self::THIRD_TAG_REFERENCE, $tag);

        $manager->persist($tag);


        $tag = new Tag();
        $tag->setName("Fourth with longer tag name");
        $this->addReference(self::FOURTH_TAG_REFERENCE, $tag);

        $manager->persist($tag);


        $manager->flush();
    }
}
