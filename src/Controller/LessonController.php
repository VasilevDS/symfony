<?php /** @noinspection PhpDocSignatureInspection */


namespace App\Controller;


use App\DTO\Event\LessonCreateDTO;
use App\Service\LessonService;
use DateTime;
use Doctrine\ORM\EntityNotFoundException;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LessonController extends AbstractController
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
        $lessonsData = $this->service->getAll();
        return $this->json($lessonsData);
    }

    /**
     * @Route("/lesson", methods="POST")
     * @throws Exception
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $dto = new LessonCreateDTO(
            $data['id_teacher'],
            $data['id_student'],
            $data['id_theme'],
            $data['id_freetime'],
            new DateTime($data['date_from']),
            new DateTime($data['date_to'])
        );
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
        $data = json_decode($request->getContent(), true);
        $dto = new LessonCreateDTO(
            $data['id_teacher'],
            $data['id_student'],
            $data['id_theme'],
            $data['id_freetime'],
            new DateTime($data['date_from']),
            new DateTime($data['date_to'])
        );
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