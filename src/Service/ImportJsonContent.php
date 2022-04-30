<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class ImportJsonContent
{
  protected $entityManager;

  public function __construct(EntityManagerInterface $entityManager)
  {
    $this->entityManager = $entityManager;
  }

  public function todosToDb($url, &$messageArray): bool
  {

    if (!empty($url)) {
      //call api
      $json = file_get_contents($url);
      $json = json_decode($json, TRUE);
    }

    foreach ($json as $getData) {
      $toDo = !empty($getData['title']) ? $getData['title'] : '';

      $sqlSelect = "SELECT id, title FROM to_dos WHERE title LIKE :title";
      $stmtSelect = $this->entityManager->getConnection()->prepare($sqlSelect);
      $s = $stmtSelect->execute(['title' => $toDo])->fetchAssociative();

      if (!empty($s) && !empty($s['id'])) {
        $messageArray['existing_todo'][] = $s['title'];

        $sql = "UPDATE to_dos SET user_id=:user_id, title=:title, completed=:completed";
        $sql .= " WHERE (id = :iid)";
        $stmt = $this->entityManager->getConnection()->prepare($sql);
        $r = $stmt->execute([
          'user_id' => !empty($getData['userId']) ? (int)$getData['userId'] : '',
          'title' => !empty($getData['title']) ? $getData['title'] : ' UPDATED empty ',
          'completed' => !empty($getData['completed']) && $getData['completed'] == TRUE ? 1 : 0,
          'iid' => $s['id'],
        ]);

        if (!$r) $messageArray['skipped_todo'][] = !empty($toDo) ? $toDo : 'empty title';
      } else {
        $sql = "INSERT INTO to_dos (user_id, title, completed) 
          VALUES (:user_id, :title, :completed)";
        $stmt = $this->entityManager->getConnection()->prepare($sql);
        $r = $stmt->execute([
          'user_id' => !empty($getData['userId']) ? (int)$getData['userId'] : '',
          'title' => !empty($getData['title']) ? $getData['title'] : '',
          'completed' => !empty($getData['completed']) && $getData['completed'] == TRUE ? 1 : 0,
        ]);

        if (!$r) $messageArray['skipped_todo'][] = !empty($toDo) ? $toDo : 'empty title';
      }
    }

    return TRUE;
  }
}