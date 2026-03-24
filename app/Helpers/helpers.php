<?php

if (!function_exists('cuser_id')) {
    /**
     * Obtener el ID del usuario en sesión (Aprendiz, Instructor, Admin o Empresa con usr_id)
     */
    function cuser_id() {
        return session('usr_id');
    }
}

if (!function_exists('cemp_id')) {
    /**
     * Obtener el ID de la empresa en sesión
     */
    function cemp_id() {
        return session('emp_id');
    }
}

if (!function_exists('cnit')) {
    /**
     * Obtener el NIT de la empresa en sesión
     */
    function cnit() {
        return session('nit');
    }
}

if (!function_exists('crole')) {
    /**
     * Obtener el rol actual del usuario
     */
    function crole() {
        return session('rol');
    }
}

if (!function_exists('cname')) {
    /**
     * Obtener el nombre del usuario o empresa en sesión
     */
    function cname() {
        return session('nombre');
    }
}
