<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Company;
use App\Entity\Skill;
use App\Form\AddCategoryType;
use App\Form\AddCompanyType;
use App\Form\AddSkillType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManageItemsController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/manage/category", name="manageCategory")
     */
    public function showCategory(Request $request): Response
    {
        $category = new Category();
        $formNewCat = $this->createForm(AddCategoryType::class, $category);
        $formNewCat->handleRequest($request);

        if($formNewCat->isSubmitted() && $formNewCat->isValid())
        {
            $data = $formNewCat->getData();
            $this->entityManager->persist($data);
            $this->entityManager->flush();

            $this->addFlash('success', 'Catégorie "' . $data->getNom().'" créée !');
        }

        $categoryList = $this->entityManager->getRepository(Category::class)->findAll();

        return $this->render('manage/category.html.twig', [
            'categoryList' => $categoryList,
            'formNewCat' => $formNewCat->createView()
        ]);
    }

    /**
     * @Route("/manage/category/modification/{idUser}", name="modifCategory")
     */
    public function modifCategory(Request $request, $idUser): Response
    {
        $modifCat = $this->entityManager->getRepository(Category::class)->find($idUser);
        $modifCatForm= $this->createForm(AddCategoryType::class, $modifCat);
        $modifCatForm->handleRequest($request);

        if ($modifCatForm->isSubmitted() && $modifCatForm->isValid())
        {
            $this->entityManager->flush();
            $this->addFlash('info', 'Catégorie modifiée !');
            return $this->redirectToRoute('manageCategory');
        }

        return $this->render('manage/categoryModification.html.twig',[
            'modifCatForm'=>$modifCatForm->createView()
        ]);
    }

    /**
     * @Route("/manage/category/{idUser}", name="suppCategory")
     */
    public function suppCategory($idUser): Response
    {
        $suppCat = $this->entityManager->getRepository(Category::class)->find($idUser);
        $item = $this->getDoctrine()->getManager();
        $item->remove($suppCat);
        $item->flush();

        $this->addFlash('alert', 'Catégorie "' . $suppCat->getNom().'" supprimée !');

        return $this->redirectToRoute('manageCategory');
    }


    /**
     * @Route("/manage/company", name="manageCompany")
     */
    public function showCompany(Request $request): Response
    {
        $Company = new Company();
        $formNewComp = $this->createForm(AddCompanyType::class, $Company);
        $formNewComp->handleRequest($request);

        if($formNewComp->isSubmitted() && $formNewComp->isValid())
        {
            $data = $formNewComp->getData();
            $this->entityManager->persist($data);
            $this->entityManager->flush();
            $this->addFlash('success', 'Entreprise "' . $data->getNom().'" créée !');
        }

        $companyList = $this->entityManager->getRepository(Company::class)->findBy(
            [], ["nom" => "ASC"], null);

        return $this->render('manage/company.html.twig', [
            'companyList' => $companyList,
            'formNewComp' => $formNewComp->createView()
        ]);
    }

    /**
     * @Route("/manage/company/modification/{idUser}", name="modifCompany")
     */
    public function modifCompany(Request $request, $idUser): Response
    {
        $modifComp = $this->entityManager->getRepository(Company::class)->find($idUser);
        $modifCompForm= $this->createForm(AddCompanyType::class, $modifComp);
        $modifCompForm->handleRequest($request);

        if ($modifCompForm->isSubmitted() && $modifCompForm->isValid())
        {
            $this->entityManager->flush();
            $this->addFlash('info', 'Entreprise modifiée !');
            return $this->redirectToRoute('manageCompany');
        }

        return $this->render('manage/companyModification.html.twig',[
            'modifCompForm'=>$modifCompForm->createView()
        ]);
    }

    /**
     * @Route("/manage/company/{idUser}", name="suppCompany")
     */
    public function suppCompany($idUser): Response
    {
        $suppComp = $this->entityManager->getRepository(Company::class)->find($idUser);
        $item = $this->getDoctrine()->getManager();
        $item->remove($suppComp);
        $item->flush();

        $this->addFlash('alert', 'Entreprise "'. $suppComp->getNom().'" supprimée !');

        return $this->redirectToRoute('manageCompany');
    }


    /**
     * @Route("/manage/skill", name="manageSkill")
     */
    public function showSkill(Request $request): Response
    {
        $categoryList = $this->entityManager->getRepository(Category::class)->findAll();

        $Skill = new Skill();
        $formNewSkill = $this->createForm(AddSkillType::class, $Skill);
        $formNewSkill->handleRequest($request);

        if($formNewSkill->isSubmitted() && $formNewSkill->isValid())
        {
            $data = $formNewSkill->getData();
            $this->entityManager->persist($data);
            $this->entityManager->flush();
            $this->addFlash('succes', 'Compétence "' . $data->getNom().'" créée !');
        }

        $skillList = $this->entityManager->getRepository(Skill::class)->findAll();

        return $this->render('manage/skill.html.twig', [
            'categoryList'=>$categoryList,
            'skillList' => $skillList,
            'formNewSkill' => $formNewSkill->createView()
        ]);
    }

    /**
     * @Route("/manage/skill/modification/{idUser}", name="modifSkill")
     */
    public function modifSkill(Request $request, $idUser): Response
    {
        $modifSkill = $this->entityManager->getRepository(Skill::class)->find($idUser);
        $modifSkillForm= $this->createForm(AddSkillType::class, $modifSkill);
        $modifSkillForm->handleRequest($request);

        if ($modifSkillForm->isSubmitted() && $modifSkillForm->isValid())
        {
            $this->entityManager->flush();
            $this->addFlash('info', 'Compétence modifiée !');
            return $this->redirectToRoute('manageSkill');
        }

        return $this->render('manage/skillModification.html.twig',[
            'modifSkillForm'=>$modifSkillForm->createView()
        ]);
    }

    /**
     * @Route("/manage/skill/{idUser}", name="suppSkill")
     */
    public function suppSkill($idUser): Response
    {
        $suppSkill = $this->entityManager->getRepository(Skill::class)->find($idUser);
        $item = $this->getDoctrine()->getManager();
        $item->remove($suppSkill);
        $item->flush();
        $this->addFlash('alert', 'Compétence "' . $suppSkill->getNom().'" supprimée !');

        return $this->redirectToRoute('manageSkill');
    }

}
