<?php

namespace Marketcall\Models\Affiliate;

use Marketcall\Models\AbstractModel;

class OfferTools extends AbstractModel
{
    public function __construct(
        public bool $keywords,
        public bool $banners,
        public bool $landings,
        public bool $tgbs,
        public bool $promoSites,
        public bool $xmlFeeds,
        public bool $emailTemplates,
        public bool $printingMaterials,
        public bool $videos,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            keywords: $data['keywords'] ?? false,
            banners: $data['banners'] ?? false,
            landings: $data['landings'] ?? false,
            tgbs: $data['tgbs'] ?? false,
            promoSites: $data['promo_sites'] ?? false,
            xmlFeeds: $data['xml_feeds'] ?? false,
            emailTemplates: $data['email_templates'] ?? false,
            printingMaterials: $data['printing_materials'] ?? false,
            videos: $data['videos'] ?? false,
        );
    }

    public function toArray(): array
    {
        return [
            'keywords' => $this->keywords,
            'banners' => $this->banners,
            'landings' => $this->landings,
            'tgbs' => $this->tgbs,
            'promo_sites' => $this->promoSites,
            'xml_feeds' => $this->xmlFeeds,
            'email_templates' => $this->emailTemplates,
            'printing_materials' => $this->printingMaterials,
            'videos' => $this->videos,
        ];
    }
}
