<?php

declare(strict_types=1);

namespace pvv\side;

class Project {
  private $id;
  private $title;
  private $descrition_en;
  private $description_no;
  private $gitea_link;
  private $issue_board_link;
  private $wiki_link;
  private $languages;
  private $technologies;
  private $keywords;
  private $license;
  private $logo_url;

  public function __construct(
    int $id,
    string $title,
    string $description_en,
    string $description_no,
    string $gitea_link,
    string $issue_board_link,
    string $wiki_link,
    string $languages,
    string $technologies,
    string $keywords,
    string $license,
    string $logo_url
  ) {
    $this->id = $id;
    $this->title = $title;
    $this->description_en = explode("\n", $description_en);
    $this->description_no = explode("\n", $description_no);
    $this->gitea_link = $gitea_link;
    $this->issue_board_link = $issue_board_link;
    $this->wiki_link = $wiki_link;
    $this->languages = $languages;
    $this->technologies = $technologies;
    $this->keywords = $keywords;
    $this->license = $license;
    $this->logo_url = $logo_url;
  }

  public function getID() {
    return $this->id;
  }

  public function getTitle() {
    return $this->title;
  }
  
  public function getDescriptionEn() {
    return $this->description_en;
  }
  
  public function getDescriptionNo() {
    return $this->description_no;
  }
  
  public function getGiteaLink() {
    return $this->gitea_link;
  }
  
  public function getIssueBoardLink() {
    return $this->issue_board_link;
  }
  
  public function getWikiLink() {
    return $this->wiki_link;
  }
  
  public function getLanguages() {
    return $this->languages;
  }
  
  public function getTechnologies() {
    return $this->technologies;
  }
  
  public function getKeywords() {
    return $this->keywords;
  }
  
  public function getLicense() {
    return $this->license;
  }
  
  public function getLogoURL() {
    return $this->logo_url;
  }
}
