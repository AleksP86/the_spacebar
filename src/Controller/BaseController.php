<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;

/**
* @method User|null getUser()
*/
abstract class BaseController extends AbstractController
{
    protected function getUser(): User
    {
    	return parent::getUser();
    }
}
