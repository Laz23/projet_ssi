<?php

namespace App;



class TableHelper{

    const SORT_KEY = "sort";
    const DIR_KEY = "dir";


    public static function sort(string $sortKey,string $label,array $data) : string{
        $icon = "";
        $sort = $data[self::SORT_KEY] ?? null;
        $direction = $data[self::DIR_KEY] ?? null;

        if($sort === $sortKey){
            $icon = $direction ==="asc" ? "^" : "v";
        }
        $url = URLHelper::withParams($data,["sort" => $sortKey,
        "dir" =>$direction === "asc" && $sort === $sortKey ? "desc" : "asc"]);
        return <<< HTML
            <a class="text-light" href="?$url">$label $icon</a>
        HTML;
    }
}