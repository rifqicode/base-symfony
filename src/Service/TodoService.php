<?php

declare(strict_types=1);

namespace KejawenLab\Semart\Skeleton\Service;

use KejawenLab\Semart\Skeleton\Contract\Service\ServiceInterface;
use KejawenLab\Semart\Skeleton\Entity\Todo;
use KejawenLab\Semart\Skeleton\Repository\MenuRepository;
use KejawenLab\Semart\Skeleton\Repository\TodoRepository;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author Muhamad Surya Iksanudin <surya.iksanudin@gmail.com>
 */
class TodoService implements ServiceInterface
{
    private $todoRepository;

    private $menuRepository;

    private $securityChecker;

    private $translator;

    public function __construct(
        TodoRepository $todoRepository,
        MenuRepository $menuRepository,
        AuthorizationCheckerInterface $securityChecker,
        TranslatorInterface $translator
    ){
        $todoRepository->setCacheable(true);
        $this->todoRepository = $todoRepository;
        $this->menuRepository = $menuRepository;
        $this->securityChecker = $securityChecker;
        $this->translator = $translator;
    }

    /**
     * @param string $id
     *
     * @return Todo|null
     */
    public function get(string $id): ?object
    {
        return $this->todoRepository->find($id);
    }

    /**
    * @return Todo[]
    */
    public function getActives(): array
    {
        return $this->todoRepository->findAll();
    }

    public function getData($request): array
    {
        $menu = $this->menuRepository->findByCode('TODO');

        $draw = $request->get('draw');
        $limit = $request->get('length');
        $offset = $request->get('start');
        $cond = $request->get('search')['value'];

        $todos = $this->todoRepository->getData($cond, $limit, $offset);
        $todos_count = $this->todoRepository->getData($cond, $limit, $offset, true);

        $data = [];

        if ($request->get('start') == 0) {
            $no =1;
        } else {
            $no = $request->get('start') + 1;
        }

        foreach ($todos as $key) {

            $edit = '';
            $delete = '';

            if($this->securityChecker->isGranted('edit', $menu)) {
                $edit = '<button data-toggle="modal" data-target="#form-modal" data-primary="'.$key->getId().'" data-tooltip="tooltip" title="Edit Data" class="btn btn-xs btn-warning edit margin-r-5"><i class="fa fa-edit"></i> '.$this->translator->trans('label.crud.edit').'</button>';
            }
            if($this->securityChecker->isGranted('delete', $menu)) {
                $delete = '<button data-primary="'.$key->getId().'" class="btn btn-xs btn-xs btn-danger delete" data-tooltip="tooltip" title="Hapus Data"><i class="fa fa-trash"></i> '.$this->translator->trans('label.crud.delete').'</button>';
            }

            $data[] = [
                $no,
                $key->getName(),
                $edit.' '.$delete
            ];

            $no++;
        }

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $todos_count,
            "recordsFiltered" => $todos_count,
            "data" => $data
        );

        return $output;
    }
}
