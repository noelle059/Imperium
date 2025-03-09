import { initializeApp } from "https://www.gstatic.com/firebasejs/9.9.3/firebase-app.js";
import { getDatabase, ref, set, onValue } from "https://www.gstatic.com/firebasejs/9.9.3/firebase-database.js";

// Firebase config
const firebaseConfig = {
    apiKey: "AIzaSyB8wMtr-QwTxDQ0m86rUTY_BYeP-9z8tMg",
    authDomain: "imperium---classroomautomation.firebaseapp.com",
    databaseURL: "https://imperium---classroomautomation-default-rtdb.firebaseio.com",
    projectId: "imperium---classroomautomation",
    storageBucket: "imperium---classroomautomation.firebasestorage.app",
    messagingSenderId: "1037315551683",
    appId: "1:1037315551683:web:6abb03bc60964037f3cd76",
    measurementId: "G-WF30WFY4HZ"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);
const db = getDatabase(app);

