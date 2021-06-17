<?php

namespace App\Repositories;

use App\Models\Url;

class UrlRepository {

    protected  $url;

    public function __construct(Url $url) {
        $this->url = $url;
    }

    public function save($data) {

        $url = new $this->url;
        $url->original_url = $data['original_url'];
        $url->desirable_url = $data['desirable_url'];
        $url->shortener_url = $data['shortener_url'];
        $url->expiration_date = $data['expiration_date'];
        $url->save();

        return $url->fresh();
    }

    public function getAllUrls() {
        return $this->url->get();
    }

    public function loadUrl($desirableUrl) {
        return $this->url
            ->where('shortener_url', $desirableUrl)
            ->get();
    }

    public function delete($id) {
        $url = $this->url->findOrFail($id)->delete();
        return $url;
    }
}

