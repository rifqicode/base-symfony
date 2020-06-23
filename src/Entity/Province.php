<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Skeleton\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\SoftDeleteable\Traits\SoftDeleteableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use KejawenLab\Semart\Skeleton\Contract\Entity\PrimaryableTrait;
use KejawenLab\Semart\Skeleton\Query\Searchable;
use KejawenLab\Semart\Skeleton\Query\Sortable;
use PHLAK\Twine\Str;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="ref_provinsi", indexes={@ORM\Index(name="ref_provinsi_search_idx", columns={"kode"})})
 * @ORM\Entity(repositoryClass="KejawenLab\Semart\Skeleton\Repository\ProvinceRepository")
 *
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 *
 * @Searchable({"kode", "nama"})
 * @Sortable({"kode", "nama"})
 *
 * @UniqueEntity(fields={"kode"})
 *
 * @author Muhammad Rifqi <muhammadrifqi.tb@gmail.com>
 */
class Province
{
    use BlameableEntity;
    use PrimaryableTrait;
    use SoftDeleteableEntity;
    use TimestampableEntity;

    /**
     * @ORM\Column(name="kode", type="string", length=27)
     *
     * @Assert\Length(max=27)
     * @Assert\NotBlank()
     *
     * @Groups({"read"})
     */
    private $code;

    /**
     * @ORM\Column(name="nama", type="string", length=255)
     *
     * @Assert\Length(max=255)
     * @Assert\NotBlank()
     *
     * @Groups({"read"})
     */
    private $name;

    /**
     * @ORM\Column(name="polygon", type="text" , nullable=true)
     *
     * @Assert\NotBlank()
     *
     * @Groups({"read"})
     */
    private $polygon;

    /**
     * Get the value of Code
     *
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of Code
     *
     * @param mixed $code
     *
     * @return self
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of Name
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param mixed $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of Polygon
     *
     * @return mixed
     */
    public function getPolygon()
    {
        return $this->polygon;
    }

    /**
     * Set the value of Polygon
     *
     * @param mixed $polygon
     *
     * @return self
     */
    public function setPolygon($polygon)
    {
        $this->polygon = $polygon;

        return $this;
    }

}
