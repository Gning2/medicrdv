<?php
namespace App\Entity;

class PropertySearch{
    /**
     * @var string|null
     */
    private $service;
    


    /**
     * Get the value of service
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set the value of service
     */
    public function setService($service): self
    {
        $this->service = $service;

        return $this;
    }
}