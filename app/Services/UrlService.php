<?php

namespace App\Services;


use App\Repositories\UrlRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UrlService {

    protected $urlRepository;

    public function __construct(UrlRepository $urlRepository) {
        $this->urlRepository = $urlRepository;
    }

    public function saveUrlData($data) {
        $validator = Validator::make($data, [
            'original_url' => 'required:url',
            'desirable_url' => 'url',
            'expiration_date' => 'date|after_or_equal:' . date('d-m-Y'),
        ]);

        $data['shortener_url'] = 'http://m2b.io/' . $this->generateRandomString();

        if(array_key_exists('desirable_url', $data)) {
            $findDesirableUrl = $data['desirable_url'];
            $resultUrl = $this->getByDesirableUrl($findDesirableUrl);
            if(count($resultUrl) > 0) {
                throw new \InvalidArgumentException("Url already exists.");
            }else {
                $data['shortener_url'] = $data['desirable_url'];
            }
        }else {
            $data['desirable_url'] = '';
        }

        if(!array_key_exists('expiration_date', $data)) {
            $data['expiration_date'] = date('d-m-Y', strtotime('+7 days'));
        }

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $result = $this->urlRepository->save($data);

        return $result;
    }

    public function getAll() {
        return $this->urlRepository->getAllUrls();
    }

    public function getByDesirableUrl($desirableUrl) {
        return $this->urlRepository->getByDesirableUrl($desirableUrl);
    }

    public function deleteById($id) {
        try {
            $url = $this->urlRepository->delete($id);
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($e->getMessage());
        }
    }

    public function generateRandomString($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }

}
