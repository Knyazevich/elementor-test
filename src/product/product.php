<?php

namespace TwentyTwentyChild\Product;

class Product {
  protected int $id;
  private ?int $mainImageId = null;
  private ?string $mainImageURL = null;
  private ?string $title;
  private ?string $description;
  private ?float $price = null;
  private ?float $salePrice = null;
  private ?bool $isOnSale;
  private ?string $youtubeURL;
  private ?int $productCategory;

  /**
   * @return int
   */
  public function getId(): int {
    return $this->id;
  }

  /**
   * @param int $id
   * @return Product
   */
  public function setId(int $id): Product {
    $this->id = $id;
    return $this;
  }

  /**
   * @return int|null
   */
  public function getMainImageId(): ?int {
    return $this->mainImageId;
  }

  /**
   * @param int|null $mainImageId
   * @return Product
   */
  public function setMainImageId(?int $mainImageId): Product {
    $this->mainImageId = $mainImageId;
    return $this;
  }

  /**
   * @return string|null
   */
  public function getMainImageURL(): ?string {
    return $this->mainImageURL;
  }

  /**
   * @param string|null $mainImageURL
   * @return Product
   */
  public function setMainImageURL(?string $mainImageURL): Product {
    $this->mainImageURL = $mainImageURL;
    return $this;
  }

  /**
   * @return string|null
   */
  public function getTitle(): ?string {
    return $this->title;
  }

  /**
   * @param string|null $title
   * @return Product
   */
  public function setTitle(?string $title): Product {
    $this->title = $title;
    return $this;
  }

  /**
   * @return string|null
   */
  public function getDescription(): ?string {
    return $this->description;
  }

  /**
   * @param string|null $description
   * @return Product
   */
  public function setDescription(?string $description): Product {
    $this->description = $description;
    return $this;
  }

  /**
   * @return float|null
   */
  public function getPrice(): ?float {
    return $this->price;
  }

  /**
   * @param float|null $price
   * @return Product
   */
  public function setPrice(?float $price): Product {
    $this->price = $price;
    return $this;
  }

  /**
   * @return float|null
   */
  public function getSalePrice(): ?float {
    return $this->salePrice;
  }

  /**
   * @param float|null $salePrice
   * @return Product
   */
  public function setSalePrice(?float $salePrice): Product {
    $this->salePrice = $salePrice;
    return $this;
  }

  /**
   * @return bool
   */
  public function isOnSale(): bool {
    return $this->isOnSale;
  }

  /**
   * @param bool $isOnSale
   * @return Product
   */
  public function setIsOnSale(bool $isOnSale): Product {
    $this->isOnSale = $isOnSale;
    return $this;
  }

  /**
   * @return string|null
   */
  public function getYoutubeURL(): ?string {
    return $this->youtubeURL;
  }

  /**
   * @param string|null $youtubeURL
   * @return Product
   */
  public function setYoutubeURL(?string $youtubeURL): Product {
    $this->youtubeURL = $youtubeURL;
    return $this;
  }

  /**
   * @return int
   */
  public function getProductCategory(): int {
    return $this->productCategory;
  }

  /**
   * @param int $productCategory
   * @return Product
   */
  public function setProductCategory(int $productCategory): Product {
    $this->productCategory = $productCategory;
    return $this;
  }

  public function toJSON(): array {
    return [
      'id' => $this->id,
      'mainImageURL' => $this->mainImageURL,
      'title' => $this->title,
      'description' => $this->description,
      'isOnSale' => $this->isOnSale,
      'youtubeURL' => $this->youtubeURL,
      'price' => $this->price ?? null,
      'salePrice' => $this->salePrice ?? null,
      'productCategory' => $this->productCategory ?? 0,
    ];
  }
}
