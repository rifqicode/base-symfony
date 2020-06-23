<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Skeleton\Service;

use KejawenLab\Semart\Skeleton\Contract\Service\ServiceInterface;
use KejawenLab\Semart\Skeleton\Repository\ProvinceRepository;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author Muhammad Rifqi <muhammadrifqi.tb@gmail.com>
 */
class IndonesiaService
{
    private $provinceRepository;

    public function __construct(
        ProvinceRepository $provinceRepository
    ) {
        $provinceRepository->setCacheable(true);
        $this->provinceRepository = $provinceRepository;
    }

    public function getProvinces($id = null)
    {
        return $this->provinceRepository->findAll();
    }
}
