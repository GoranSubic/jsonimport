<?php

namespace App\Service\Worldcup\Matches;

use Doctrine\ORM\EntityManagerInterface;

class MatchesImportJsonContent
{
  protected $entityManager;

  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
  }

  public function execute(string $url): bool
  {
    $json = [];

    if (!empty($url)) {
      $json = file_get_contents($url);

      $this->savesToDb($json);
      return TRUE;
    }

    return FALSE;
  }

  public function savesToDb(string $json)
  {
    $json = json_decode($json, TRUE);
    
    dd($json[0]);


    foreach ($json as $getData) {
      $toDo = !empty($getData['title']) ? $getData['title'] : '';

      // ToDo select query
      // $sqlSelect = "SELECT id, title FROM matches WHERE title LIKE :title";
      // $stmtSelect = $this->entityManager->getConnection()->prepare($sqlSelect);
      // $s = $stmtSelect->execute(['title' => $toDo])->fetchAssociative();

      // Todo update query
    }
  }
}