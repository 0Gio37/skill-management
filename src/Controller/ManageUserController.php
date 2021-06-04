<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AddUserType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ManageUserController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/manage/user/candidate", name="manageCandidate")
     */
    public function showCandidate(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $candidate = new User();
        $formNewCandidate = $this->createForm(AddUserType::class, $candidate, ['role'=>$this->getUser()->getRoles()]);
        $formNewCandidate->handleRequest($request);

        if($formNewCandidate->isSubmitted() && $formNewCandidate->isValid())
        {
            $data = $formNewCandidate->getData();
            $candidate->setPassword($passwordEncoder->encodePassword($candidate, $candidate->getPassword()));
            $this->entityManager->persist($data);
            $this->entityManager->flush();

            $this->addFlash('creation', 'Le candidat "' . $data->getNom().' '. $data->getPrenom(). '" a bien été créé !');
        }

        $candidateList= $this->entityManager->getRepository(User::class)->findAll();

        return $this->render('manage/candidate.html.twig',[
            'candidateList'=>$candidateList,
            'formNewCandidate'=>$formNewCandidate->createView()
        ]);
    }

    /**
     * @Route("user/manage/candidat/modification/{idUser}/{idProfil}", name="modifCandidate")
     */
    public function modifCandidate(Request $request, int $idUser, $idProfil, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $modifCandidate = $this->entityManager->getRepository(User::class)->find($idUser);
        $modifCandidateForm = $this->createForm(AddUserType::class, $modifCandidate, ['role'=>$this->getUser()->getRoles()]);
        $modifCandidateForm->handleRequest($request);

        if ($modifCandidateForm->isSubmitted() && $modifCandidateForm->isValid())
        {
            $modifCandidate->setPassword($passwordEncoder->encodePassword($modifCandidate, $modifCandidate->getPassword()));
            $this->entityManager->flush();
            $this->addFlash('modification', 'Le candidat a bien été modifié !');
            if($modifCandidate->getRoles() === "ROLE_ADMIN" ){
                return $this->redirectToRoute('manageCandidate');
            } else{
                return $this->redirectToRoute('singleProfil', ['idUser'=>$idUser, 'idProfil'=>$idProfil]);
            }
        }

        return $this->render('manage/candidateModification.html.twig',[
            'modifCandidateForm'=>$modifCandidateForm->createView(),
            'currentId'=>$idUser,
            'currentIdProfil'=>$idProfil,
            'idUser'=>$idUser
        ]);
    }

    /**
     * @Route("/manage/candidate/{idUser}", name="suppCandidate")
     */
    public function suppCandidate($idUser): Response
    {
        $suppCandidate = $this->entityManager->getRepository(User::class)->find($idUser);
        $item = $this->getDoctrine()->getManager();
        $item->remove($suppCandidate);
        $item->flush();
        $this->addFlash('suppression', 'Le candidat "' . $suppCandidate->getNom().' '.$suppCandidate->getPrenom().'" a bien été supprimé !');

        return $this->redirectToRoute('manageCandidate');
    }


    /**
     * @Route("/manage/user/collaborateur", name="manageCollaborateur")
     */
    public function showCollaborateur(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $collaborateur = new User();
        $formNewCollaborateur = $this->createForm(AddUserType::class, $collaborateur, ['role'=>$this->getUser()->getRoles()]);
        $formNewCollaborateur->handleRequest($request);

        if($formNewCollaborateur->isSubmitted() && $formNewCollaborateur->isValid())
        {
            $data = $formNewCollaborateur->getData();
            $collaborateur->setPassword($passwordEncoder->encodePassword($collaborateur, $collaborateur->getPassword()));
            $this->entityManager->persist($data);
            $this->entityManager->flush();
            $this->addFlash('creation', 'Le collaborateur "' . $data->getNom().' '. $data->getPrenom(). '" a bien été créé !');
        }

        $collaborateurList= $this->entityManager->getRepository(User::class)->findAll();

        return $this->render('manage/collaborateur.html.twig',[
            'collaborateurList'=>$collaborateurList,
            'formNewCollaborateur'=>$formNewCollaborateur->createView()
        ]);
    }

    /**
     * @Route("user/manage/collaborateur/modification/{idUser}/{idProfil}", name="modifCollaborateur")
     */
    public function modifCollaborateur(Request $request, int $idUser, $idProfil, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $modifCollaborateur = $this->entityManager->getRepository(User::class)->find($idUser);
        $modifCollaborateurForm = $this->createForm(AddUserType::class, $modifCollaborateur,['role'=>$this->getUser()->getRoles()]);
        $modifCollaborateurForm->handleRequest($request);

        if ($modifCollaborateurForm->isSubmitted() && $modifCollaborateurForm->isValid())
        {
            $modifCollaborateur->setPassword($passwordEncoder->encodePassword($modifCollaborateur, $modifCollaborateur->getPassword()));
            $this->entityManager->flush();
            $this->addFlash('modification', 'Le collaborateur a bien été modifié !');

            if($modifCollaborateur->getRoles() === "ROLE_ADMIN" ){
                return $this->redirectToRoute('manageCollaborateur');
            } else{
                return $this->redirectToRoute('singleProfil', ['idUser'=>$idUser, 'idProfil'=>$idProfil]);
            }
        }

        return $this->render('manage/collaborateurModification.html.twig',[
            'modifCollaborateurForm'=>$modifCollaborateurForm->createView(),
            'currentId'=>$idUser,
            'currentIdProfil'=>$idProfil,
            'idUser'=>$idUser
        ]);
    }

    /**
     * @Route("/manage/collaborateur/{idUser}", name="suppCollaborateur")
     */
    public function suppCollaborateur($idUser): Response
    {
        $suppCollaborateur = $this->entityManager->getRepository(User::class)->find($idUser);
        $item = $this->getDoctrine()->getManager();
        $item->remove($suppCollaborateur);
        $item->flush();
        $this->addFlash('suppression', 'Le collaborateur "' . $suppCollaborateur->getNom().' '.$suppCollaborateur->getPrenom().'" a bien été supprimé !');

        return $this->redirectToRoute('manageCollaborateur');
    }
}
