<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ContactCard extends Component
{
    public $imageUrl;
    public $name;
    public $region;
    public $phone;
    public $whatsappUrl;
    public $instagramUrl;

    public function __construct($imageUrl, $name, $region, $phone, $whatsappUrl, $instagramUrl)
    {
        $this->imageUrl = $imageUrl;
        $this->name = $name;
        $this->region = $region;
        $this->phone = $phone;
        $this->whatsappUrl = $whatsappUrl;
        $this->instagramUrl = $instagramUrl;
    }

    public function render()
    {
        return view('components.contact-card');
    }
}
