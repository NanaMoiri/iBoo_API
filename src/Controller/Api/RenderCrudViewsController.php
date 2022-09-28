<?php

namespace App\Controller\Api;

use App\Entity\Product;
use App\Form\Model\ProductDto;
use App\Form\Type\ProductFormType;
use App\Model\ProductRepositorySearch;
use App\Repository\ProductRepository;
use App\Service\FileDeleter;
use App\Service\FileUploader;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;

class RenderCrudViewsController extends AbstractFOSRestController {

    //RENDER ADD PRODUCT VIEW
    /**
     * @Rest\Get(path="/product/add")
     */
    public function renderAdd () {
        return $this->render('CRUD_templates/add_product.html.twig');
    }
}