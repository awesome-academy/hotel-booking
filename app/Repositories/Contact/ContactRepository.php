<?php

namespace App\Repositories\Contact;

use App\Models\Contact;
use App\Repositories\EloquentRepository;
use Illuminate\Support\Facades\Config;

class ContactRepository extends EloquentRepository
{
    public function getModel()
    {
        return Contact::class;
    }

}
