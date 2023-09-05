<?php

namespace App\Controller;

use App\Entity\Step;
use App\Entity\Trip;
use App\Entity\Transport;
use App\Entity\Accomodation;
use App\Service\StepManager;
use App\Service\TripManager;
use App\Repository\StepRepository;
use App\Repository\TripRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class StepController extends AbstractController
{
    /**
     * @Route("/api/trips/{id}/steps", name="app_trips_steps", methods={"GET"} )
     */
    public function getStepList(StepRepository $stepRepository): JsonResponse
    {
        $stepList = $stepRepository->findStepsFromTrip();

        return $this->json(
            $stepList,
            200,
            [],
            ['groups' => 'get_collection']
        );
    }

    private $stepManager;
    private $entityManager;

    public function __construct(StepManager $stepManager, EntityManagerInterface $entityManager)
    {

        $this->stepManager = $stepManager;
        $this->entityManager = $entityManager;
    }

    /**
     * 
     * @Route("/api/trip/{id}/step/add", name="api_step_post", methods={"POST"})
     */
    public function createItem(Request $request, SerializerInterface $serializer, ManagerRegistry $managerRegistry, TripManager $tripManager, StepManager    $stepManager, int $id, EntityManagerInterface $entityManager): JsonResponse
    {
        $jsonContent = $request->getContent();

        $trip = $tripManager->getById($id);

        // Désérialisez les données JSON en une instance d'Étape
        $step = $serializer->deserialize($jsonContent, Step::class, 'json');

        // Récupérez les ID de l'accommodation et du transport à partir des données JSON
        $data = json_decode($jsonContent, true);
        $accomodationId = $data['accomodation']['id'];
        $transportId = $data['transport']['id'];

        // Récupérez les entités Accomodation et Transport à partir de la base de données
        $accomodation = $entityManager->getRepository(Accomodation::class)->find($accomodationId);
        $transport = $entityManager->getRepository(Transport::class)->find($transportId);

        // Assurez-vous que l'accommodation et le transport sont associés à l'étape et au voyage corrects
        $step->setAccomodation($accomodation);
        $step->setTransport($transport);
        $step->setTrip($trip);

        // Enregistrez l'étape dans la base de données
        $stepManager->createStep($step);

        return $this->json(
            ['step' => $step],
            201,
            [],
            ['groups' => 'get_collection']
        );
}

    /**
     *
     * @Route("/api/step/{id}", name="api_step_put", methods={"PUT"})
     */
    public function editItem(Request $request, Step $step = null, SerializerInterface $serializer, StepRepository $stepRepository, EntityManagerInterface $entityManager, int $id, TripManager $tripManager)
    {

        if ($step == null) {
            return $this->json(
                'Erreur => Etape non trouvée',
                400,
                [''],
                ['groups' => '']
            );
        }

        $jsonContent = $request->getContent();

        $originalTripId = $step->getTrip()->getId();

        $serializer->deserialize($jsonContent, Step::class, 'json', ['object_to_populate' => $step]);

        $data = json_decode($jsonContent, true);
        $accomodationId = $data['accomodation']['id'];
        $transportId = $data['transport']['id'];

        $accomodation = $entityManager->getRepository(Accomodation::class)->find($accomodationId);
        $transport = $entityManager->getRepository(Transport::class)->find($transportId);
        
        $step->setAccomodation($accomodation);
        $step->setTransport($transport);

        $trip = $tripManager->getById($originalTripId);
        $step->setTrip($trip);

        $stepRepository->add($step, true);

        return $this->json(
            $step,
            200,
            [''],
            ['groups' => 'get_collection']
        );
    }

    /**
    * @Route("/api/trip/{id}/steps", name="api_get_trip_steps", methods ={"GET"})
    */
    public function showStepsTrip(StepManager $stepManager, TripManager $tripManager, $id): Response
    {

        //$trips = $tripsManager -> getTripsForUser($user);
        $trip = $tripManager->getById($id);

            $steps = $stepManager->getStepsForTrip($trip);

            return $this->json(
                ['steps' => $steps],
                200,
                [''],
                ['groups' => 'get_collection']
            );
    }

    /**
     *
     * @Route("/api/step/{id}", name="api_step_delete", methods={"DELETE"})
     */

     public function deleteItem(Step $step, EntityManagerInterface $em, $id): JsonResponse
     {
         $em->remove($step);
         $em->flush();
 
         return new JsonResponse(null, Response::HTTP_NO_CONTENT);
     }
}



