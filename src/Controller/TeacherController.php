<?php /** @noinspection PhpDocSignatureInspection */

namespace App\Controller;

use App\DTO\User\TeacherCreateDTO;
use App\Service\TeacherService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TeacherController extends AbstractController
{
    private TeacherService $service;
    private SerializerInterface $serializer;
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    public function __construct(TeacherService $service, SerializerInterface $serializer, ValidatorInterface $validator)
    {
        $this->service = $service;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }


    /**
     * @Route("/teacher", name="teacher", methods="GET")
     */
    public function index()
    {
        $teachersData = $this->service->getAll();
        return $this->json($teachersData);
    }

    /**
     * @Route("/teacher", methods="POST")
     */
    public function store(Request $request)
    {
        /** @var TeacherCreateDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), TeacherCreateDTO::class, 'json');
        $item = $this->service->add($dto);

        return $this->json($item);
    }

    /**
     * @Route("/teacher/{id}", methods="GET")
     * @throws EntityNotFoundException
     */
    public function show(int $id)
    {
        $item = $this->service->get($id);
        return $this->json($item);
    }

    /**
     * @Route("/teacher/{id}", methods="PUT")
     * @throws EntityNotFoundException
     */
    public function update(Request $request, int $id)
    {
        /** @var TeacherCreateDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), TeacherCreateDTO::class, 'json');
        $item = $this->service->update($id, $dto);

        return $this->json($item);
    }

    /**
     * @Route("/teacher/{id}", methods="DELETE")
     * @throws EntityNotFoundException
     */
    public function destroy(int $id)
    {
        $result = $this->service->remove($id);
        return $this->json($result);
    }
}
