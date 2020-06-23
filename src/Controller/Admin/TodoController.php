<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Skeleton\Controller\Admin;

use KejawenLab\Semart\Skeleton\Entity\Todo;
use KejawenLab\Semart\Skeleton\Pagination\Paginator;
use KejawenLab\Semart\Skeleton\Service\TodoService;
use KejawenLab\Semart\Skeleton\Request\RequestHandler;
use KejawenLab\Semart\Skeleton\Security\Authorization\Permission;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route("/todos")
 *
 * @Permission(menu="TODO")
 *
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class TodoController extends AdminController
{
    /**
     * @Route("/", methods={"GET"}, name="todos_index", options={"expose"=true})
     *
     * @Permission(actions=Permission::VIEW)
     */
    public function index(Request $request, Paginator $paginator)
    {
//        $page = (int) $request->query->get('p', 1);
//        $sort = $request->query->get('s');
//        $direction = $request->query->get('d');
//        $key = md5(sprintf('%s:%s:%s:%s:%s', __CLASS__, __METHOD__, $page, $sort, $direction));
//        if ($request->isXmlHttpRequest()) {
//            if (!$this->isCached($key)) {
//                $todos = $paginator->paginate(Todo::class, $page);
//                $this->cache($key, $todos);
//            } else {
//                $todos = $this->cache($key);
//            }
//
//            $table = $this->renderView('todo/table-content.html.twig', ['todos' => $todos]);
//            $pagination = $this->renderView('todo/pagination.html.twig', ['todos' => $todos]);
//
//            return new JsonResponse([
//                'table' => $table,
//                'pagination' => $pagination,
//                '_cache_id' => $key,
//            ]);
//        }

        return $this->render('todo/index.html.twig', [
            'title' => $this->getPageTitle(),
//            'cacheId' => $key,
        ]);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="todos_detail", options={"expose"=true})
     *
     * @Permission(actions=Permission::VIEW)
     */
    public function find(string $id, TodoService $service, SerializerInterface $serializer)
    {
        $todo = $service->get($id);
        if (!$todo) {
            throw new NotFoundHttpException();
        }

        return new JsonResponse($serializer->serialize($todo, 'json', ['groups' => ['read']]));
    }

    /**
     * @Route("/save", methods={"POST"}, name="todos_save", options={"expose"=true})
     *
     * @Permission(actions={Permission::ADD, Permission::EDIT})
     */
    public function save(Request $request, TodoService $service, RequestHandler $requestHandler)
    {
        $primary = $request->get('id');
        if ($primary) {
            $todo = $service->get($primary);
        } else {
            $todo = new Todo();
        }

        $requestHandler->handle($request, $todo);
        if (!$requestHandler->isValid()) {
            return new JsonResponse(['status' => 'KO', 'errors' => $requestHandler->getErrors()]);
        }

        $this->commit($todo);

        return new JsonResponse(['status' => 'OK']);
    }

    /**
     * @Route("/{id}/delete", methods={"POST"}, name="todos_remove", options={"expose"=true})
     *
     * @Permission(actions=Permission::DELETE)
     */
    public function delete(string $id, TodoService $service)
    {
        if (!$todo = $service->get($id)) {
            throw new NotFoundHttpException();
        }

        $this->remove($todo);

        return new JsonResponse(['status' => 'OK']);
    }

    /**
     * @Route("/getData/todo", methods={"GET"}, name="todos_get", options={"expose"=true})
     *
     *  @Permission(actions=Permission::VIEW)
     */
    public function getData(Request $request, TodoService $todoService)
    {
        $data = $todoService->getData($request);

        return new JsonResponse($data);
    }
}
