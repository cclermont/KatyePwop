<?php

namespace App\Twig;

use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;
use Symfony\Component\Security\Core\Security;

use App\Service\Institution\InstitutionManager;

class AppExtension extends AbstractExtension
{
    
    private $security;
    private $institutionManager;

    public function __construct(Security $security, InstitutionManager $institutionManager)
    {
        $this->security = $security;
        $this->institutionManager = $institutionManager;
    }

	public function getFunctions()
    {
        return [
            new TwigFunction('brandingColor', [$this, 'getBrandingColor']),
            new TwigFunction('currentInstitutionBrand', [$this, 'getCurrentInstitutionBrand']),
        ];
    }

    public function getBrandingColor()
    {
        $institution = $this->institutionManager->findByUser($this->security->getUser());
        return $institution ? $institution->getBrandingColor() : null;
    }

    public function getCurrentInstitutionBrand()
    {
        $institution = $this->institutionManager->findByUser($this->security->getUser());
        return $institution ? $institution->getImage() : null;
    }
}