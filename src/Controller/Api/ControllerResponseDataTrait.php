<?php

namespace App\Controller\Api;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * ControllerResponseDataTrait
 */ 
trait ControllerResponseDataTrait
{
    /**
    * Get response data
    */
    protected function getResponseData(){

        return new ArrayCollection(array(
            'data' => [],
            'total' => 0, 
            'error' => false,
            'version' => 1.0,
        ));
    }
}