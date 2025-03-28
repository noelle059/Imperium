<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;
use Illuminate\Support\Facades\Cache;

class FirebaseService
{
    protected $database;

    public function __construct()
    {
        // Get Firebase credentials path
        $firebaseCredentialsPath = base_path(env('FIREBASE_CREDENTIALS_PATH', 'storage/app/firebase-credentials.json'));
        if (!file_exists($firebaseCredentialsPath)) {
            throw new \Exception("Firebase credentials file not found at: $firebaseCredentialsPath");
        }

        // Database URL
        $firebaseDatabaseUrl = env('FIREBASE_DATABASE_URL', 'https://imperium---classroomautomation-default-rtdb.firebaseio.com');

        // Initialize Firebase
        $this->database = (new Factory)
            ->withServiceAccount($firebaseCredentialsPath)
            ->withDatabaseUri($firebaseDatabaseUrl)
            ->createDatabase();
    }

    // Get database reference by path
    public function getReference($path)
    {
        return $this->database->getReference($path);
    }

    // Set data at specific path
    public function setData($path, $data)
    {
        try {
            $this->getReference($path)->set($data);
        } catch (\Exception $e) {
            // Log or handle the error
            throw new \Exception("Failed to set data at path: $path. " . $e->getMessage());
        }
    }

    // Retrieve data from Firebase with caching
    public function getData($path)
    {
        // Check if data exists in cache
        return Cache::remember("firebase:$path", 3600, function () use ($path) {
            try {
                return $this->getReference($path)->getValue();
            } catch (\Exception $e) {
                // Log or handle the error
                throw new \Exception("Failed to retrieve data from path: $path. " . $e->getMessage());
            }
        });
    }

    // Get current RFID data
    public function getCurrentRFID()
    {
        return $this->database->getReference('rfid/current')->getValue();
    }

    public function getAccessRFID()
    {
        return $this->database->getReference('rfid/access')->getValue();
    }


    // Fetch device status from Firebase
    public function getDeviceStatus($deviceId)
    {
        return $this->database->getReference('devices/' . $deviceId)->getValue();
    }

    // Update device state in Firebase
    public function updateDeviceState($deviceId, $state)
    {
        $this->database->getReference('devices/' . $deviceId)->set([
            'state' => $state,
        ]);
    }
}
