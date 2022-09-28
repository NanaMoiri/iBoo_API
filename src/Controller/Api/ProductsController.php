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


class ProductsController extends AbstractFOSRestController {
    
    //ACCES TO COMPLETE CATALOG
    /**
     * @Rest\Get(path="/catalog")
     */

    public function getCatalogAction (ProductRepository $productRepository){
        $products = $productRepository->findAll();
        $products_Array = [];
        foreach($products as $product){
            $products_Array[] = [
                'id' => $product->getId(),
                'type' => $product->getType(),
                'name' => $product-> getName(),
                'description' => $product-> getDescription(),
                'image' => $product -> getImage(),
                'weight' => $product-> getWeight(),
                'enable' => $product-> isEnabled()
            ];
        }
        return $this->render('CRUD_templates/show_all_products.html.twig', ['products_Array' => $products_Array]);
     }


     //-----------------PRODUCT CRUD-------------------------------

         //ACCES TO A PRODUCT BY ID
    /**
     * @Rest\Get(path="/catalog/product/{uuid}")
     * @Rest\View(serializerGroups={"product"}, serializerEnableMaxDepthChecks=true)
     */

    public function getProductUuId (
        string $uuid,
        ProductRepository $productRepository,
    ){
        $product =  $productRepository->find($uuid);
        return $this->render('CRUD_templates/search_by_uuid.html.twig',['product' => $product]);
        }

        //ADD A PRODUCT TO DB
    /**
     * @Rest\Post("/catalog/product/new")
     * @Rest\View(serializerGroups={"product"}, serializerEnableMaxDepthChecks=true)
     */

    public function addProduct (
        EntityManagerInterface $em, 
        Request $request,
        FileUploader $fileUploader
    ) {
        var_dump($request);
        // $productDto = new ProductDto();
        // $form = $this->createForm(ProductFormType:: class, $productDto);
        // $form->handleRequest($request);

        // if($form->isSubmitted() && $form->isValid())
        // {
        //     //Create the entity producto
        //     $product = new Product();
        //     if($productDto->base64Image){
        //          //Upload the image to local Storage
        //         $filename = $fileUploader->uploadBase64File($productDto->base64Image);
        //         $product -> setImage($filename);
        //     }
        //     $product -> setType($productDto-> type);
        //     $product -> setName($productDto-> name);
        //     $product -> setDescription($productDto-> description);
        //     $product -> setWeight($productDto-> weight);
        //     $product -> setEnabled($productDto-> enabled);
        //     //Saving the Product in DB
        //     $em->persist($product);
        //     $em->flush();
        //     return $product;
        // }
        // return $form;
     }

        //EDIT A PRODUCT
        /**
     * @Rest\Put("/catalog/product/edit/{uuid}")
     * @Rest\View(serializerGroups={"product"}, serializerEnableMaxDepthChecks=true)
     */

    public function editProduct(
        string $uuid,
        EntityManagerInterface $em,
        ProductRepository $productRepository,
        Request $request,
        FileUploader $fileUploader
    ) {
        $product = $productRepository->find($uuid);
        if(!$product){
            throw $this->createNotFoundException('Book not found');
        }

        $content = json_decode($request-> getContent(), true);
        $productDto = ProductDto::createFromProduct($product);
        $form = $this->createForm(ProductFormType::class, $productDto);
        $form->submit($content);

        if($form->isSubmitted()&& $form->isValid()){
            if($productDto->base64Image){
                //Upload the image to local Storage
               $filename = $fileUploader->uploadBase64File($productDto->base64Image);
               $product -> setImage($filename);
            }
            $product -> setType($productDto-> type);
            $product -> setName($productDto-> name);
            $product -> setDescription($productDto-> description);
            $product -> setWeight($productDto-> weight);
            $product -> setEnabled($productDto-> enabled);
            //Saving the Product in DB
            $em->persist($product);
            $em->flush();
            return $product;
        }
        return $form;
    }

    //DELETE A PRODUCT FROM DB
        /**
     * @Rest\Delete(path="/catalog/product/delete/{uuid}")
     * @Rest\View(serializerGroups={"product"}, serializerEnableMaxDepthChecks=true)
     */

    public function deleteProduct(
        string $uuid,
        EntityManagerInterface $em,
        ProductRepository $productRepository,
        FileDeleter $fileDeleter
    ){
        $product = $productRepository->find($uuid);
        $image = $product->getImage();
        if ($image !== null) {
            ($fileDeleter)($image);
        }
        $em->remove($product);
        $em->flush();
    }

    /**
     * @Rest\Get(path="/catalog/product/search")
     * @Rest\View(serializerGroups={"product"}, serializerEnableMaxDepthChecks=true)
     */
    public function searchProductByFreeText(
        ProductRepository $productRepository,
        Request $request
    ){
        $searchText = $request->get('searchText');
        $criteria = new ProductRepositorySearch($searchText);
        return $productRepository->findByCriteria($criteria);
    }

}

