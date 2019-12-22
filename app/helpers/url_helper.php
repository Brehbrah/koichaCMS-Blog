<?php 
    // helper function is not a class. It's just basically a function to support
    
    // Simple page redirect
    function redirect($page) {
        return header('location: ' . URLROOT . '/' . $page);
    }
?>