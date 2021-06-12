<?php

namespace App\Controller;

use App\Entity\LienUserSkill;
use App\Entity\SearchByName;
use App\Entity\SearchBySkill;
use App\Entity\SearchBySkillLevel;
use App\Entity\Skill;
use App\Entity\User;
use App\Form\SearchByNameType;
use App\Form\SearchBySkillLevelType;
use App\Form\SearchBySkillType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/search/home", name="searchHome")
     */
    public function searchHome(Request $request)
    {
        return $this->render('search/index.html.twig');
    }

    /**
     * @Route("/search/byName", name="searchByName")
     */
    public function searchByName(Request $request)
    {
        $searchByName = new SearchByName();
        $form= $this->createForm(SearchByNameType::class, $searchByName);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $nameSearched= $form->getData();
            $users = $this->entityManager->getRepository(User::class)->findAll();

            return $this->render('search/byName.html.twig', [
                'nameSearched' => $nameSearched,
                'listUser' => $users
            ]);
        }

        return $this->render('search/byName.html.twig', [
            'formSearchByName' => $form->createView(),
        ]);
    }

    /**
     * @Route("/search/bySkill", name="searchBySkill")
     */
    public function searchBySkill(Request $request)
    {
        $searchBySkill = new SearchBySkill();
        $form= $this->createForm(SearchBySkillType::class, $searchBySkill);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $skillSearched= $form->getData();
            $LienUserSkill = $this->entityManager->getRepository(LienUserSkill::class)->findAll();
            $users = $this->entityManager->getRepository(User::class)->findAll();

            return $this->render('search/bySkill.html.twig', [
                'skillSearched' => $skillSearched,
                'LienUserSkill' => $LienUserSkill,
                'listUser' => $users
            ]);
        }

        return $this->render('search/bySkill.html.twig', [
            'formSearchByKill' => $form->createView(),
        ]);
    }


    /**
     * @Route("/search/bySkillLevel", name="searchBySkillLevel")
     */
    public function searchBySkillLevel(Request $request)
    {
        $searchBySkillLevel =new SearchBySkillLevel();
        $form= $this->createForm(SearchBySkillLevelType::class, $searchBySkillLevel);
        $form->handleRequest($request);

        if($form ->isSubmitted() && $form->isValid())
        {
            $skillLevelSearched=$form->getData();
            $LienUserSkill = $this->entityManager->getRepository(LienUserSkill::class)->findAll();
            $users = $this->entityManager->getRepository(User::class)->findAll();

            return $this->render('search/bySkillLevel.html.twig', [
                'skillLevelSearched' => $skillLevelSearched,
                'LienUserSkill'=>$LienUserSkill,
                'listUser' => $users
            ]);
        }

        return $this->render('search/bySkilllevel.html.twig', [
            'formSearchBySkillLevel'=> $form->createView(),
        ]);
    }

    /**
     * @Route("/search/byPrefer", name="searchByPrefer")
     */
    public function searchByPrefer(Request $request)
    {
        $searchBySkill = new SearchBySkill();
        $form= $this->createForm(SearchBySkillType::class, $searchBySkill);
        $form->handleRequest($request);

        if($form ->isSubmitted() && $form->isValid())
        {
            $skillSearched=$form->getData();
            $LienUserSkill = $this->entityManager->getRepository(LienUserSkill::class)->findAll();
            $users = $this->entityManager->getRepository(User::class)->findAll();

            return $this->render('search/byPrefer.html.twig', [
                'skillSearched' => $skillSearched,
                'LienUserSkill'=>$LienUserSkill,
                'listUser' => $users
            ]);
        }

        return $this->render('search/byPrefer.html.twig', [
            'formSearchByPrefer'=> $form->createView(),
        ]);
    }

    /**
     * @Route("/search/all-collaborateurs", name="allCollaborateursList")
     */
    public function allCollaborateursList(Request $request)
    {
        $allCollaborateurs = $this->entityManager->getRepository(User::class)->findBy(
            ['profil'=> 2], ["nom" => "ASC"], null);

            return $this->render('search/allCollaborateursList.html.twig', [
                'allCollaborateurs' => $allCollaborateurs
            ]);
    }

    /**
     * @Route("/search/all-candidate", name="allCandidateList")
     */
    public function allCandidateList(Request $request)
    {
        $allCandidate = $this->entityManager->getRepository(User::class)->findBy(
            ['profil'=> 1], ["nom" => "ASC"], null);

        return $this->render('search/allCandidateList.html.twig', [
            'allCandidate' => $allCandidate
        ]);
    }





}
