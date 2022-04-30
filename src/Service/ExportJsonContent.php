<?php

namespace App\Service;

use App\Repository\ToDosRepository;
use Doctrine\ORM\EntityManagerInterface;

class ExportJsonContent
{
  protected $entityManager;

  protected $toDosRepository;

  public function __construct(EntityManagerInterface $entityManager, ToDosRepository $toDosRepository)
  {
    $this->entityManager = $entityManager;
    $this->toDosRepository = $toDosRepository;
  }

  public function todosFromDb(): string
  {
    $allToDos = $this->toDosRepository->findBy([], ['title' => 'ASC']);
    $json = json_encode($allToDos, JSON_PRETTY_PRINT);

    return $json;
  }
}