<?php

namespace App\Controller;

use App\Entity\Archives;
use App\Entity\Mission;
use App\Entity\User;
use App\Form\ArchivesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;

class ArchivesController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/UserArchives/archives/{idUser}", name="newArchive")
     */
    public function newArchive(Request $request, int $idUser): Response
    {
        $dispo = $this->entityManager->getRepository(Mission::class)->findBy(["user"=>$idUser], ["en_cours"=>"DESC"], 1);;
        if (empty($dispo)){
            $diplayDispo = false;
        } else {
            $diplayDispo = $dispo[0]->getEnCours();
        }

        $currentUser=$this->entityManager->getRepository(User::class)->findOneBy(['id'=>$idUser]);
        $addArchive = new Archives();
        $addArchiveForm = $this->createForm(ArchivesType::class, $addArchive);
        $addArchiveForm->handleRequest($request);

        $prof = $currentUser-> getProfil()->getId();

        if ($addArchiveForm->isSubmitted() && $addArchiveForm->isValid()){

            $archives = $addArchiveForm->get('archive')->getData();
            $fichier = md5(uniqid()) . '.' . $archives->guessExtension();
            $archives->move( $this->getParameter('archives_directory'), $fichier);

            $doc = new Archives();
            $recupNom = $addArchiveForm->get('nom')->getData();
            $doc->setNom($recupNom);
            $doc->setArchive($fichier);
            $currentUser->addArchive($doc);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($currentUser);
            $entityManager->flush();
            $this->addFlash('success', 'Document ajouté !');
            }


        $listDocUser = $this->entityManager->getRepository(Archives::class)->findBy(
            ['user'=>$idUser],["id" => "DESC"], null);


        return $this->render('UserArchives/archives.html.twig', [
            'addArchiveForm' => $addArchiveForm->createView(),
            'listDocUser'=>$listDocUser,
            'idUser'=>$idUser,
            'oneProfil'=>$currentUser,
            'diplayDispo'=>$diplayDispo,
            'idProfil'=> $prof,
        ]);
    }

    /**
     * @Route("/UserArchives/archives/{idArchive}/{idUser}", name="deleteArchive")
     */
    public function deleteArchive(Request $request, int $idArchive, int $idUser): Response
    {

        $suppArchive = $this->entityManager->getRepository(Archives::class)->find($idArchive);
        $item = $this->getDoctrine()->getManager();
        $item->remove($suppArchive);
        $item->flush();

        $this->addFlash('alert', 'Document supprimé !');

        return $this->redirectToRoute('newArchive', ['idUser'=>$idUser]);
    }

    /**
     * @Route("/UserArchives/show/{idArchive}", name="showArchive")
     */
    public function show(Request $request, int $idArchive): Response
    {
        $showArchive = $this->entityManager->getRepository(Archives::class)->find($idArchive);
        $pathArchive = $showArchive->getArchive();
        $kernel = $this->getParameter('kernel.project_dir');

    return $this->file($kernel.'/public/uploads/'.$pathArchive, null, ResponseHeaderBag::DISPOSITION_INLINE);
    }







}
