<?php /** @noinspection PhpDocSignatureInspection */


namespace App\Controller;


use App\DTO\Event\LessonDTO;
use App\Service\LessonService;
use DateTime;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LessonController
{
    private LessonService $service;

    public function __construct(LessonService $service)
    {
        $this->service = $service;
    }

    /**
     * @Route("/lesson", methods="GET")
     */
    public function index()
    {
        $data = $this->service->getAll();
        return new JsonResponse($data);
    }

    /**
     * @Route("/lesson", methods="POST")
     * @throws Exception
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $dto = new LessonDTO(
            $data['id_teacher'],
            $data['id_student'],
            $data['id_theme'],
            $data['id_freetime'],
            new DateTime($data['date_from']),
            new DateTime($data['date_to'])
        );
        $result = $this->service->add($dto);

        return new JsonResponse($result);
    }

    /**
     * @Route("/lesson/{id}", methods="GET")
     */
    public function show(int $id)
    {
        $result = $this->service->get($id);
        return new JsonResponse($result);
    }
    /**
     * @Route("/lesson/{id}", methods="PUT")
     * @throws Exception
     */
    public function update(Request $request, int $id)
    {
        $data = json_decode($request->getContent(), true);
        $dto = new LessonDTO(
            $data['id_teacher'],
            $data['id_student'],
            $data['id_theme'],
            $data['id_freetime'],
            new DateTime($data['date_from']),
            new DateTime($data['date_to'])
        );
        $result = $this->service->update($id, $dto);

        return new JsonResponse($result);
    }

    /**
     * @Route("/lesson/{id}", methods="DELETE")
     */
    public function destroy(int $id)
    {
        $result = $this->service->remove($id);
        return new JsonResponse($result);
    }

}