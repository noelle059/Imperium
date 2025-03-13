<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseService
{
    protected $database;

    public function __construct()
    {
        // Get the path to the Firebase credentials
        $firebaseCredentialsPath = storage_path('app/firebase-credentials.json');
        if (!file_exists($firebaseCredentialsPath)) {
            throw new \Exception("Firebase credentials file not found at: $firebaseCredentialsPath");
        }

        // The database URL with the "-default-rtdb" suffix
        $firebaseDatabaseUrl = env('FIREBASE_DATABASE_URL', 'https://imperium---classroomautomation-default-rtdb.firebaseio.com');

        // Create a Firebase instance with the service account credentials and database URL
        $this->database = (new Factory)
            ->withServiceAccount($firebaseCredentialsPath)  // Authenticate with Firebase
            ->withDatabaseUri($firebaseDatabaseUrl)         // Set the database URL
            ->createDatabase();
    }

    // Method to get a reference to a specific path in the database
    public function getReference($path)
    {
        return $this->database->getReference($path);
    }

    // Method to set a value in the database
    public function setData($path, $data)
    {
        $this->getReference($path)->set($data);
    }

    // Method to retrieve data from the database
    public function getData($path)
    {
        return $this->getReference($path)->getValue();
    }

    public function getCurrentRFID()
    {
        return $this->getData('rfid/current');
    }

}
