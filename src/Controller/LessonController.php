<?php /** @noinspection PhpDocSignatureInspection */


namespace App\Controller;


use App\DTO\Request\Event\LessonCreateDTO;
use App\Service\LessonService;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class LessonController extends AbstractController
{
    private LessonService $service;
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    public function __construct(LessonService $service, SerializerInterface $serializer)
    {
        $this->service = $service;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/lesson", methods="GET")
     */
    public function index()
    {
        $lessonsData = $this->service->getAll();
        return $this->json($lessonsData);
    }

    /**
     * @Route("/lesson", methods="POST")
     * @throws Exception
     */
    public function store(Request $request)
    {
        /** @var LessonCreateDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), LessonCreateDTO::class, 'json');
        $item = $this->service->add($dto);

        return $this->json($item);
    }

    /**
     * @Route("/lesson/{id}", methods="GET")
     * @throws EntityNotFoundException
     */
    public function show(int $id)
    {
        $item = $this->service->get($id);
        return $this->json($item);
    }

    /**
     * @Route("/lesson/{id}", methods="PUT")
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function update(Request $request, int $id)
    {
        /** @var LessonCreateDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), LessonCreateDTO::class, 'json');
        $item = $this->service->update($id, $dto);

        return $this->json($item);
    }

    /**
     * @Route("/lesson/{id}", methods="DELETE")
     * @throws EntityNotFoundException
     */
    public function destroy(int $id)
    {
        $item = $this->service->remove($id);
        return $this->json($item);
    }

}