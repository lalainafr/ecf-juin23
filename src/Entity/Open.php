<?php

namespace App\Entity;

use App\Repository\OpenRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OpenRepository::class)]
class Open
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $day = null;

    #[ORM\Column(length: 255)]
    private ?string $am_start = null;

    #[ORM\Column(length: 255)]
    private ?string $am_close = null;

    #[ORM\Column(length: 255)]
    private ?string $pm_start = null;

    #[ORM\Column(length: 255)]
    private ?string $pm_close = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

    public function getAmStart(): ?string
    {
        return $this->am_start;
    }

    public function setAmStart(string $am_start): self
    {
        $this->am_start = $am_start;

        return $this;
    }

    public function getAmClose(): ?string
    {
        return $this->am_close;
    }

    public function setAmClose(string $am_close): self
    {
        $this->am_close = $am_close;

        return $this;
    }

    public function getPmStart(): ?string
    {
        return $this->pm_start;
    }

    public function setPmStart(string $pm_start): self
    {
        $this->pm_start = $pm_start;

        return $this;
    }

    public function getPmClose(): ?string
    {
        return $this->pm_close;
    }

    public function setPmClose(string $pm_close): self
    {
        $this->pm_close = $pm_close;

        return $this;
    }
}
