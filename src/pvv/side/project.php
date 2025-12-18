<?php

declare(strict_types=1);

namespace pvv\side;

class Project {
  private int $id;
  private string $title;
  private array $description_en;
  private array $description_no;
  private ?string $gitea_link;
  private ?string $issue_board_link;
  private ?string $wiki_link;
  private array $programming_languages;
  private array $technologies;
  private array $keywords;
  // NOTE: spdx identifier
  private ?string $license;
  private ?string $logo_url;

  public function __construct(
    int $id,
    string $title,
    ?string $description_en,
    ?string $description_no,
    ?string $gitea_link,
    ?string $issue_board_link,
    ?string $wiki_link,
    ?string $programming_languages,
    ?string $technologies,
    ?string $keywords,
    ?string $license,
    ?string $logo_url,
  ) {
    $this->id = $id;
    $this->title = $title;
    $this->description_en
      = $description_en === null || $description_en === ''
        ? []
        : explode("\n", $description_en);
    $this->description_no
      = $description_no === null || $description_no === ''
        ? []
        : explode("\n", $description_no);
    $this->gitea_link = $gitea_link;
    $this->issue_board_link = $issue_board_link;
    $this->wiki_link = $wiki_link;
    $this->programming_languages
      = $programming_languages === null || $programming_languages === ''
        ? []
        : explode(',', $programming_languages);
    $this->technologies
      = $technologies === null || $technologies === ''
        ? []
        : explode(',', $technologies);
    $this->keywords
      = $keywords === null || $keywords === '' ? [] : explode(',', $keywords);
    $this->license = $license;
    $this->logo_url = $logo_url;
  }

  public function getID(): int {
    return $this->id;
  }

  public function getTitle(): string {
    return $this->title;
  }

  /**
   * @return string[]
   */
  public function getDescriptionEn(): array {
    return $this->description_en;
  }

  /**
   * @return string[]
   */
  public function getDescriptionNo(): array {
    return $this->description_no;
  }

  public function getGiteaLink(): ?string {
    return $this->gitea_link;
  }

  public function getIssueBoardLink(): ?string {
    return $this->issue_board_link;
  }

  public function getWikiLink(): ?string {
    return $this->wiki_link;
  }

  /**
   * @return string[]
   */
  public function getProgrammingLanguages(): array {
    return $this->programming_languages;
  }

  /**
   * @return string[]
   */
  public function getTechnologies(): array {
    return $this->technologies;
  }

  /**
   * @return string[]
   */
  public function getKeywords(): array {
    return $this->keywords;
  }

  public function getLicense(): ?string {
    return $this->license;
  }

  public function getLogoURL(): ?string {
    return $this->logo_url;
  }
}
