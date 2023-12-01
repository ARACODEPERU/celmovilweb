<?php

use Carbon\Carbon;

if (!function_exists('date_time_format')) {
    function date_time_format($date = null)
    {
        if ($date == null) {
            return Carbon::now()->format('d/m/Y \a \l\a\s H:i \h\o\r\a\s');
        } else {
            return Carbon::parse($date)->format('d/m/Y \a \l\a\s H:i \h\o\r\a\s');
        }
    }
}

if (!function_exists('formatShortMonth')) {
    function formatShortMonth($fecha)
    {
        // Convierte la fecha en un objeto Carbon
        $fechaCarbon = Carbon::parse($fecha);

        // Obtén el día del mes, el nombre del mes y el año
        $dia = $fechaCarbon->format('d');
        $nombreMes = $fechaCarbon->format('M');
        $anio = $fechaCarbon->format('Y');

        // Mapea los nombres de los meses en español
        $nombresMeses = [
            'Jan' => 'Ene',
            'Feb' => 'Feb',
            'Mar' => 'Mar',
            'Apr' => 'Abr',
            'May' => 'May',
            'Jun' => 'Jun',
            'Jul' => 'Jul',
            'Aug' => 'Ago',
            'Sep' => 'Sep',
            'Oct' => 'Oct',
            'Nov' => 'Nov',
            'Dec' => 'Dic',
        ];

        // Traduce el nombre del mes
        $nombreMesTraducido = $nombresMeses[$nombreMes] ?? $nombreMes;

        // Formatea la fecha en el formato deseado
        $fechaFormateada = "{$dia}, {$nombreMesTraducido} {$anio}";

        return $fechaFormateada;
    }
}
