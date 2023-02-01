<?php

namespace App\Twig;

use App\Entity\Open;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Doctrine\ORM\EntityManagerInterface;


// Créer une extension pour mettre à disposition une varibale globale 'openTime' de l'horaire d'ouverture qui sera accesssible dans tous les pieds de page 

class OpenTimeExtension extends AbstractExtension
{
    
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('openTime', [$this, 'getOpenTimes'])
        ];
    }

    
    public function getOpenTimes()
    {
        return $this->em->getRepository(Open::class)->findAll();
    }
}
