<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feed extends Model
{
    /**
     * Gets the RSS feed from the url
     *
     * @return array
     */
    public function getFeed() {
        return simplexml_load_file('https://www.theregister.co.uk/software/headlines.atom');
    }


}
