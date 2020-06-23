<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Skeleton\DataFixtures;

use KejawenLab\Semart\Skeleton\Entity\Province;

/**
 * @author Muhammad Rifqi <muhammadrifqi.tb@gmail.com>
 */
class ProvinceFixture extends Fixture
{
    protected function createNew()
    {
        return new Province();
    }

    protected function getReferenceKey(): string
    {
        return 'province';
    }
}
