<?php


class Util
{
    public static function formatDate($date)
    {
        return date('Y-m-d', strtotime($date));
    }

    public static function formatDateTime($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    public static function formatTime($date)
    {
        return date('H:i:s', strtotime($date));
    }

    public static function formatTimezone($date)
    {
        return date('e', strtotime($date));
    }

    public static function formatTimestamp($date)
    {
        return date('Y-m-d\TH:i:s\Z', strtotime($date));
    }

    public static function formatTimestampWithTimezone($date)
    {
        return date('Y-m-d\TH:i:s\Z e', strtotime($date));
    }
}
