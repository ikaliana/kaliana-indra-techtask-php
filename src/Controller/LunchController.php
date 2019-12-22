<?php
// src/Controller/LunchController.php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Service\Menu;
use App\Model\Recipe;

class LunchController extends AbstractController
{
	/**
     * @Route("/lunch/{todayDate}")
     */
    public function index($todayDate="2019-03-10", Menu $menu)
    {
        $todayMenu = $menu->getTodayMenu($todayDate);

        return $this->json($todayMenu);
    }
}
