<?php /** @noinspection PhpDocSignatureInspection */


namespace App\Controller;


use App\DTO\Request\Event\FreetimeCreateDTO;
use App\Service\FreetimeService;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class FreetimeController extends AbstractController
{
    private FreetimeService $service;
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    public function __construct(FreetimeService $service, SerializerInterface $serializer)
    {
        $this->service = $service;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/freetime", methods="GET")
     */
    public function index()
    {
        $freetimeData = $this->service->getAll();
        return $this->json($freetimeData);
    }

    /**
     * @Route("/freetime", methods="POST")
     * @throws Exception
     */
    public function store(Request $request)
    {
        /** @var FreetimeCreateDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), FreetimeCreateDTO::class, 'json');
        $item = $this->service->add($dto);

        return $this->json($item);
    }

    /**
     * @Route("/freetime/{id}", methods="GET")
     * @throws EntityNotFoundException
     */
    public function show(int $id)
    {
        $item = $this->service->get($id);
        return $this->json($item);
    }

    /**
     * @Route("/freetime/{id}", methods="PUT")
     * @throws Exception
     */
    public function update(Request $request, int $id)
    {
        /** @var FreetimeCreateDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), FreetimeCreateDTO::class, 'json');
        $item = $this->service->update($id, $dto);

        return $this->json($item);
    }

    /**
     * @Route("/freetime/{id}", methods="DELETE")
     * @throws EntityNotFoundException
     */
    public function destroy(int $id)
    {
        $result = $this->service->remove($id);
        return $this->json($result);
    }
}