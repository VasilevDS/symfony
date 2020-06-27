<?php /** @noinspection PhpDocSignatureInspection */


namespace App\Controller;


use App\DTO\Request\Event\FreetimeCreateDTO;
use App\Service\FreetimeService;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FreetimeController extends AbstractController
{
    private FreetimeService $service;

    public function __construct(FreetimeService $service)
    {
        $this->service = $service;
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
    public function store(FreetimeCreateDTO $DTO)
    {
        $item = $this->service->add($DTO);
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
    public function update(FreetimeCreateDTO $DTO, int $id)
    {
        $item = $this->service->update($id, $DTO);
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