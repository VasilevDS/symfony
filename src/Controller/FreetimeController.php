<?php /** @noinspection PhpDocSignatureInspection */


namespace App\Controller;


use App\DTO\Event\FreetimeDTO;
use App\Service\FreetimeService;
use DateTime;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FreetimeController
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
        $data = $this->service->getAll();
        return new JsonResponse($data);
    }

    /**
     * @Route("/freetime", methods="POST")
     * @throws Exception
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $dto = new FreetimeDTO(
            $data['id_teacher'],
            new DateTime($data['date_from']),
            new DateTime($data['date_to'])
        );
        $result = $this->service->add($dto);

        return new JsonResponse($result);
    }

    /**
     * @Route("/freetime/{id}", methods="GET")
     */
    public function show(int $id)
    {
        $result = $this->service->get($id);
        return new JsonResponse($result);
    }

    /**
     * @Route("/freetime/{id}", methods="PUT")
     * @throws Exception
     */
    public function update(Request $request, int $id)
    {
        $data = json_decode($request->getContent(), true);
        $dto = new FreetimeDTO(
            $data['id_teacher'],
            new DateTime($data['date_from']),
            new DateTime($data['date_to'])
        );
        $result = $this->service->update($id, $dto);

        return new JsonResponse($result);
    }

    /**
     * @Route("/freetime/{id}", methods="DELETE")
     */
    public function destroy(int $id)
    {
        $result = $this->service->remove($id);
        return new JsonResponse($result);
    }
}