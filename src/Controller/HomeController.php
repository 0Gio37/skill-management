<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Company;
use App\Entity\LienUserSkill;
use App\Entity\Mission;
use App\Entity\Profil;
use App\Entity\Skill;
use App\Entity\User;
use App\Form\NewMissionUserType;
use App\Form\NewSkillUserType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/", name="home")
     * @IsGranted("ROLE_STRUCTURE")
     */
    public function index(): Response
    {
        $lastUsers = $this->entityManager->getRepository(User::class)->findBy(
            [], ["id" => "DESC"], 10);

        $currentDate = new \DateTime('now');
        $currentMonth= $currentDate->format(('m'));
        $tbCollabCurrentMonth = [];
        $tbCandidCurrentMonth = [];
        $tbCollabModification = [];

        $listUsers = $this->entityManager->getRepository(User::class)->findAll();

        foreach ($listUsers as $el)
        {
            if ($el->getcreatedAt()->format('m') === $currentMonth  && $el->getProfil()->getNom() === "Collaborateur")
            {
               array_push($tbCollabCurrentMonth, $el);
            }
            elseif ($el->getcreatedAt()->format('m') === $currentMonth  && $el->getProfil()->getNom() === "Candidat")
            {
                array_push($tbCandidCurrentMonth, $el);
            }
            if($el->getCreatedAt() != $el->getUpdatedAt() && $el->getUpdatedAt()->format('m') === $currentMonth && $el->getProfil()->getNom() === "Collaborateur")
            {
                array_push($tbCollabModification, $el);
            }
        }

        $sumNewCollabCurrentMonth = count($tbCollabCurrentMonth);
        $sumNewCandidCurrentMonth = count($tbCandidCurrentMonth);
        $sumTbCollabModification = count($tbCollabModification);

        return $this->render('home/index.html.twig',[
            "lastUsers" => $lastUsers,
            "sumNewCollabCurrentMonth" =>$sumNewCollabCurrentMonth,
            "sumNewCandidCurrentMonth"=>$sumNewCandidCurrentMonth,
            "sumTbCollabModification"=>$sumTbCollabModification,
            "tbCollabModification"=>$tbCollabModification,
            "test"=>"test"
        ]);
    }

    /**
     * @Route("/showCollabModif", name="showCollabModif")
     * @IsGranted("ROLE_STRUCTURE")
     */
    public function showCollabModif(): Response
    {

        $currentDate = new \DateTime('now');
        $currentMonth= $currentDate->format(('m'));
        $tbCollabModification = [];
        $listUsers = $this->entityManager->getRepository(User::class)->findAll();
        foreach ($listUsers as $el)
        {
            if ($el->getCreatedAt() != $el->getUpdatedAt() && $el->getcreatedAt()->format('m'
                ) === $currentMonth && $el->getProfil()->getNom() === "Collaborateur") {
                array_push($tbCollabModification, $el);
            }
        }
        return $this->render('home/showCollabModif.html.twig',[
            "tbCollabModification"=>$tbCollabModification
        ]);
    }


    /**
     * @Route ("/profil/{idUser}/{idProfil}", name="singleProfil")
     */
    public function singleProfil(int $idUser, $idProfil): Response
    {

        $oneProfil = $this->entityManager->getRepository(User::class)->findOneBy(["id"=>$idUser]);
        $prof = $this->entityManager->getRepository(Profil::class)->findOneBy(["id"=>$idProfil]);

        return $this->render('home/profil.html.twig',[
            "oneProfil" => $oneProfil,
            "prof" => $prof,
            "idProfil"=>$idProfil,
            "idUser"=>$idUser
            ]);
    }

    /**
     * @Route ("/missions/{idUser}", name="singleProfilMissions")
     */
    public function singleProfilMissions(Request $request, int $idUser): Response
    {
        $user=$this->entityManager->getRepository(User::class)->findOneBy(["id"=>$idUser]);
        $addMissionlUser = new Mission();
        $addMissionlUserForm = $this->createForm(NewMissionUserType::class, $addMissionlUser);
        $addMissionlUserForm->handleRequest($request);

        if($addMissionlUserForm->isSubmitted() && $addMissionlUserForm->isValid())
        {
            $addMissionlUser->setUser($user);
            $data = $addMissionlUserForm->getData();
            $this->entityManager->persist($data);
            $this->entityManager->flush();

            $this->addFlash('success', 'Mission ajoutée !');
        }

        $missionProfil = $this->entityManager->getRepository(Mission::class)->findBy(["user"=>$idUser],["debut"=>"DESC"]);
        $listEntreprise = $this->entityManager->getRepository(Company::class)->findAll();

        return $this->render('home/missions.html.twig', [
            'addMissionlUserForm' => $addMissionlUserForm->createView(),
            'missionProfil' => $missionProfil,
            'listEntreprise' => $listEntreprise,
            'user'=>$user,
            'idUser'=>$idUser
        ]);
    }

    /**
     * @Route ("/missions/modification/{idMission}/{idUser}", name="singleProfilMissionModification")
     */
    public function singleProfilMissionModification(Request $request, int $idMission, int $idUser): Response
    {
        $modifUserMission = $this->entityManager->getRepository(Mission::class)->find($idMission);
        $modifUserMissionForm= $this->createForm(NewMissionUserType::class, $modifUserMission);
        $modifUserMissionForm->handleRequest($request);

        if ($modifUserMissionForm->isSubmitted() && $modifUserMissionForm->isValid())
        {
            $idUserModified = $modifUserMission->getUser()->getId();
            $userModified = $this->entityManager->getRepository(User::class)->findOneBy(["id"=>$idUserModified]);
            $userModified->updateTimestanps();

            $this->entityManager->flush();

            $this->addFlash('info', 'Modification effectuée !');
            return $this->redirectToRoute('singleProfilMissions', ['idUser'=>$idUser]);
        }

        return $this->render('home/missionsModifications.html.twig',[
            'modifUserMissionForm'=>$modifUserMissionForm->createView(),
            'idUser'=>$idUser,
            'modifUserMission'=>$modifUserMission
        ]);
    }

    /**
     * @Route ("/missions/delete/{idMission}/{idUser}", name="singleProfilMissionDelete")
     * @IsGranted("ROLE_ADMIN")
     */
    public function singleProfilMissionDelete(Request $request, int $idMission, int $idUser): Response
    {
        $suppUserMission = $this->entityManager->getRepository(Mission::class)->find($idMission);
        $item = $this->getDoctrine()->getManager();
        $item->remove($suppUserMission);
        $item->flush();

        $this->addFlash('alert', 'Mission supprimée !');

        return $this->redirectToRoute('singleProfilMissions', ['idUser'=>$idUser]);
    }

    /**
     * @Route ("/skills/{idUser}", name="singleProfilSkills")
     */
    public function singleProfilSkills(Request $request, int $idUser): Response
    {
        $user=$this->entityManager->getRepository(User::class)->findOneBy(["id"=>$idUser]);

        $addSkillUser = new LienUserSkill();
        $addSkillUserForm = $this->createForm(NewSkillUserType::class, $addSkillUser);
        $addSkillUserForm->handleRequest($request);

        if($addSkillUserForm->isSubmitted() && $addSkillUserForm->isValid())
        {
            $addSkillUser->setUser($user);
            $data = $addSkillUserForm->getData();
            $this->entityManager->persist($data);
            $this->entityManager->flush();
            $this->addFlash('success', 'Compétence ajoutée !');
        }

        $skillId = $this->entityManager->getRepository(LienUserSkill::class)->findBy(["user"=>$idUser]);
        $listSkill = $this->entityManager->getRepository(Skill::class)->findAll();
        $listCategory = $this->entityManager->getRepository(Category::class)->findAll();

        return $this->render('home/skills.html.twig', [
            'addSkillUserForm'=>$addSkillUserForm->createView(),
            'skillId' => $skillId,
            'listSkill' => $listSkill,
            'listCategory'=> $listCategory,
            'user'=>$user,
            'idUser'=>$idUser
        ]);
    }

    /**
     * @Route ("/skills/modification/{idLienUserSkill}/{idUser}", name="singleProfilSkillModification")
     */
    public function singleProfilSkillModification(Request $request, int $idLienUserSkill, int $idUser): Response
    {
        $modifUserSkill = $this->entityManager->getRepository(LienUserSkill::class)->find($idLienUserSkill);
        $modifUserSkillForm= $this->createForm(NewSkillUserType::class, $modifUserSkill);
        $modifUserSkillForm->handleRequest($request);


        if ($modifUserSkillForm->isSubmitted() && $modifUserSkillForm->isValid())
        {
            $idUserModified = $modifUserSkill->getUser()->getId();
            $userModified = $this->entityManager->getRepository(User::class)->findOneBy(["id"=>$idUserModified]);
            $userModified->updateTimestanps();
            $this->entityManager->flush();
            $this->addFlash('info', 'Compétence modifiée !');
            return $this->redirectToRoute('singleProfilSkills', ['idUser'=>$idUser]);
        }

        return $this->render('home/skillsModifications.html.twig',[
            'modifUserSkillForm'=>$modifUserSkillForm->createView(),
            'idUser'=>$idUser,
            'modifUserSkill'=>$modifUserSkill
            ]);
    }

    /**
     * @Route ("/skills/delete/{idLienUserSkill}/{idUser}", name="singleProfilSkillDelete")
     * @IsGranted("ROLE_ADMIN")
     */
    public function singleProfilSkillDelete(Request $request, int $idLienUserSkill, int $idUser): Response
    {
        $suppUserSkill = $this->entityManager->getRepository(LienUserSkill::class)->find($idLienUserSkill);
        $item = $this->getDoctrine()->getManager();
        $item->remove($suppUserSkill);
        $item->flush();
        $this->addFlash('alert', 'Compétence supprimée !');

        return $this->redirectToRoute('singleProfilSkills', ['idUser'=>$idUser]);
    }

}
