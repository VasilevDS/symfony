<?php /** @noinspection PhpDocSignatureInspection */


namespace App\Controller;


use App\DTO\Request\ThemeCreateDTO;
use App\Service\ThemeService;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ThemeController extends AbstractController
{
    private ThemeService $service;
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;

    public function __construct(ThemeService $service, SerializerInterface $serializer)
    {
        $this->service = $service;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/theme", methods="GET")
     */
    public function index()
    {
        $themesData = $this->service->getAll();
        return $this->json($themesData);
    }

    /**
     * @Route("/theme", methods="POST")
     */
    public function store(Request $request)
    {
        /** @var ThemeCreateDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), ThemeCreateDTO::class, 'json');
        $item = $this->service->add($dto);

        return $this->json($item);
    }

    /**
     * @Route("/theme/{id}", methods="GET")
     * @throws EntityNotFoundException
     */
    public function show(int $id)
    {
        $item = $this->service->get($id);
        return $this->json($item);
    }

    /**
     * @Route("/theme/{id}", methods="PUT")
     * @throws EntityNotFoundException
     */
    public function update(Request $request, int $id)
    {
        /** @var ThemeCreateDTO $dto */
        $dto = $this->serializer->deserialize($request->getContent(), ThemeCreateDTO::class, 'json');
        $item = $this->service->update($id, $dto);

        return $this->json($item);
    }

    /**
     * @Route("/theme/{id}", methods="DELETE")
     * @throws EntityNotFoundException
     */
    public function destroy(int $id)
    {
        $result = $this->service->remove($id);
        return $this->json($result);
    }

}