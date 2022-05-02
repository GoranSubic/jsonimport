<?php

namespace App\Service\Worldcup\Teams;

use Doctrine\ORM\EntityManagerInterface;

class TeamsImportJsonContent
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
    
    foreach ($json as $getData) {
      $team = !empty($getData['id']) ? $getData['id'] : '';
      $country = !empty($getData['country']) ? $getData['country'] : 'NoName';

      // Select query - check if existing team.
      $sqlSelect = "SELECT id, country FROM team WHERE team_id LIKE :team_id";
      $stmtSelect = $this->entityManager->getConnection()->prepare($sqlSelect);
      $s = $stmtSelect->execute(['team_id' => $team])->fetchAssociative();

      // Insert/update query.
      $queryFor = '';
      if (!empty($s) && !empty($s['id'])) {
        $queryFor = 'update';
        $messageArray['existing_team'][] = $s['country'];

        $sql = "UPDATE team SET 
          team_id=:team_id, 
          country=:country, 
          alternate_name=:alternate_name,
          fifa_code=:fifa_code,
          group_id=:group_id,
          group_letter=:group_letter
        ";
        $sql .= " WHERE (id = :iid)";
      } else {
        $queryFor = 'insert';

        $sql = "INSERT INTO team (team_id, country, alternate_name, fifa_code, group_id, group_letter) 
          VALUES (:team_id, :country, :alternate_name, :fifa_code, :group_id, :group_letter)";
      }

      $stmt = $this->entityManager->getConnection()->prepare($sql);
      $params = [
        'team_id' => !empty($getData['id']) ? (int)$getData['id'] : '',
        'country' => !empty($getData['country']) ? $getData['country'] : ' UPDATED empty ',
        'alternate_name' => !empty($getData['alternate_name']) ? $getData['alternate_name'] : '',
        'fifa_code' => !empty($getData['fifa_code']) ? $getData['fifa_code'] : '',
        'group_id' => !empty($getData['group_id']) ? $getData['group_id'] : '',
        'group_letter' => !empty($getData['group_letter']) ? $getData['group_letter'] : '',
      ];
      if ($queryFor === 'update') $params['iid'] = !empty($s) && !empty($s['id']) ? $s['id'] : NULL;
      $r = $stmt->execute($params);

      if (!$r) $messageArray['skipped_todo'][] = $country;
    }
  }
}