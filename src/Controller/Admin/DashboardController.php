<?php

namespace App\Controller\Admin;

use App\Entity\Carrier;
use App\Entity\Category;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Ma boutique');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Orders', 'fas fa-shopping-cart', Order::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Category::class);
        yield MenuItem::linkToCrud('Produits', 'fas fa-shopping-bag', Product::class);
        yield MenuItem::linkToCrud('Carrier', 'fas fa-truck', Carrier::class);
    }
}
