<?php /** @noinspection PhpDocSignatureInspection */

namespace App\Controller;

use App\DTO\User\StudentCreateDTO;
use App\Service\StudentService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class StudentController extends AbstractController
{
    private StudentService $service;
    private SerializerInterface $serializer;

    public function __construct(StudentService $service, SerializerInterface $serializer
    )
    {
        $this->service = $service;
        $this->serializer = $serializer;
    }


    /**
     * @Route("/student", methods="GET")
     */
    public function index()
    {
        $Studentdata = $this->service->getAll();
        return $this->json($Studentdata);
    }

    /**
     * @Route("/student", methods="POST")
     */
    public function store(Request $request)
    {
        /** @var StudentCreateDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), StudentCreateDTO::class, 'json');

        $item = $this->service->add($dto);

        return $this->json($item);
    }

    /**
     * @Route("/student/{id}", methods="GET")
     * @throws EntityNotFoundException
     */
    public function show(int $id)
    {
        $item = $this->service->get($id);
        return $this->json($item);
    }

    /**
     * @Route("/student/{id}", methods="PUT")
     * @throws EntityNotFoundException
     */
    public function update(Request $request, int $id)
    {
        /** @var StudentCreateDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), StudentCreateDTO::class, 'json');

        $item = $this->service->update($id, $dto);

        return $this->json($item);
    }

    /**
     * @Route("/student/{id}", methods="DELETE")
     * @throws EntityNotFoundException
     */
    public function destroy(int $id)
    {
        $result = $this->service->remove($id);
        return $this->json($result);
    }
}
