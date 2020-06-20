<?php /** @noinspection PhpDocSignatureInspection */

namespace App\Controller;

use App\DTO\TeacherDTO;
use App\Repository\TeacherRepository;
use App\Resource\TeacherResource;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    private TeacherRepository $teacherRepository;

    public function __construct(TeacherRepository $teacherRepository)
    {
        $this->teacherRepository = $teacherRepository;
    }


    /**
     * @Route("/teacher", name="teacher", methods="GET")
     */
    public function index()
    {
        $teachers = $this->teacherRepository->findOneByIdJoinedToUser();
        $data = [];
        foreach ($teachers as $teacher) {
            $data[] = TeacherResource::toArray($teacher);
        }

        return new JsonResponse($data);
    }

    /**
     * @Route("/teacher", methods="POST")
     */
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);
        $dto = new TeacherDTO($data['name'],$data['email'],$data['password']);
        $teacher = $this->teacherRepository->save($dto);

        return new JsonResponse($teacher);
    }

    /**
     * @Route("/teacher/{id}", methods="GET")
     * @throws EntityNotFoundException
     */
    public function show(int $id)
    {
        //dd(__METHOD__);
        $teacher = $this->teacherRepository->findOrFail($id);
        $result = TeacherResource::toArray($teacher);

        return new JsonResponse($result);
    }

    /**
     * @Route("/teacher/{id}", methods="PUT")
     * @throws EntityNotFoundException
     */
    public function update(Request $request, int $id)
    {
        $data = json_decode($request->getContent(), true);
        $dto = new TeacherDTO($data['name'],$data['email'],$data['password']);

        $result = $this->teacherRepository->update($id, $dto);
        return new JsonResponse($result);
    }

    /**
     * @Route("/teacher/{id}", methods="DELETE")
     * @throws EntityNotFoundException
     */
    public function destroy(int $id)
    {
        return new JsonResponse(['status_deleted' => $this->teacherRepository->destroy($id)]);
    }
}
